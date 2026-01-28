<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // (This line might be optional depending on your version)
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    // This tells Laravel: "It is safe to bulk-save these 4 specific fields."
    // It will automatically ignore '_token' or anything else not in this list.
    protected $fillable = [
        'name', 
        'unit', 
        'quantity', 
        'reorder_level'
    ];
}