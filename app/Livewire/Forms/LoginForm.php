<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public function login()
    {
        $this->validate();

        $attempt = Auth::attempt(['email' => $this->email, 'password' => $this->password], true);

        if ($attempt) {
            session()->regenerate();
            $this->reset();
        }
    }
}
