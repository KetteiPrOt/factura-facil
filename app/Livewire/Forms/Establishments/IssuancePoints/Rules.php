<?php

namespace App\Livewire\Forms\Establishments\IssuancePoints;

use App\Models\Establishments\Establishment;
use App\Rules\Unique\For\Rule as UniqueFor;

trait Rules
{
    public $code;

    public $description;

    public ?int $establishment_id;

    /**
     * Determines whether it's storing or updating.
     * values: 'store' || 'update'
     */
    protected string $operation;

    protected function rules()
    {
        $establishment = Establishment::find($this->establishment_id);
        $uniqueFor = $this->operation == 'store'
            ? new UniqueFor($establishment, relation: 'issuancePoints')
            : new UniqueFor($establishment, relation: 'issuancePoints', ignore: $this->issuancePoint->id);
        return [
            'code' => ['required', 'integer', 'min:1', 'max:999', $uniqueFor],
            'description' => 'nullable|string|max:255',
        ];
    }
}