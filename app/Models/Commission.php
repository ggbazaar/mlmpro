<?php namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Correct import
use Illuminate\Database\Eloquent\Model;

// use Laravel\Sanctum\HasApiTokens;
 
class Commission extends Authenticatable
{
    protected $table = 'commissions';
    protected $fillable = ['id', 'user_id', 'purchase_id', 'level_commission', 'total_amount', 'service_charge', 'payable_amount', 'status', 'created_at', 'update_at'];

}
