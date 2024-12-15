<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Relación con los usuarios (muchos a muchos).
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
