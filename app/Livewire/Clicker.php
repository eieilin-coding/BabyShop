<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Clicker extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';

    public function createNewUser(){
        
         $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
        // $this->reset(['name', 'email', 'password']);
         
    }
    public function handleClick(){
        dump("click");
    }
    public function render()
    {   
        $users = User::all();    
        return view('livewire.clicker', [
            'users' => $users
        ]);
    }
}
