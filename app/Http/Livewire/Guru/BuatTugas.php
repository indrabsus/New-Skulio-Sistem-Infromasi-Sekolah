<?php

namespace App\Http\Livewire\Guru;

use Livewire\Component;

class BuatTugas extends Component
{
    public function render()
    {
        return view('livewire.guru.buat-tugas')
        ->extends('layouts.admin.app')
        ->section('content');
    }
}
