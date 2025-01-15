<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'description',
        'is_active',
        'created_by',
        'updated_by'
    ];

    /**
     * Relación con el usuario que creó el link.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Add the following to the Link model
    /**
     * Get all referred links associated with this link.
     */
    public function referredLinks()
    {
        return $this->hasMany(ReferredLink::class);
    }

    /**
     * Generar un slug único para el link.
     */
    /*public static function generateSlug()
    {
        do {
            $slug = str()->random(8); // Generar un slug único de 8 caracteres
        } while (self::where('slug', $slug)->exists());

        return $slug;
    }*/

    /**
     * Sobrescribir el evento de creación para asignar un slug.
     */
    protected static function boot()
    {
        parent::boot();

        // Antes de crear un registro
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        // Antes de actualizar un registro
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
}
