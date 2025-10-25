<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlutterwaveService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $flutterwaveService;

    public function __construct(FlutterwaveService $flutterwaveService)
    {
        $this->flutterwaveService = $flutterwaveService;
    }

    /**
     * Handle payment callback from Flutterwave
     */
    public function callback(Request $request)
    {
        // Get transaction details from query parameters
        $status = $request->query('status');
        $txRef = $request->query('tx_ref');
        $transactionId = $request->query('transaction_id');

        // Log the callback for debugging
        Log::info('Flutterwave payment callback', [
            'status' => $status,
            'tx_ref' => $txRef,
            'transaction_id' => $transactionId
        ]);

        // If transaction was not successful, redirect to failure page
        if ($status !== 'successful' && $status !== 'completed') {
            return redirect()->route('payment.failed')
                ->with('error', 'Payment was not completed. Please try again.');
        }

        // Verify the transaction with Flutterwave
        $verification = $this->flutterwaveService->verifyPayment($transactionId);

        if ($verification['success']) {
            $payment = $verification['data']['payment'];
            
            return redirect('/payment-success?' . http_build_query([
                'name' => $payment->donor_name,
                'email' => $payment->donor_email,
                'amount' => $payment->amount,
                'type' => $payment->donation_type,
                'transactionId' => $payment->receipt_number ?? $payment->reference_number,
                'paymentMethod' => $payment->payment_method ?? 'card'
            ]));
        } else {
            return redirect()->route('payment.failed')
                ->with('error', 'Payment verification failed. Please contact support.');
        }
    }

    /**
     * Initialize a new payment
     */
    public function initialize(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:100',
            'type' => 'required|in:foundation,project',
            'project_id' => 'nullable|string',
            'message' => 'nullable|string|max:500'
        ]);

        $result = $this->flutterwaveService->initializePayment($validated);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'authorization_url' => $result['data']['authorization_url'],
                'reference' => $result['data']['reference']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }
    }

    /**
     * Verify a payment
     */
    public function verify(Request $request, $transactionId)
    {
        $result = $this->flutterwaveService->verifyPayment($transactionId);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'payment' => $result['data']['payment']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }
    }

    /**
     * Handle webhook from Flutterwave
     */
    public function webhook(Request $request)
    {
        Log::info('Flutterwave webhook received', $request->all());

        $result = $this->flutterwaveService->handleWebhook($request->all());

        if ($result['success']) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error'], 400);
        }
    }
}
