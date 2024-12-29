<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('error')){
            $errorMsg = $request->error;
            return view('pages.formerror',compact('errorMsg'));
        }elseif($request->has('referred')){
            $referredCode = $request->input("referred");
            $agente = User::firstWhere("referral_code",$referredCode);
            
            return view('pages.formmbg',compact('agente'));
        }elseif($request->has('success')){
            $okMsg = "Form saved successfully ";
            return view('pages.formok',compact('okMsg'));
        }
    }
}
