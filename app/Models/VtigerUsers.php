<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VtigerUsers extends Model
{
    use HasFactory;
    protected $connection = 'mysqlVtiger';
    protected $table = 'vtiger_users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_name',
        'user_password',
        'first_name',
        'last_name',
        'email1',
        'status',
        'is_admin'
    ];

    // Relación con las entidades que posee
    public function ownedEntities()
    {
        return $this->hasMany(VtigerCrmentity::class, 'smownerid', 'id');
    }
}
