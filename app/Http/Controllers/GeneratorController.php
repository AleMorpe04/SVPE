<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LinearCongruentialGenerator;
use InvalidArgumentException;

class GeneratorController extends Controller
{
    public function generate(Request $request)
    {
        // 1️⃣ Validación de datos
        $validated = $request->validate([
            'seed' => 'required|integer|min:0',
            'a'    => 'required|integer|min:0',
            'c'    => 'required|integer|min:0',
            'm'    => 'required|integer|min:1',
            'n'    => 'required|integer|min:1'
        ]);

        try {
            // 2️⃣ Instanciar el motor matemático
            $generator = new LinearCongruentialGenerator(
                $validated['seed'],
                $validated['a'],
                $validated['c'],
                $validated['m'],
                $validated['n']
            );

            $result = $generator->generate();

            // 3️⃣ Retornar respuesta JSON estructurada
            return response()->json([
                'parametros' => $validated,
                'numeros_generados' => $result['xi'],
                'numeros_normalizados' => $result['ri']
            ]);

        } catch (InvalidArgumentException $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}