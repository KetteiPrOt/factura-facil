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
        if( ! $myModels->contains($model) ){
            return false;
        }
        return true;
    }
}
