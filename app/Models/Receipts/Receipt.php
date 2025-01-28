<?php

namespace App\Models\Receipts;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    protected $fillable = [
        'access_key',
        'issuance_date',
        'number',
        'status',
        'content',
        'client_email',
        'user_id',
        'receipt_type_id'
    ];

    public function receiptType(): BelongsTo
    {
        return $this->belongsTo(ReceiptType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
