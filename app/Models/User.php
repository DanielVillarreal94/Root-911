<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Controllers\AccessController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'identification';
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "identification",
        "firstname",
        "lastname",
        "username",
        "password",
        "phone_number", 
        "email", 
        "state",
        "department_id", 
        "role_id",
    ];

    public function department()
    {
        return $this->hasOne(Deparment::class, 'id_department', 'department_id');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id_role', 'role_id');
    }

    public function getRole(){
              
    }

    public function access()
    {
        return $this->belonsTo(AccessController::class, 'identification', 'id');
    }

    
}
