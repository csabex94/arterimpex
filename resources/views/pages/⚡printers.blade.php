<?php

use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Flux\Flux;
use App\Models\Printer;
use App\Models\Department;

new class extends Component
{
    public string $name = '';
    public string $model = '';
    public string $type = '';
    public string $serial_number = '';
    public string $ip_address = '';

    public ?Printer $printer = null;

    public ?int $department_id = null;

    #[Computed]
    public function printers()
    {
        return Printer::all();
    }

    #[Computed]
    public function departments()
    {
        return Department::all();
    }

    protected $rules = [
        'name' => 'required|string',
        'model' => 'required|string',
        'type' => 'required|string',
        'serial_number' => 'required|string',
        'ip_address' => 'required|string',
        'department_id' => 'required|int',
    ];

    protected $listeners = [
        'editPrinter' => 'edit',
        'addPrinter' => 'create',
        'deletePrinter' => 'delete'
    ];

    public function create()
    {
        $this->reset(['name', 'model', 'type', 'serial_number', 'ip_address', 'department_id']);
        $this->resetValidation();
        Flux::modal('add-printer')->show();
    }

    public function edit(Printer $printer)
    {
        $this->resetValidation();
        $this->printer = $printer;
        $this->name = $printer->name;
        $this->model = $printer->model;
        $this->type = $printer->type;
        $this->serial_number = $printer->serial_number;
        $this->ip_address = $printer->ip_address;
        $this->department_id = $printer->department_id;
        Flux::modal('add-printer')->show();
    }

    public function delete(Printer $printer)
    {
        $this->printer = $printer;
        Flux::modal('delete-printer')->show();
    }

    public function save()
    {
        $data = $this->validate();
        Printer::updateOrCreate(['id' => $this->printer?->id], $data);
        Flux::modal('add-printer')->close();
        $this->printer = null;
    }

    public function handleDelete()
    {
        if ($this->printer) {
            $this->printer->delete();
            Flux::modal('delete-printer')->close();
            $this->printer = null;
        }
    }
};
?>

<div class='flex flex-col gap-2 items-end'>
    <flux:button variant="filled" icon="plus" wire:click="$dispatch('addPrinter')">Add Printer</flux:button>

    {{-- Create/Edit Modal --}}
    <flux:modal name="add-printer" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $printer ? 'Edit Printer' : 'Add Printer' }}</flux:heading>
            </div>
            <flux:input label="Printer Name" wire:model='name'  autofocus/>
            <flux:input label="Printer Model" wire:model='model'/>
            <flux:input label="Printer Type(normal/multifunctional/label)" wire:model='type'/>
            <flux:input label="Printer Serial Number(S/N)" wire:model='serial_number'/>
            <flux:input label="Printer Ip Address" wire:model='ip_address'/>

            <flux:select wire:model="department_id" placeholder="Choose department...">
                @foreach ($this->departments as $department)
                    <flux:select.option value="{{ $department->id }}">{{ $department->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex mt-5">
                <flux:spacer />
                <flux:button wire:click="save" type="button" variant="primary">
                    {{ $printer ? 'Save Changes' : 'Add Printer' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
    {{-- End - Create/Edit Modal --}}

    {{-- Delete Modal --}}
    <flux:modal name="delete-printer" class="min-w-88">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete printer?</flux:heading>
                <flux:text class="mt-2">
                    You're about to delete this printer.<br>
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
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Model</flux:table.column>
            <flux:table.column>Type</flux:table.column>
            <flux:table.column>Serial Number</flux:table.column>
            <flux:table.column>Ip Address</flux:table.column>
            <flux:table.column>Department</flux:table.column>
            <flux:table.column class="flex items-center justify-end">Edit/Delete</flux:table.column>
        </x-slot:table-header>
        <x-slot:table-body>
            @foreach ($this->printers as $printer)
                <flux:table.row>
                    <flux:table.cell>{{ $printer->name }}</flux:table.cell>
                    <flux:table.cell>{{ $printer->model }}</flux:table.cell>
                    <flux:table.cell>{{ $printer->type }}</flux:table.cell>
                    <flux:table.cell>{{ $printer->serial_number }}</flux:table.cell>
                    <flux:table.cell>{{ $printer->ip_address }}</flux:table.cell>
                    <flux:table.cell>{{ $printer->department->name }}</flux:table.cell>
                    <flux:table.cell class="flex items-center justify-end gap-3">
                        <flux:button variant="filled" type="button" size="sm" wire:click="$dispatch('editPrinter', { printer: {{ $printer }} })">Edit</flux:button>
                        <flux:button type="button" wire:click="$dispatch('deletePrinter', { printer: {{ $printer }} })" size="sm"
                            variant="danger">Delete</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </x-slot:table-body>
    </x-table>
    {{-- End - Table --}}
</div>
