<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyRequest extends Model
{
protected $fillable = ['supply_id', 'department_id', 'quantity', 'status', 'unit'];

    public function supply() {
        return $this->belongsTo(Supply::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }
}

