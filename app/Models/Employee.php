<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name', 'dob', 'city', 'email', 'is_active'];

    protected $keyType = 'string';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $cast = [
        'is_active' => 'boolean',
    ];
}
