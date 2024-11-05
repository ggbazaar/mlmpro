<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kitamount extends Authenticatable
{
    // Specify the table name
    protected $table = 'kit_amounts';
    // Specify the columns that are mass assignable
    protected $fillable = [
        'id',
        'title',
        'description',
        'amount',
        'bv',
        'status', 
        'created_at',
        'updated_at'
    ];
    // You can also add additional configurations like relationships, accessors, etc.
}
