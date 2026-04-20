<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Printer;
use App\Models\Scale;
use App\Models\Pda;

#[Fillable(['name', 'photo_url'])]
class Department extends Model
{
    public function printers(): HasMany
    {
        return $this->hasMany(Printer::class, 'department_id', 'id');
    }

    public function scales(): HasMany
    {
        return $this->hasMany(Scale::class, 'department_id', 'id');
    }

        public function pdas(): HasMany
    {
        return $this->hasMany(Pda::class, 'department_id', 'id');
    }
}
