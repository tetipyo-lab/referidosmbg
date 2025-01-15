<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('error')) {
            $errorMsg = $request->input('error');
            return view('pages.formerror', compact('errorMsg'));
        } elseif ($request->has('referred')) {
            $referredCode = $request->input('referred');

            // Buscar al agente con sus roles
            $agente = User::with('roles')->where('referral_code', $referredCode)->first();

            if (!$agente) {
                // Manejar el caso de código de referido inválido
                $errorMsg = 'Código de referido no válido.';
                return view('pages.formerror', compact('errorMsg'));
            }

            // Asegurarse de que roles no sea nulo
            $roles = $agente->roles ?? collect();
            $role= $roles->first()->name ?? 'No role';

            return view('pages.formmbg', compact('agente', 'role'));
        } elseif ($request->has('success')) {
            $okMsg = "Form saved successfully.";
            return view('pages.formok', compact('okMsg'));
        }

        // Valor por defecto si ninguna condición se cumple
        return redirect()->route('home')->with('error', 'Parámetros no válidos.');
    }

}
