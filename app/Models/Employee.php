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

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query, $is_active = null): void
    {
        $query->where('is_active', $is_active);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
