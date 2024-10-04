<?php namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usermlm extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'mobile', 'email', 'whatsapp', 'pan', 'adhar', 
        'relation', 'relation_name', 'gender', 'dob', 'referral_code', 
        'used_code', 'side', 'status', 'password', 'level','added_below'
    ];

    protected $hidden = [
        'password',
    ];
}
