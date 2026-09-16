<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlutterwaveService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
        $status = $request->query('status');
        $txRef = $request->query('tx_ref');
        $transactionId = $request->query('transaction_id');

        Log::info('Flutterwave payment callback', [
            'status' => $status,
            'tx_ref' => $txRef,
            'transaction_id' => $transactionId,
        ]);

        if ($status !== 'successful' && $status !== 'completed') {
            return redirect()->route('payment.failed')
                ->with('error', 'Payment was not completed. Please try again.');
        }

        $verification = $this->flutterwaveService->verifyPayment($transactionId);

        if ($verification['success']) {
            $payment = $verification['data']['payment'];
            $ticket = $payment->ticket;

            $query = [
                'name' => $payment->donor_name,
                'email' => $payment->donor_email,
                'amount' => $payment->amount,
                'type' => $payment->donation_type,
                'transactionId' => $payment->receipt_number ?? $payment->reference_number,
                'paymentMethod' => $payment->payment_method ?? 'card',
            ];

            if ($ticket) {
                $query['ticketType'] = $ticket->ticket_type;
                $query['ticketCode'] = $ticket->code;
                $query['passName'] = $ticket->passName();
            }

            return redirect('/payment-success?' . http_build_query($query));
        }

        return redirect()->route('payment.failed')
            ->with('error', 'Payment verification failed. Please contact support.');
    }

    /**
     * Initialize a new payment (donation or ticket).
     */
    public function initialize(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'type' => 'required|in:foundation,project,ticket',
            'amount' => 'nullable|numeric|min:100',
            'ticket_type' => [
                Rule::requiredIf(fn () => $request->input('type') === 'ticket'),
                Rule::in(array_keys(config('summit.tickets', []))),
            ],
            'project_id' => 'nullable|string',
            'message' => 'nullable|string|max:500',
            'source' => 'nullable|string|max:50',
        ]);

        if (($validated['type'] ?? '') !== 'ticket' && empty($validated['amount'])) {
            return response()->json([
                'success' => false,
                'message' => 'Amount is required for donations.',
            ], 422);
        }

        $result = $this->flutterwaveService->initializePayment($validated);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'authorization_url' => $result['data']['authorization_url'],
                'reference' => $result['data']['reference'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], 400);
    }

    public function verify(Request $request, $transactionId)
    {
        $result = $this->flutterwaveService->verifyPayment($transactionId);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'payment' => $result['data']['payment'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], 400);
    }

    public function webhook(Request $request)
    {
        Log::info('Flutterwave webhook received', $request->all());

        $result = $this->flutterwaveService->handleWebhook($request->all());

        if ($result['success']) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 400);
    }

    /**
     * Public ticket catalogue for the React microsite.
     */
    public function ticketCatalogue()
    {
        $tickets = collect(config('summit.tickets', []))->map(function (array $ticket, string $key) {
            return [
                'type' => $key,
                'name' => $ticket['name'],
                'price' => $ticket['price'],
                'day_label' => $ticket['day_label'],
                'includes' => $ticket['includes'],
            ];
        })->values();

        return response()->json([
            'success' => true,
            'tickets' => $tickets,
            'main_site_url' => config('app.url'),
        ]);
    }
}
