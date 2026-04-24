<?php

use Livewire\Component;
use App\Models\Department;
use Flux\Flux;

new class extends Component {

    public $departments = [];

    public $department = null;

    public function setDepartments(): void
    {
        $this->departments = Department::all();
    }

    public function showDeleteModal(Department $department): void
    {
        $this->department = $department;
        Flux::modal('delete-profile')->show();
    }

    public function deleteDepartment()
    {
        if ($this->department) {
            $this->department->delete();
            $this->department = null;
            Flux::modal('delete-profile')->close();
            $this->setDepartments();
        }
    }

    public function mount(): void
    {
        $this->setDepartments();
    }

    public function render()
    {
        return $this->view()->layout('layouts::app');
    }
};
?>

<div class='flex flex-col gap-5 items-start'>
    <livewire:create-department-modal />
    <flux:modal name="delete-profile" class="min-w-88">
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
                <flux:button type="button" wire:click='deleteDepartment' variant="danger">Delete</flux:button>
            </div>
        </div>
    </flux:modal>

  <div class="w-full">
    <x-table>
        <x-slot:table-header>
            <flux:table.column>Department Name</flux:table.column>
            <flux:table.column class="flex items-center justify-end">Edit/Delete</flux:table.column>
        </x-slot:table-header>
        <x-slot:table-body>
            @foreach ($departments as $department)
                <flux:table.row>
                    <flux:table.cell>{{ $department->name }}</flux:table.cell>
                    <flux:table.cell class="flex items-center justify-end gap-3">
                        <flux:button size="sm">Edit</flux:button>
                        <flux:button type="button" wire:click="showDeleteModal({{ $department }})" size="sm" variant="danger">Delete</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:table-body>
    </x-table>
  </div>
</div>
