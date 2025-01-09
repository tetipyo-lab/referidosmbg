<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VtigerLead;

class VtigerLeadsController extends Controller
{
    public function index(){
        // Uso del scope
        $leads = VtigerLead::withCustomField('cf_853','like','%-08-14')->get();
        
        foreach ($leads as $lead) {
            echo "Lead ID: " . $lead->leadid . "<br>";
            echo "Nombre: " . $lead->firstname . " " . $lead->lastname . "<br>";
            echo "Campo CF937: " . $lead->customFields->cf_937 . "<br>";
            echo "Campo Birthday: " . $lead->customFields->cf_853 . "<br>";
            echo "Campo Plan: " . $lead->customFields->cf_865 . "<br>";
            // Acceder a otros campos...
        }
    }
}
