<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'members';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'email',
    ];
    
    protected $casts = [
        'email' => 'string',
    ];

    public static function getIdByEmail(string $email): ?int
    {
        $id = self::select('id')
            ->where('email', $email)
            ->get();

        return !empty($id[0]) ? (int)$id[0]->id : null;
    }
}
