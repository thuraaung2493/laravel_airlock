<?php

namespace App\Http\Livewire;

use App\Contact;
use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;

    public function updated($field)
    {
        $this->validateOnly($field, [
            'name' => ['required', 'min:6', 'max:10'],
            'email' => ['required', 'email', 'unique:contacts,email'],
        ]);
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'name' => ['required', 'min:6', 'max:10'],
            'email' => ['required', 'email', 'unique:contacts,email'],
        ]);

        Contact::create($validatedData);

        $this->emit('contactAdded');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
