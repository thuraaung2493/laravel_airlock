<?php

namespace App\Http\Livewire;

use App\Contact;
use App\User;
use Livewire\Component;

class UserLists extends Component
{
    public $header;
    public $search;
    public $contacts;

    protected $updatesQueryString = [
        'search' => ['except' => ''],
    ];

    protected $listeners = ['contactAdded'];

    public function contactAdded()
    {
        $this->contacts = Contact::all();
    }

    public function mount($header)
    {
        // $this->header = $header;
        // $this->search = request()->query('search', $this->search);
        $this->fill([
            'header' => $header,
            'search' => request()->query('search', $this->search),
        ]);
    }

    public function getUserProperty()
    {
        return User::find(2);
    }

    public function render()
    {
        return view('livewire.user-lists', [
            'users' => User::search($this->search)->get(),
        ]);
    }
}
