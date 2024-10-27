<?php namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Correct import
use Illuminate\Database\Eloquent\Model;

// use Laravel\Sanctum\HasApiTokens;
 
class Pin extends Model
{
    protected $table = 'pins';
    protected $fillable = ['id', 'pin', 'buyer_id', 'generated_by', 'alloted_user_id', 'alloted_date','status', 'created_at', 'update_at'];

}
