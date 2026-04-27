<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Department;
use Flux\Flux;

new class extends Component {
    #[Computed]
    public function departments()
    {
        return Department::all();
    }

    public ?Department $department = null;

    public string $name = '';

    protected $rules = ['name' => 'required|string'];

    protected $listeners = [
        'editDepartment' => 'edit',
        'createDepartment' => 'create',
        'deleteDepartment' => 'delete'
    ];

    public function create()
    {
        $this->reset(['name']);
        $this->resetValidation();
        Flux::modal('create-department')->show();
    }

    public function edit(Department $department)
    {
        $this->resetValidation();
        $this->department = $department;
        $this->name = $department->name;
        Flux::modal('create-department')->show();
    }

    public function delete(Department $department)
    {
        $this->department = $department;
        Flux::modal('delete-department')->show();
    }

    public function save()
    {
        $data = $this->validate();
        Department::updateOrCreate(['id' => $this->department?->id], $data);
        Flux::modal('create-department')->close();
        $this->department = null;
    }

    public function handleDelete()
    {
        if ($this->department) {
            $this->department->delete();
            Flux::modal('delete-department')->close();
        }
    }


    public function render()
    {
        return $this->view()->layout('layouts::app');
    }
};
?>

<div class='flex flex-col gap-2 items-end'>
    <flux:button variant="filled" icon="plus" wire:click="$dispatch('createDepartment')">Create Department</flux:button>

    {{-- Create/Edit Modal --}}
    <flux:modal name="create-department" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $department ? 'Edit Department' : 'Create Department' }}</flux:heading>
            </div>
            <flux:input label="Department Name" wire:model='name'  autofocus/>
            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="save" type="submit" variant="primary">
                    {{ $department ? 'Save Changes' : 'Create Department' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
    {{-- End - Create/Edit Modal --}}

    {{-- Delete Modal --}}
    <flux:modal name="delete-department" class="min-w-88">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete department?</flux:heading>
                <flux:text class="mt-2">
                    You're about to delete this department.<br>
                    This action cannot be reversed.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="button" wire:click='handleDelete' variant="danger">Delete</flux:button>
            </div>
        </div>
    </flux:modal>
    {{-- End - Delete Modal --}}

    {{-- Table --}}
    <x-table class="w-full">
        <x-slot:table-header>
            <flux:table.column>Department Name</flux:table.column>
            <flux:table.column class="flex items-center justify-end">Edit/Delete</flux:table.column>
        </x-slot:table-header>
        <x-slot:table-body>
            @foreach ($this->departments as $department)
                <flux:table.row>
                    <flux:table.cell>{{ $department->name }}</flux:table.cell>
                    <flux:table.cell class="flex items-center justify-end gap-3">
                        <flux:button variant="filled" type="button" size="sm" wire:click="$dispatch('editDepartment', { department: {{ $department }} })">Edit</flux:button>
                        <flux:button type="button" wire:click="$dispatch('deleteDepartment', { department: {{ $department }} })" size="sm"
                            variant="danger">Delete</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:table-body>
    </x-table>
    {{-- End - Table --}}
</div>
