<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VtigerLead;
use App\Models\VtigerLeadaddress;
use App\Models\VtigerLeadsCf;

use App\Services\TextLinkSmsService;
use App\Services\TelnyxService;

class VtigerLeadsController extends Controller
{
    protected $textLinkSmsService,$telnyxService;

    public function __construct(TextLinkSmsService $textLinkSmsService,TelnyxService $telnyxService)
    {
        $this->textLinkSmsService = $textLinkSmsService;
        $this->telnyxService = $telnyxService;
    }

    public function index(){
        // Uso del scope
        $leads = VtigerLead::withCustomField('cf_853','like','%-01-9')->get();
        if(!empty($leads)){
            echo "No hay leads que cumplan años hoy.";
        }else{
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

    public function getLeadsByCity(){

        $leads = VtigerLead::whereHas('customFields', function ($query) {
            $query->where('cf_997','=','0')
            ->where('leadstatus','=','CONTESTA OTRA PERSONA');
        })
        ->whereHas('address',function($query){
            $query->whereIn('city',[
                    'Dallas','Corinth','Grand Prairie','Duncanville','Cedar Hill','Irving','Desoto','Mesquite',
                    'Balch Springs','Glenn Heights','Arlington','Red Oak','Lancaster','Fort Worth','Osprey',
                    'Cedar Creek','Euless','Carrollton','Roanoke','Richardson','Rowlett','Garland','Waxahachie',
                    'Plano','Kaufman','Venus','Lake','Frisco','Ennis','Forney','Hurst','Lewisville','Wylie',
                    'North Richland Hills','Alvarado','Melissa','Mansfield','Rice','Terrell','Allen','McKinney',
                    'Burleson','Crowley','The Colony','Rockwall','Haltom City','Denton','Princeton','Anna','Corsicana',
                    'Azle','Justin','Rhome','Joshua','Royse City','Little Elm','Haslet','Sanger','Saginaw','Prosper',
                    'Itasca'
            ]);
        })
        ->with(['address', 'customFields'])
        ->limit(1000)
        ->get();
        dd($leads);
        $cantLeads = $leads->count();    
        echo "Cantidad de registros ".$cantLeads."br>";
        if($cantLeads){
            foreach ($leads as $lead) {
                //echo "Lead ID: " . $lead->leadid . "<br>";
                //echo "Nombre: " . $lead->firstname . " " . $lead->lastname . "<br>";
                //echo "Campo CF937: " . $lead->customFields->cf_937 . "<br>";
                //echo "Campo Birthday: " . $lead->customFields->cf_853 . "<br>";
                //echo "Campo Plan: " . $lead->customFields->cf_865 . "<br>";
                // Acceder a otros campos...
            }
        }        
    }

    public function sendSms(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'message' => 'required|string|max:160',
        ]);

        $response = $this->textLinkSmsService->sendSms($request->to, $request->message);
        
        if (isset($response['ok']) && $response['ok']) {
            return response()->json(['message' => 'SMS enviado correctamente']);
        }

        return response()->json(['error' => $response['error'] ?? 'Error desconocido'], 500);
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $phoneNumber = $request->input('phone');
        $result = $this->telnyxService->lookupNumber($phoneNumber);
        return response()->json($result);
    }
}
