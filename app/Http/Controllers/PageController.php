<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todos los parámetros enviados como query string
        $queryParams = $request->all();

        // Obtener parámetros específicos (si los necesitas)
        $param1 = $request->input('param1', 'default_value'); // Devuelve 'default_value' si no existe
        $param2 = $request->input('param2');

        // Retornar la vista con los datos
        return view('pages.form', compact('queryParams', 'param1', 'param2'));
    }
}
