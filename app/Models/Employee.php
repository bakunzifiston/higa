<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'employee_code',
        'full_name',
        'gender',
        'date_of_birth',
        'nationality',
        'disability_status',
        'phone_number',
        'email',
        'address',
        'department',
        'position',
        'employment_type',
        'hire_date',
        'work_location',
        'status',
    ];
}

