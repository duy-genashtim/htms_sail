<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'first_name', 'email'
    // ];
    protected $guarded = [];

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'employee_department')
                    ->withPivot( 'is_main_department')
                    ->withTimestamps();
    }

    public function headOfDepartments()
    {
        return $this->hasMany(Department::class, 'head_id');
    }

    public function mancomOfDepartments()
    {
        return $this->hasMany(Department::class, 'mancom_id');
    }
    public function emergencyContacts() {
        return $this->hasMany(EmergencyContact::class);
    }
}
