<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VtigerLead;

class VtigerLeadsController extends Controller
{
    public function index(){
        // Uso del scope
        $leads = VtigerLead::withCustomField('cf_937', 'TX-DALLAS-0001')
        ->with(['customFields', 'crmEntity', 'address'])
        ->get();
        
        foreach ($leads as $lead) {
            echo "Lead ID: " . $lead->leadid . "\n";
            echo "Nombre: " . $lead->firstname . " " . $lead->lastname . "\n";
            echo "Campo CF937: " . $lead->customFields->cf_937 . "\n";
            // Acceder a otros campos...
        }
    }
}
