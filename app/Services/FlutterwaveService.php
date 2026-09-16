<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Ticket;
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
     * Initialize a payment transaction (donation or summit ticket).
     */
    public function initializePayment(array $paymentData): array
    {
        try {
            $isTicket = ($paymentData['type'] ?? '') === 'ticket';
            $ticketType = $paymentData['ticket_type'] ?? null;
            $ticketConfig = null;

            if ($isTicket) {
                $ticketConfig = config("summit.tickets.{$ticketType}");
                if (! $ticketConfig) {
                    return [
                        'success' => false,
                        'message' => 'Invalid ticket type selected.',
                    ];
                }
                // Never trust client-supplied amounts for tickets.
                $paymentData['amount'] = (float) $ticketConfig['price'];

                $subaccountId = config('services.flutterwave.ticket_subaccount_id');
                $mainShare = (float) config('services.flutterwave.ticket_main_share', 3000);

                if (! $subaccountId) {
                    Log::error('Ticket payment split missing FLW_TICKET_SUBACCOUNT_ID');

                    return [
                        'success' => false,
                        'message' => 'Ticket payments are temporarily unavailable. Please try again later.',
                    ];
                }

                if ($paymentData['amount'] <= $mainShare) {
                    Log::error('Ticket amount too low for configured main share', [
                        'amount' => $paymentData['amount'],
                        'main_share' => $mainShare,
                    ]);

                    return [
                        'success' => false,
                        'message' => 'Ticket amount is too low to process this payment.',
                    ];
                }
            }

            $referenceNumber = Payment::generateReferenceNumber();

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
                    'source' => $paymentData['source'] ?? 'website',
                    'donation_type' => $paymentData['type'] ?? 'foundation',
                    'project_id' => $paymentData['project_id'] ?? null,
                    'ticket_type' => $ticketType,
                ],
            ]);

            if ($isTicket) {
                Ticket::create([
                    'payment_id' => $payment->id,
                    'code' => Ticket::generateCode(),
                    'ticket_type' => $ticketType,
                    'attendee_name' => $paymentData['name'],
                    'attendee_email' => $paymentData['email'],
                    'attendee_phone' => $paymentData['phone'],
                    'status' => Ticket::STATUS_PENDING,
                ]);
            }

            $title = $isTicket
                ? 'GBSAAC 2026 — ' . $ticketConfig['name']
                : 'Anyen Iyak Foundation Donation';

            $description = $isTicket
                ? $ticketConfig['name'] . ' (' . $ticketConfig['day_label'] . ')'
                : ucfirst($paymentData['type'] ?? 'foundation') . ' Donation';

            $payload = [
                'tx_ref' => $referenceNumber,
                'amount' => (float) $paymentData['amount'],
                'currency' => 'NGN',
                'redirect_url' => route('payment.callback'),
                'payment_options' => 'card,banktransfer,ussd,mobilemoney',
                'customer' => [
                    'email' => $paymentData['email'],
                    'name' => $paymentData['name'],
                    'phonenumber' => $paymentData['phone'],
                ],
                'customizations' => [
                    'title' => $title,
                    'description' => $description,
                    'logo' => url('/favicon.ico'),
                ],
                'meta' => [
                    'payment_id' => $payment->id,
                    'donor_name' => $paymentData['name'],
                    'donor_phone' => $paymentData['phone'],
                    'donation_type' => $paymentData['type'] ?? 'foundation',
                    'project_id' => $paymentData['project_id'] ?? null,
                    'ticket_type' => $ticketType,
                ],
            ];

            // Donations settle fully to the primary account (Fidelity).
            // Tickets: primary keeps a flat share; the configured subaccount (Wema) gets the remainder.
            if ($isTicket) {
                $payload['subaccounts'] = [
                    [
                        'id' => config('services.flutterwave.ticket_subaccount_id'),
                        'transaction_charge_type' => 'flat',
                        'transaction_charge' => (float) config('services.flutterwave.ticket_main_share', 3000),
                    ],
                ];
            }

            Log::info('Flutterwave payment initialization request', [
                'reference' => $referenceNumber,
                'amount' => $payload['amount'],
                'type' => $paymentData['type'] ?? 'foundation',
                'split' => $payload['subaccounts'] ?? null,
            ]);

            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/payments', $payload);

            $result = $response->json();

            Log::info('Flutterwave initialization response', [
                'status' => $response->status(),
                'result' => $result,
            ]);

            if ($response->successful() && isset($result['status']) && $result['status'] === 'success') {
                $payment->update([
                    'payment_reference' => $referenceNumber,
                    'payment_link' => $result['data']['link'] ?? null,
                    'status' => 'processing',
                ]);

                Log::info('Flutterwave payment initialized successfully', [
                    'reference' => $referenceNumber,
                    'payment_id' => $payment->id,
                    'link' => $result['data']['link'] ?? null,
                ]);

                return [
                    'success' => true,
                    'data' => [
                        'authorization_url' => $result['data']['link'],
                        'reference' => $referenceNumber,
                        'payment_id' => $payment->id,
                        'internal_reference' => $referenceNumber,
                    ],
                ];
            }

            $payment->markAsFailed('Flutterwave initialization failed');

            Log::error('Flutterwave initialization failed', [
                'reference' => $referenceNumber,
                'status' => $response->status(),
                'result' => $result,
            ]);

            return [
                'success' => false,
                'message' => 'Unable to initialize payment. Please try again.',
                'error' => $result['message'] ?? 'Unknown error',
            ];
        } catch (Exception $e) {
            Log::error('Flutterwave initialization error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            if (isset($payment)) {
                $payment->markAsFailed('Exception: ' . $e->getMessage());
            }

            return [
                'success' => false,
                'message' => 'Payment initialization failed. Please try again.',
                'error' => $e->getMessage(),
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
                'transaction_id' => $transactionId,
            ]);

            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/transactions/' . $transactionId . '/verify');

            $result = $response->json();

            Log::info('Flutterwave verification response', [
                'transaction_id' => $transactionId,
                'status' => $response->status(),
                'result' => $result,
            ]);

            if ($response->successful() && isset($result['status']) && $result['status'] === 'success') {
                $data = $result['data'];

                $payment = Payment::where('payment_reference', $data['tx_ref'])
                    ->orWhere('reference_number', $data['tx_ref'])
                    ->first();

                if (! $payment) {
                    Log::error('Payment record not found', [
                        'tx_ref' => $data['tx_ref'],
                    ]);

                    return [
                        'success' => false,
                        'message' => 'Payment record not found',
                    ];
                }

                if ($data['status'] === 'successful' && $data['amount'] >= $payment->amount) {
                    $wasAlreadySuccessful = $payment->status === 'successful';

                    $payment->update([
                        'status' => 'successful',
                        'paid_at' => $payment->paid_at ?? now(),
                        'payment_transaction_id' => $data['id'],
                        'payment_method' => $data['payment_type'] ?? null,
                        'payment_channel' => $data['payment_type'] ?? null,
                        'card_type' => $data['card']['type'] ?? null,
                        'last4' => $data['card']['last_4digits'] ?? null,
                        'bank' => $data['card']['issuer'] ?? null,
                        'payment_response' => $result['data'],
                    ]);

                    if (! $payment->receipt_number) {
                        $payment->update([
                            'receipt_number' => Payment::generateReceiptNumber(),
                        ]);
                    }

                    if ($payment->isTicket()) {
                        $this->fulfillTicket($payment, ! $wasAlreadySuccessful);
                    }

                    Log::info('Payment marked as successful', [
                        'payment_id' => $payment->id,
                        'reference' => $payment->reference_number,
                    ]);

                    return [
                        'success' => true,
                        'data' => [
                            'payment' => $payment->fresh(['ticket']),
                            'transaction' => $data,
                        ],
                    ];
                }

                $payment->markAsFailed($data['status'] ?? 'Payment failed');

                Log::warning('Payment verification failed', [
                    'payment_id' => $payment->id,
                    'status' => $data['status'],
                    'amount_paid' => $data['amount'],
                    'amount_expected' => $payment->amount,
                ]);

                return [
                    'success' => false,
                    'message' => 'Payment was not successful',
                    'data' => ['payment' => $payment],
                ];
            }

            Log::error('Flutterwave verification failed', [
                'transaction_id' => $transactionId,
                'status' => $response->status(),
                'result' => $result,
            ]);

            return [
                'success' => false,
                'message' => 'Unable to verify payment',
                'error' => $result['message'] ?? 'Unknown error',
            ];
        } catch (Exception $e) {
            Log::error('Flutterwave verification error: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment verification failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Mark ticket paid and send confirmation email once.
     */
    protected function fulfillTicket(Payment $payment, bool $sendEmail = true): void
    {
        $ticket = $payment->ticket;

        if (! $ticket) {
            Log::error('Ticket payment missing ticket row', ['payment_id' => $payment->id]);

            return;
        }

        $ticket->markPaid();

        if (! $sendEmail || $payment->receipt_sent) {
            return;
        }

        $sent = app(\App\Services\TicketMailService::class)->sendConfirmation($ticket);

        if ($sent) {
            $payment->update([
                'receipt_sent' => true,
                'receipt_sent_at' => now(),
            ]);
        }
    }

    public function getCustomerTransactions(string $email): array
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/transactions', [
                'customer_email' => $email,
            ]);

            $result = $response->json();

            return [
                'success' => $response->successful(),
                'data' => $result['data'] ?? [],
            ];
        } catch (Exception $e) {
            Log::error('Flutterwave get transactions error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Unable to fetch transactions',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function refundTransaction(int $transactionId, float $amount = null): array
    {
        try {
            $payload = [
                'id' => $transactionId,
            ];

            if ($amount) {
                $payload['amount'] = $amount;
            }

            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/transactions/' . $transactionId . '/refund', $payload);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] === 'success') {
                $payment = Payment::where('payment_transaction_id', $transactionId)->first();
                if ($payment) {
                    $payment->update([
                        'refunded' => true,
                        'refund_amount' => $amount ? $amount : $payment->amount,
                        'refunded_at' => now(),
                    ]);
                }

                Log::info('Payment refunded successfully', [
                    'transaction_id' => $transactionId,
                    'amount' => $amount,
                ]);

                return [
                    'success' => true,
                    'data' => $result['data'],
                ];
            }

            return [
                'success' => false,
                'message' => 'Refund failed',
                'error' => $result['message'] ?? 'Unknown error',
            ];
        } catch (Exception $e) {
            Log::error('Flutterwave refund error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Refund failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function handleWebhook(array $payload): array
    {
        try {
            $secretHash = config('services.flutterwave.webhook_hash');
            $signature = request()->header('verif-hash');

            if (! $secretHash || $signature !== $secretHash) {
                Log::warning('Invalid webhook signature', [
                    'received' => $signature,
                    'expected' => $secretHash,
                ]);

                return [
                    'success' => false,
                    'message' => 'Invalid signature',
                ];
            }

            $txRef = $payload['txRef'] ?? $payload['tx_ref'] ?? null;
            $transactionId = $payload['id'] ?? $payload['flwRef'] ?? null;

            if ($txRef && $transactionId) {
                return $this->verifyPayment((string) $transactionId);
            }

            return [
                'success' => false,
                'message' => 'Invalid webhook payload',
            ];
        } catch (Exception $e) {
            Log::error('Webhook handling error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Webhook processing failed',
                'error' => $e->getMessage(),
            ];
        }
    }
}
