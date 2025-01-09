<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VtigerLead extends Model
{
    use HasFactory;
    protected $connection = 'mysqlVtiger';
    protected $table = 'vtiger_leaddetails';
    protected $primaryKey = 'leadid';
    public $timestamps = false;

    protected $fillable = [
        'lead_no',
        'firstname',
        'lastname',
        'company',
        'email',
        'phone',
        'mobile',
        'designation',
        'leadsource',
        'leadstatus',
        'converted',
        'rating'
    ];

    // Relación con la tabla principal de CRM
    public function crmEntity()
    {
        return $this->belongsTo(VtigerCrmentity::class, 'leadid', 'crmid');
    }

    // Relación con los campos adicionales
    public function customFields()
    {
        return $this->hasOne(VtigerLeadsCf::class, 'leadid', 'leadid');
    }

    // Relación con la información de dirección
    public function address()
    {
        return $this->hasOne(VtigerLeadaddress::class, 'leadaddressid', 'leadid');
    }

    public function scopeWithCustomField($query, $field, $operator, $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        return $query->join('vtiger_leadscf', 'vtiger_leaddetails.leadid', '=', 'vtiger_leadscf.leadid')
            ->join('vtiger_crmentity', 'vtiger_leaddetails.leadid', '=', 'vtiger_crmentity.crmid')
            ->where("vtiger_leadscf.{$field}",$operator, $value)
            ->where('vtiger_crmentity.deleted', 0)
            ->select('vtiger_leaddetails.*');
    }
}