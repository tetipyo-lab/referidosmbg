<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'referred' => 'required|string|max:255',
        ]);

        $referredCode = $request->input("referred");
        $agente = User::firstWhere("referral_code",$referredCode);

        return view('pages.form',compact('agente'));
    }
}
