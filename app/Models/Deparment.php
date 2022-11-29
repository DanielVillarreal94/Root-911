<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deparment extends Model
{
    //use HasFactory;
    protected $table = 'departments';
    protected $primaryKey = 'id_department';
    
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    protected function users(){
        return $this->belongsTo(User::class, 'id_department', 'department_id');
    }
}
