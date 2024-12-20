<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class LinkController extends Controller
{
    public function validateSlug($slug)
    {
        // Buscar el registro en la base de datos
        $link = Link::where('slug', $slug)->first();
        $user_referral_code = $link->user->referral_code;
        
        if ($link) {
            // Aumentar el contador de clics
            $link->clicks = $link->clicks + 1;
            $link->save(); // Guardar el nuevo valor de clicks
            
            if(!empty($user_referral_code)){
                //Contacatenar el REFERRAL CODE AL LA URL
                $newParams = ['referred' => $user_referral_code];
                $url = $this->addParameterToRedirect($link->url,$newParams);
                
                // Redirigir a la URL almacenada
                return redirect()->to($url);
            }
            
        }

        // Si no existe, devolver un error 404
        return response()->json([
            'status' => 'error',
            'message' => 'El enlace no existe.',
        ], 404);
    }
    private function addParameterToRedirect($url,$newParams)
    {
        $updatedUrl = addParameterToUrl($url, $newParams);

        return $updatedUrl;
    }
}
