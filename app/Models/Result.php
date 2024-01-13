<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    public $timestamps = false;
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'member_id',
        'milliseconds'
    ];
    
    protected $casts = [
        'email' => 'string',
        'milliseconds' => 'integer',
    ];
}
