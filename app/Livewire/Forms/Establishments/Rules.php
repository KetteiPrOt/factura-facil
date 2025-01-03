<?php

namespace App\Livewire\Forms\Establishments;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Rules\Unique\For\Rule as UniqueFor;

trait Rules
{
    public $code;

    public $commercial_name;

    public $address;

    /**
     * Determines whether it's storing or updating.
     * values: 'store' || 'update'
     */
    protected string $operation;

    protected function rules()
    {
        $user = User::find(Auth::user()->id);
        $uniqueFor = $this->operation == 'store'
            ? new UniqueFor($user, relation: 'establishments')
            : new UniqueFor($user, relation: 'establishments', ignore: $this->establishment->id);
        return [
            'code' => ['required', 'integer', 'min:1', 'max:999', $uniqueFor],
            'commercial_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'code' => 'código',
            'commercial_name' => 'nombre comercial',
            'address' => 'dirección',
        ];
    }
}