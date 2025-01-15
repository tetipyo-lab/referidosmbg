<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'referral_code',
        'referred_by',
        'profile_photo',
        'phone',
        'agent_npn',
    ];

    /**
     * Los atributos que deberían estar ocultos en la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deberían ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relación con los roles (muchos a muchos).
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Relación con el usuario que hizo la referencia (relación de auto-referencia).
     */
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Relación con los usuarios referidos por este usuario (relación recursiva de un usuario a muchos).
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    // Add the following to the User model
    /**
     * Get all referred links created by the user.
     */
    public function referredLinks()
    {
        return $this->hasMany(ReferredLink::class);
    }

    protected static function generateReferralCode(): string
    {
        // Generar un código único de 10 caracteres alfanuméricos
        $code = strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10));
        
        // Verificar que no exista en la base de datos
        while (User::where('referral_code', $code)->exists()) {
            $code = strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10));
        }

        return $code;
    }
}
