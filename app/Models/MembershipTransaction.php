<?php

namespace App\Models;

use Database\Factories\MembershipTransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MembershipTransaction extends Model
{
    /** @use HasFactory<MembershipTransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'transaction_number', 'member_id', 'membership_level_id', 'transaction_type',
        'amount', 'payment_method', 'payment_reference', 'payment_status',
        'approval_status', 'paid_at', 'approved_at', 'starts_at', 'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2', 'paid_at' => 'datetime', 'approved_at' => 'datetime',
            'starts_at' => 'datetime', 'expires_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (MembershipTransaction $transaction): void {
            $transaction->transaction_number ??= 'TXN-'.Str::upper(Str::random(10));
        });
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function membershipLevel(): BelongsTo
    {
        return $this->belongsTo(MembershipLevel::class);
    }

    public function markPaid(): void
    {
        $this->update(['payment_status' => 'paid', 'paid_at' => now()]);
    }

    public function approve(): void
    {
        if ($this->payment_status !== 'paid') {
            throw new \LogicException('Only paid transactions may be approved.');
        }

        $this->update(['approval_status' => 'approved', 'approved_at' => now()]);
    }
}
