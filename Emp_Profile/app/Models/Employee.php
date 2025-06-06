<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'marital_status',
        'phone',
        'email',
        'address',
        'date_of_birth',
        'nationality',
        'hire_date',
        'department',
    ];
}
