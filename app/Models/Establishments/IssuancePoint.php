<?php

namespace App\Models\Establishments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IssuancePoint extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'description',
        'active',
        'establishment_id'
    ];

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function sequentials(): HasMany
    {
        return $this->hasMany(Sequential::class);
    }
}
