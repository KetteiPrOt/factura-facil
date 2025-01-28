<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

trait ModelBasics
{
    /**
     * Check if one model belongs to itself
     */
    public function belongsToMe(Model $model, string $relationship): bool
    {
        $myModels = $this->{$relationship};
        return $myModels->contains(function (Model $value, int $key) use ($model) {
            return $value->id == $model->id;
        });
    }
}
