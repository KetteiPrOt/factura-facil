<?php

namespace App\Models\Persons;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IdentificationType extends Model
{
    public $timestamps = false;

    public static function finalConsumer(): self
    {
        return static::where('code', '07')->first();
    }

    public function persons(): HasMany
    {
        return $this->hasMany(Person::class);
    }
}
