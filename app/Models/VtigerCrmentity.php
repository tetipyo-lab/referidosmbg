<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VtigerCrmentity extends Model
{
    use HasFactory;
    protected $connection = 'mysqlVtiger';
    protected $table = 'vtiger_crmentity';
    protected $primaryKey = 'crmid';
    public $timestamps = false;

    protected $fillable = [
        'smcreatorid',
        'smownerid',
        'modifiedby',
        'setype',
        'description',
        'createdtime',
        'modifiedtime',
        'viewedtime',
        'status',
        'deleted'
    ];

    // Relación con el lead
    public function lead()
    {
        return $this->hasOne(VtigerLead::class, 'leadid', 'crmid');
    }

    // Relación con el usuario propietario
    public function owner()
    {
        return $this->belongsTo(VtigerUsers::class, 'smownerid', 'id');
    }
}
