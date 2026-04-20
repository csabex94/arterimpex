<?php

use Livewire\Component;
use App\Models\Department;

new class extends Component {

    public $departments = [];

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function render()
    {
        return $this->view()->layout('layouts::app');
    }
};
?>

<div class='flex flex-col gap-5 items-start'>
    <livewire:create-department-modal />

  <div class="w-full">
    <x-table :header-items="['Department Name', 'Edit/Delete']" :cells="['name', '']" :body-items="$departments">

    </x-table>
  </div>
</div>
