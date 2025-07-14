<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DncNumber extends Model
{
    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'dnc_numbers';

    /**
     * Clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indica si los IDs son autoincrementales.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Tipo de la clave primaria.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * Atributos que son asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number'
    ];

    /**
     * Atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Indica si el modelo debe tener marcas de tiempo.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Nombre de la columna para created_at.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * Nombre de la columna para updated_at.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * Conexión de base de datos para el modelo.
     *
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * Scope para buscar por número de teléfono.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $phoneNumber
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPhoneNumber($query, $phoneNumber)
    {
        return $query->where('phone_number', $phoneNumber);
    }

    public function scopeLikePhoneNumber($query, $phoneNumber)
    {
        return $query->where('phone_number', 'ILIKE', "%$phoneNumber%");
    }

    public function scopeByCreatedDate($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }

    /**
     * Scope para números agregados después de cierta fecha.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAddedAfter($query, $date)
    {
        return $query->where('created_at', '>=', $date);
    }
}