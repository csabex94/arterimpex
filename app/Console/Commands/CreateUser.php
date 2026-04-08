<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:create-user')]
#[Description('Manually creating users from terminal.')]
class CreateUser extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Name:');
        $email = $this->ask('Email Address:');
        $role = $this->ask('Role(admin/guest):', 'guest');
        $password = $this->ask('Password:');

        \App\Models\User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);

        $this->info("User created successfully.");
    }
}
