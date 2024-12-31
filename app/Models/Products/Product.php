<?php

namespace App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'price',
        'additional_info',
        'tourism_vat_applies',
        'ice_applies',
        'user_id',
        'ice_type_id',
        'vat_rate_id',
    ];

    public function iceType(): BelongsTo
    {
        return $this->belongsTo(IceType::class);
    }

    public function vatRate(): BelongsTo
    {
        return $this->belongsTo(VatRate::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
