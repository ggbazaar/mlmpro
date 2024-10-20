<?php namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Correct import
use Illuminate\Database\Eloquent\Model;

// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class Usermlm extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'usermlms';

    protected $fillable = [
        'name', 'mobile', 'email', 'whatsapp', 'pan', 'adhar', 
        'relation', 'relation_name', 'gender', 'dob', 'self_code', 
        'used_code', 'side', 'status', 'password', 'level','added_below','parent_code'
    ];

    protected $hidden = [
        'password',
    ];
}
