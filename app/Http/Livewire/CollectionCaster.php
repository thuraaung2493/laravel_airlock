<?php

namespace App\Http\Livewire;

use Livewire\Castable;

class CollectionCaster implements Castable
{
    public function cast($value)
    {
        return collect($value);
    }

    public function uncast($value)
    {
        return $value->all();
    }
}
