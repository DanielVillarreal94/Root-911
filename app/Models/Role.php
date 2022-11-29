<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    
    public $timestamps = false;

    protected $fillable = [
        'role_name',
    ];

    protected function users(){
        return $this->belongsTo(User::class, 'id_role', 'role_id');
    }
}
