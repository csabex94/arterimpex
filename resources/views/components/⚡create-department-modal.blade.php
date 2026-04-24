<?php

use Livewire\Component;
use Flux\Flux;
use App\Livewire\Forms\CreateDepartmentForm;

new class extends Component {
    public CreateDepartmentForm $form;

    public function handleSubmit()
    {
        $this->form->submitForm();
        Flux::modal('create-department')->close();
        $this->redirect('/departments');
    }
};
?>

<div>
    <flux:modal.trigger name="create-department">
        <flux:button>Create Department</flux:button>
    </flux:modal.trigger>
    <flux:modal name="create-department" class="md:w-96">
        <form wire:submit="handleSubmit" class="space-y-6">
            <div>
                <flux:heading size="lg">Create Department</flux:heading>
            </div>
            <flux:input label="Department Name" wire:model='form.name'  />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
