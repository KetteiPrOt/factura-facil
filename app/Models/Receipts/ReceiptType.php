<?php

namespace App\Models\Receipts;

use App\Models\Establishments\Sequential;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceiptType extends Model
{
    public $timestamps = false;

    protected $fillable = ['code', 'name'];

    public function sequentials(): HasMany
    {
        return $this->hasMany(Sequential::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }
}
