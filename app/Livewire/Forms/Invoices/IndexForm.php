<?php

namespace App\Livewire\Forms\Invoices;

use Illuminate\Validation\Rule;
use Livewire\Form;

class IndexForm extends Form
{
    public $date_from;

    public $date_to;

    public $number;

    public $status;

    protected function rules()
    {
        $today = date('Y-m-d');
        return [
            'date_from' => "nullable|date_format:Y-m-d|before_or_equal:date_to",
            'date_to' => "nullable|date_format:Y-m-d|before_or_equal:$today|after_or_equal:date_from",
            'number' => 'nullable|string|max:255',
            'status' => ['nullable', 'string', Rule::in(['', 'issued', 'no-issued', 'authorized', 'no-authorized'])],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'date_from' => 'fecha inicial',
            'date_to' => 'fecha final',
            'number' => 'número',
            'status' => 'estado',
        ];
    }
}
