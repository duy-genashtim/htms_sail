<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $fillable = [
        'name',
        'slug',
        'is_mancom',
        'mancom_id',
        'head_id',
        'current_status',
        'description',
        'parent_id',

    ];

    public function departments(){
        return $this->hasMany(Department::class,'parent_id')->with(['departments', 'mancom', 'head']);
    }

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }
    
     // Relationship to Mancom
     public function mancom() {
        return $this->belongsTo(Employee::class, 'mancom_id')->select(['id', 'first_name', 'last_name', 'middle_name', 'extension_name', 'nick_name', 'email']);;
    }

    // Relationship to Head
    public function head() {
        return $this->belongsTo(Employee::class, 'head_id')->select(['id', 'first_name', 'last_name', 'middle_name', 'extension_name', 'nick_name', 'email']);;
    }
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_department')
                    ->withPivot('start_date', 'is_main_department')
                    ->withTimestamps();
    }
}
