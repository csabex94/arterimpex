<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'model', 'type', 'serial_number', 'ip_address', 'photo_url', 'department_id'])]
class Printer extends Model
{
    //
}
