<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Department;

class CreateDepartmentForm extends Form
{
    #[Validate('required|string')]
    public string $name = '';

    public function submitForm()
    {
        $this->validate();
        Department::create(['name' => $this->name]);
    }
}
