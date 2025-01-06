<?php

namespace App\Livewire\Forms;

use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    protected function numberToChar(int $n): string
    {
        // 100 - 999
        if($n > 99) return "$n";
        // 10 - 99
        if($n > 9) return "0$n";
        // 1 - 9
        return "00$n";
    }
}