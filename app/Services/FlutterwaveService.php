<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class FlutterwaveService
{
    protected $secretKey;
    protected $publicKey;
    protected $encryptionKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('services.flutterwave.secret_key');
        $this->publicKey = config('services.flutterwave.public_key');
        $this->encryptionKey = config('services.flutterwave.encryption_key');
        $this->baseUrl = 'https://api.flutterwave.com/v3';
    }

    /**
     * Initialize a payment transaction
     */
    public function initializePayment(array $paymentData): array
    {
        try {
            // Generate our internal reference
            $referenceNumber = Payment::generateReferenceNumber();
            
            // Create payment record in our database
            $payment = Payment::create([
                'reference_number' => $referenceNumber,
                'donor_name' => $paymentData['name'],
                'donor_email' => $paymentData['email'],
                'donor_phone' => $paymentData['phone'],
                'amount' => $paymentData['amount'],
                'donation_type' => $paymentData['type'] ?? 'foundation',
                'project_id' => $paymentData['project_id'] ?? null,
                'message' => $paymentData['message'] ?? null,
                'status' => 'pending',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'metadata' => [
                    'source' => 'website',
                    'donation_type' => $paymentData['type'] ?? 'foundation',
                    'project_id' => $paymentData['project_id'] ?? null,
                ]
            ]);

            // Prepare Flutterwave payment data
            $payload = [
                'tx_ref' => $referenceNumber,
                'amount' => (float) $paymentData['amount'],
                'currency' => 'NGN',
                'redirect_url' => route('payment.callback'),
                'payment_options' => 'card,banktransfer,ussd,mobilemoney',
                'customer' => [
                    'email' => $paymentData['email'],
                    'name' => $paymentData['name'],
                    'phonenumber' => $paymentData['phone']
                ],
                'customizations' => [
                    'title' => 'Anyen Iyak Foundation Donation',
                    'description' => ucfirst($paymentData['type'] ?? 'foundation') . ' Donation',
                    'logo' => url('/favicon.ico')
                ],
                'meta' => [
                    'payment_id' => $payment->id,
                    'donor_name' => $paymentData['name'],
                    'donor_phone' => $paymentData['phone'],
                    'donation_type' => $paymentData['type'] ?? 'foundation',
                    'project_id' => $paymentData['project_id'] ?? null,
                ]
            ];

            Log::info('Flutterwave payment initialization request', [
                'reference' => $referenceNumber,
                'amount' => $payload['amount']
            ]);

            // Make API request to Flutterwave
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for development (Windows fix)
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . '/payments', $payload);

            $result = $response->json();

            Log::info('Flutterwave initialization response', [
                'status' => $response->status(),
                'result' => $result
            ]);

            if ($response->successful() && isset($result['status']) && $result['status'] === 'success') {
                // Update payment with Flutterwave details
                $payment->update([
                    'payment_reference' => $referenceNumber,
                    'payment_link' => $result['data']['link'] ?? null,
                    'status' => 'processing'
                ]);

                Log::info('Flutterwave payment initialized successfully', [
                    'reference' => $referenceNumber,
                    'payment_id' => $payment->id,
                    'link' => $result['data']['link'] ?? null
                ]);

                return [
                    'success' => true,
                    'data' => [
                        'authorization_url' => $result['data']['link'],
                        'reference' => $referenceNumber,
                        'payment_id' => $payment->id,
                        'internal_reference' => $referenceNumber
                    ]
                ];
            } else {
                $payment->markAsFailed('Flutterwave initialization failed');
                
                Log::error('Flutterwave initialization failed', [
                    'reference' => $referenceNumber,
                    'status' => $response->status(),
                    'result' => $result
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Unable to initialize payment. Please try again.',
                    'error' => $result['message'] ?? 'Unknown error'
                ];
            }

        } catch (Exception $e) {
            Log::error('Flutterwave initialization error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            if (isset($payment)) {
                $payment->markAsFailed('Exception: ' . $e->getMessage());
            }
            
            return [
                'success' => false,
                'message' => 'Payment initialization failed. Please try again.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify a payment transaction
     */
    public function verifyPayment(string $transactionId): array
    {
        try {
            Log::info('Flutterwave verification started', [
                'transaction_id' => $transactionId
            ]);

            // Make API request to verify transaction
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for development (Windows fix)
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/transactions/' . $transactionId . '/verify');

            $result = $response->json();

            Log::info('Flutterwave verification response', [
                'transaction_id' => $transactionId,
                'status' => $response->status(),
                'result' => $result
            ]);

            if ($response->successful() && isset($result['status']) && $result['status'] === 'success') {
                $data = $result['data'];
                
                // Find payment by reference
                $payment = Payment::where('payment_reference', $data['tx_ref'])
                    ->orWhere('reference_number', $data['tx_ref'])
                    ->first();

                if (!$payment) {
                    Log::error('Payment record not found', [
                        'tx_ref' => $data['tx_ref']
                    ]);
                    
                    return [
                        'success' => false,
                        'message' => 'Payment record not found'
                    ];
                }

                // Update payment based on Flutterwave response
                if ($data['status'] === 'successful' && $data['amount'] >= $payment->amount) {
                    $payment->update([
                        'status' => 'successful',
                        'paid_at' => now(),
                        'payment_transaction_id' => $data['id'],
                        'payment_method' => $data['payment_type'] ?? null,
                        'payment_channel' => $data['payment_type'] ?? null,
                        'card_type' => $data['card']['type'] ?? null,
                        'last4' => $data['card']['last_4digits'] ?? null,
                        'bank' => $data['card']['issuer'] ?? null,
                        'payment_response' => $result['data']
                    ]);

                    // Generate receipt number
                    if (!$payment->receipt_number) {
                        $payment->update([
                            'receipt_number' => Payment::generateReceiptNumber()
                        ]);
                    }

                    Log::info('Payment marked as successful', [
                        'payment_id' => $payment->id,
                        'reference' => $payment->reference_number
                    ]);

                    return [
                        'success' => true,
                        'data' => [
                            'payment' => $payment,
                            'transaction' => $data
                        ]
                    ];
                } else {
                    $payment->markAsFailed($data['status'] ?? 'Payment failed');
                    
                    Log::warning('Payment verification failed', [
                        'payment_id' => $payment->id,
                        'status' => $data['status'],
                        'amount_paid' => $data['amount'],
                        'amount_expected' => $payment->amount
                    ]);
                    
                    return [
                        'success' => false,
                        'message' => 'Payment was not successful',
                        'data' => ['payment' => $payment]
                    ];
                }
            } else {
                Log::error('Flutterwave verification failed', [
                    'transaction_id' => $transactionId,
                    'status' => $response->status(),
                    'result' => $result
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Unable to verify payment',
                    'error' => $result['message'] ?? 'Unknown error'
                ];
            }

        } catch (Exception $e) {
            Log::error('Flutterwave verification error: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Payment verification failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get all transactions for a customer
     */
    public function getCustomerTransactions(string $email): array
    {
        try {
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for development (Windows fix)
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/transactions', [
                'customer_email' => $email
            ]);

            $result = $response->json();

            return [
                'success' => $response->successful(),
                'data' => $result['data'] ?? []
            ];

        } catch (Exception $e) {
            Log::error('Flutterwave get transactions error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Unable to fetch transactions',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Refund a transaction
     */
    public function refundTransaction(int $transactionId, float $amount = null): array
    {
        try {
            $payload = [
                'id' => $transactionId
            ];
            
            if ($amount) {
                $payload['amount'] = $amount;
            }

            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for development (Windows fix)
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . '/transactions/' . $transactionId . '/refund', $payload);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] === 'success') {
                // Update payment record
                $payment = Payment::where('payment_transaction_id', $transactionId)->first();
                if ($payment) {
                    $payment->update([
                        'refunded' => true,
                        'refund_amount' => $amount ? $amount : $payment->amount,
                        'refunded_at' => now()
                    ]);
                }

                Log::info('Payment refunded successfully', [
                    'transaction_id' => $transactionId,
                    'amount' => $amount
                ]);

                return [
                    'success' => true,
                    'data' => $result['data']
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Refund failed',
                    'error' => $result['message'] ?? 'Unknown error'
                ];
            }

        } catch (Exception $e) {
            Log::error('Flutterwave refund error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Refund failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get Flutterwave public key for frontend
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * Handle webhook events from Flutterwave
     */
    public function handleWebhook(array $payload): array
    {
        try {
            // Verify webhook signature
            $secretHash = config('services.flutterwave.webhook_hash');
            $signature = request()->header('verif-hash');
            
            if (!$secretHash || $signature !== $secretHash) {
                Log::warning('Invalid webhook signature', [
                    'received' => $signature,
                    'expected' => $secretHash
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Invalid signature'
                ];
            }

            // Process the webhook
            $txRef = $payload['txRef'] ?? $payload['tx_ref'] ?? null;
            $transactionId = $payload['flwRef'] ?? $payload['id'] ?? null;
            
            if ($txRef && $transactionId) {
                // Verify the transaction
                return $this->verifyPayment($transactionId);
            }

            return [
                'success' => false,
                'message' => 'Invalid webhook payload'
            ];

        } catch (Exception $e) {
            Log::error('Webhook handling error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Webhook processing failed',
                'error' => $e->getMessage()
            ];
        }
    }
}
