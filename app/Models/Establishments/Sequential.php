<?php

namespace App\Models\Establishments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sequential extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'next',
        'issuance_point_id',
        'receipt_type_id'
    ];

    public function issuancePoint(): BelongsTo
    {
        return $this->belongsTo(IssuancePoint::class);
    }

    // public function receiptType(): BelongsTo
    // {
    //     return $this->belongsTo(ReceiptType::class);
    // }
}
