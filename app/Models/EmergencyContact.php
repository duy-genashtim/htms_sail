<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;
    protected $table = 'emergency_contact_information'; // Specify the table name if it's not the default

    protected $fillable = [
        'employee_id',
        'full_name',
        'relationship',
        'phone_number',
        'email',
        'address'
    ];

    // Define relationship with Employee
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
