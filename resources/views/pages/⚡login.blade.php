<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use App\Livewire\Forms\LoginForm;
use Livewire\Component;

new class extends Component {

    public LoginForm $loginForm;

    public function handleSubmit()
    {
        $this->loginForm->login();
        $this->redirect('/');
    }

    public function handleGoogleLogin()
    {
        $this->redirect('/oauth/google/redirect');
    }

    public function render()
    {
        return $this->view()->layout('layouts::app');
    }
};
?>

<div class='min-h-screen bg-gray-50 w-full flex items-center justify-center'>
    <form wire:submit="handleSubmit" class='w-full max-w-xs'>
        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">Log in to your account</flux:heading>
                <flux:text class="mt-2">Welcome back!</flux:text>
            </div>

            <div class="space-y-6">
                <flux:input wire:model="loginForm.email" label="Email" type="email" placeholder="Your email address" />

                <flux:field>
                    <div class="mb-3 flex justify-between">
                        <flux:label>Password</flux:label>

                        <flux:link href="#" variant="subtle" class="text-sm">Forgot password?</flux:link>
                    </div>

                    <flux:input wire:model="loginForm.password" type="password" placeholder="Your password" />

                    <flux:error name="password" />
                </flux:field>
            </div>

            <div class="space-y-4">
                <flux:button type="submit" variant="primary" class="w-full">Log in</flux:button>
                <flux:button type="button" wire:click="handleGoogleLogin" class="w-full">Google Login</flux:button>
            </div>
        </flux:card>
    </form>
</div>
