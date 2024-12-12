<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereBetween(string $string, array $array)
 * @method static where(string $string, mixed $employee_id)
 */
class Attendance extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'employee_id', 'attendance_date', 'check_in', 'check_out', 'status_check_in', 'status_check_out'];
}
