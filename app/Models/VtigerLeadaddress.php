<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VtigerLeadaddress extends Model
{
    use HasFactory;
    protected $connection = 'mysqlVtiger';
    protected $table = 'vtiger_leadaddress';
    protected $primaryKey = 'leadaddressid';
    public $timestamps = false;

    protected $fillable = [
        'city',
        'code',
        'state',
        'country',
        'street',
        'pobox',
        'mobile'
    ];

    // Relación inversa con el lead
    public function lead()
    {
        return $this->belongsTo(VtigerLead::class,'leadaddressid','leadid');
    }
    
}
