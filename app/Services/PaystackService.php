<?php

namespace App\Services;

use App\Models\Payment;
use Yabacon\Paystack;
use Illuminate\Support\Facades\Log;
use Exception;

class PaystackService
{
    protected $paystack;
    protected $secretKey;
    protected $publicKey;

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
        $this->publicKey = config('services.paystack.public_key');
        $this->paystack = new Paystack($this->secretKey);
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

            // Prepare Paystack transaction data
            $tranx = $this->paystack->transaction->initialize([
                'amount' => $paymentData['amount'] * 100, // Convert to kobo
                'email' => $paymentData['email'],
                'reference' => $referenceNumber, // Use our reference
                'callback_url' => route('payment.callback'),
                'metadata' => [
                    'payment_id' => $payment->id,
                    'donor_name' => $paymentData['name'],
                    'donor_phone' => $paymentData['phone'],
                    'donation_type' => $paymentData['type'] ?? 'foundation',
                    'project_id' => $paymentData['project_id'] ?? null,
                    'custom_fields' => [
                        [
                            'display_name' => 'Donation Type',
                            'variable_name' => 'donation_type',
                            'value' => ucfirst($paymentData['type'] ?? 'foundation')
                        ],
                        [
                            'display_name' => 'Phone Number',
                            'variable_name' => 'phone',
                            'value' => $paymentData['phone']
                        ]
                    ]
                ]
            ]);

            if ($tranx->status) {
                // Update payment with Paystack details
                $payment->update([
                    'paystack_reference' => $tranx->data->reference,
                    'paystack_access_code' => $tranx->data->access_code,
                    'status' => 'processing'
                ]);

                return [
                    'success' => true,
                    'data' => [
                        'authorization_url' => $tranx->data->authorization_url,
                        'access_code' => $tranx->data->access_code,
                        'reference' => $tranx->data->reference,
                        'payment_id' => $payment->id,
                        'internal_reference' => $referenceNumber
                    ]
                ];
            } else {
                $payment->markAsFailed('Paystack initialization failed');
                
                return [
                    'success' => false,
                    'message' => 'Unable to initialize payment. Please try again.',
                    'error' => $tranx->message ?? 'Unknown error'
                ];
            }

        } catch (Exception $e) {
            Log::error('Paystack initialization error: ' . $e->getMessage());
            
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
    public function verifyPayment(string $reference): array
    {
        try {
            $tranx = $this->paystack->transaction->verify([
                'reference' => $reference
            ]);

            if ($tranx->status) {
                $data = $tranx->data;
                
                // Find payment by reference
                $payment = Payment::where('paystack_reference', $reference)
                    ->orWhere('reference_number', $reference)
                    ->first();

                if (!$payment) {
                    return [
                        'success' => false,
                        'message' => 'Payment record not found'
                    ];
                }

                // Update payment based on Paystack response
                if ($data->status === 'success') {
                    $payment->update([
                        'status' => 'successful',
                        'paid_at' => now(),
                        'paystack_transaction_id' => $data->id,
                        'payment_method' => $data->channel,
                        'payment_channel' => $data->channel,
                        'authorization_code' => $data->authorization->authorization_code ?? null,
                        'card_type' => $data->authorization->card_type ?? null,
                        'last4' => $data->authorization->last4 ?? null,
                        'bank' => $data->authorization->bank ?? null,
                        'paystack_response' => $tranx->data
                    ]);

                    // Generate receipt number
                    if (!$payment->receipt_number) {
                        $payment->update([
                            'receipt_number' => Payment::generateReceiptNumber()
                        ]);
                    }

                    return [
                        'success' => true,
                        'data' => [
                            'payment' => $payment,
                            'transaction' => $data
                        ]
                    ];
                } else {
                    $payment->markAsFailed($data->gateway_response ?? 'Payment failed');
                    
                    return [
                        'success' => false,
                        'message' => 'Payment was not successful',
                        'data' => ['payment' => $payment]
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Unable to verify payment'
                ];
            }

        } catch (Exception $e) {
            Log::error('Paystack verification error: ' . $e->getMessage());
            
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
            $tranx = $this->paystack->transaction->getList([
                'customer' => $email
            ]);

            return [
                'success' => true,
                'data' => $tranx->data
            ];

        } catch (Exception $e) {
            Log::error('Paystack get transactions error: ' . $e->getMessage());
            
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
    public function refundTransaction(string $reference, int $amount = null): array
    {
        try {
            $data = ['transaction' => $reference];
            if ($amount) {
                $data['amount'] = $amount * 100; // Convert to kobo
            }

            $refund = $this->paystack->refund->create($data);

            if ($refund->status) {
                // Update payment record
                $payment = Payment::where('paystack_reference', $reference)->first();
                if ($payment) {
                    $payment->update([
                        'refunded' => true,
                        'refund_amount' => $amount ? $amount : $payment->amount,
                        'refunded_at' => now()
                    ]);
                }

                return [
                    'success' => true,
                    'data' => $refund->data
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Refund failed',
                    'error' => $refund->message
                ];
            }

        } catch (Exception $e) {
            Log::error('Paystack refund error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Refund failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get Paystack public key for frontend
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }
} 