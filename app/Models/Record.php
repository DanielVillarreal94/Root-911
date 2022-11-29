<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'records';
    protected $primaryKey = 'id_record';
    
    public $timestamps = false;

    protected $fillable = [
        'identification',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'identification', 'id');
    }
}
