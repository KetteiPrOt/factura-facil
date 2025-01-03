<?php

namespace App\Livewire\Forms\Persons;

use App\Models\Persons\IdentificationType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\String\NumericDigits;
use App\Rules\Unique\For\Rule as UniqueFor;
use App\Rules\String\ExactSizes;

trait Rules
{
    public $identification;

    public $social_reason;

    public $email;

    public $identification_type_id;

    public $phone_number;

    public $address;

    /**
     * Determines whether it's storing or updating.
     * values: 'store' || 'update'
     */
    protected string $operation;

    protected function rules()
    {
        $user = User::find(Auth::user()->id);
        $final_consumer_id = IdentificationType::finalConsumer()->id;
        $uniqueFor = $this->operation == 'store'
            ? new UniqueFor($user, relation: 'persons')
            : new UniqueFor($user, relation: 'persons', ignore: $this->person->id);
        return [
            'identification' => [
                'bail', 'required', 'string', 'min:10', 'max:13',
                new NumericDigits, $uniqueFor, new ExactSizes(10, 13)
            ],
            'social_reason' => 'required|string|max:255',
            'email' => 'required|string|max:255|email:rfc,strict',
            'identification_type_id' => [
                'required', 'integer', 'exists:identification_types,id',
                Rule::notIn($final_consumer_id)
            ],
            'phone_number' => ['bail', 'nullable', 'string', 'size:10', new NumericDigits],
            'address' => 'string|max:255',
        ];
    }

    protected function validationAttributes() 
    {
        return [
            'identification' => 'identificación',
            'social_reason' => 'razón social',
            'email' => 'correo electrónico',
            'phone_number' => 'número de teléfono',
            'address' => 'dirección',
            'identification_type_id' => 'tipo de identificación'
        ];
    }
}
