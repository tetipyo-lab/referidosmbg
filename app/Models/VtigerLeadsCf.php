<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VtigerLeadsCf extends Model
{
    use HasFactory;
    protected $connection = 'mysqlVtiger';
    protected $table = 'vtiger_leadscf';
    protected $primaryKey = 'leadid';
    public $timestamps = false;

    protected $guarded = []; // Permitir todos los campos ya que son personalizados

    // Relación inversa con el lead
    public function lead()
    {
        return $this->belongsTo(VtigerLead::class, 'leadid', 'leadid');
    }
}
