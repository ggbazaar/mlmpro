<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;

class Payment extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Specify the table name
    protected $table = 'payments';

    // Specify the columns that are mass assignable
    protected $fillable = [
        'user_id',
        'kit_id',
        'amount',
        'pay_type',
        'remark',
        'date',
        'status',
        'approve_by',
        'approve_date',
        'created_at',
        'updated_at'
    ];

    // You can also add additional configurations like relationships, accessors, etc.
}
