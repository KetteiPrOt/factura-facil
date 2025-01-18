<?php

namespace App\Rules\Model;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class BelongsToUser implements ValidationRule
{
    private string $Model;

    private string $relationship;

    public function __construct(string $Model, string $relationship)
    {
        $this->Model = $Model;
        $this->relationship = $relationship;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $model = $this->Model::find($value);
        $user = User::find(Auth::user()->id);
        if( ! $user->belongsToMe($model, $this->relationship) )
            $fail('El :attribute seleccionado no esta autorizado.');
    }
}
