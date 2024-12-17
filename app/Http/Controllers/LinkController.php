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

        if ($link) {
            // Aumentar el contador de clics
            $link->clicks = $link->clicks + 1;
            $link->save(); // Guardar el nuevo valor de clicks

            // Redirigir a la URL almacenada
            return redirect()->to($link->url);
        }

        // Si no existe, devolver un error 404
        return response()->json([
            'status' => 'error',
            'message' => 'El enlace no existe.',
        ], 404);
    }
}
