<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'paystack_reference',
        'paystack_access_code',
        'paystack_transaction_id',
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'currency',
        'donation_type',
        'project_id',
        'message',
        'status',
        'payment_method',
        'payment_channel',
        'paid_at',
        'paystack_response',
        'authorization_code',
        'card_type',
        'last4',
        'bank',
        'receipt_sent',
        'receipt_sent_at',
        'receipt_number',
        'ip_address',
        'user_agent',
        'metadata',
        'refunded',
        'refund_amount',
        'refunded_at',
        'refund_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'receipt_sent_at' => 'datetime',
        'refunded_at' => 'datetime',
        'paystack_response' => 'array',
        'metadata' => 'array',
        'receipt_sent' => 'boolean',
        'refunded' => 'boolean',
    ];

    /**
     * Generate a unique reference number for our system
     */
    public static function generateReferenceNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        
        // Get the last payment for this month to determine the next sequence
        $lastPayment = self::where('reference_number', 'like', "AIYAK-{$year}{$month}-%")
            ->orderBy('reference_number', 'desc')
            ->first();
        
        if ($lastPayment) {
            // Extract the sequence number and increment
            $lastSequence = (int) substr($lastPayment->reference_number, -6);
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 1;
        }
        
        // Format: AIYAK-YYYYMM-XXXXXX (6-digit sequence)
        return sprintf('AIYAK-%s%s-%06d', $year, $month, $nextSequence);
    }

    /**
     * Generate a unique receipt number
     */
    public static function generateReceiptNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        
        // Get the last receipt for this month
        $lastReceipt = self::whereNotNull('receipt_number')
            ->where('receipt_number', 'like', "RCP-{$year}{$month}-%")
            ->orderBy('receipt_number', 'desc')
            ->first();
        
        if ($lastReceipt) {
            $lastSequence = (int) substr($lastReceipt->receipt_number, -6);
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 1;
        }
        
        // Format: RCP-YYYYMM-XXXXXX
        return sprintf('RCP-%s%s-%06d', $year, $month, $nextSequence);
    }

    /**
     * Check if payment is successful
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'successful';
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment failed
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Mark payment as successful
     */
    public function markAsSuccessful(array $paystackData = []): void
    {
        $this->update([
            'status' => 'successful',
            'paid_at' => now(),
            'paystack_response' => $paystackData,
        ]);
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed(string $reason = null): void
    {
        $metadata = $this->metadata ?? [];
        if ($reason) {
            $metadata['failure_reason'] = $reason;
        }
        
        $this->update([
            'status' => 'failed',
            'metadata' => $metadata,
        ]);
    }

    /**
     * Get formatted amount with currency
     */
    public function getFormattedAmountAttribute(): string
    {
        return '₦' . number_format($this->amount, 2);
    }

    /**
     * Get donor's full information
     */
    public function getDonorInfoAttribute(): array
    {
        return [
            'name' => $this->donor_name,
            'email' => $this->donor_email,
            'phone' => $this->donor_phone,
        ];
    }

    /**
     * Scope for successful payments
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'successful');
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for foundation donations
     */
    public function scopeFoundationDonations($query)
    {
        return $query->where('donation_type', 'foundation');
    }

    /**
     * Scope for project donations
     */
    public function scopeProjectDonations($query)
    {
        return $query->where('donation_type', 'project');
    }
}
