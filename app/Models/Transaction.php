<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // This whitelist allows us to save these fields using Transaction::create()
    protected $fillable = [
        'type',           // IN or OUT
        'supply_id',      // Which item
        'department_id',  // Which department (nullable)
        'quantity',       // How many
        'user_id',        // Who did it
        'remarks'         // Optional notes
    ];

    // Relationship: A transaction belongs to a Supply item
    public function supply() {
        return $this->belongsTo(Supply::class);
    }

    // Relationship: A transaction belongs to a Department
    public function department() {
        return $this->belongsTo(Department::class);
    }
    // Add this to link the User who performed the action
    public function user() {
        return $this->belongsTo(User::class);
    }
}