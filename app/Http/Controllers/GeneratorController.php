<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LinearCongruentialGenerator;
use App\Services\UniformityTestService;
use App\Services\RunsTestService;
use App\Services\MonteCarloInventoryService;

class GeneratorController extends Controller
{
    public function generate(Request $request)
    {
        // 1️⃣ Parámetros
        $seed = $request->input('seed', 5);
        $a    = $request->input('a', 3);
        $c    = $request->input('c', 7);
        $m    = $request->input('m', 100);
        $n    = $request->input('n', 50);

        // 2️⃣ Generador
        $generator = new LinearCongruentialGenerator($seed, $a, $c, $m, $n);
        $result = $generator->generate();

        $xi = $result['xi'];
        $ri = $result['ri'];

        // 3️⃣ Prueba Ji-Cuadrada
        $uniformityService = new UniformityTestService();
        $chiResult = $uniformityService->test($ri);

        // 4️⃣ Prueba de Rachas
        $runsService = new RunsTestService();
        $runsResult = $runsService->test($ri);

        // 5️⃣ Simulación Monte Carlo (Inventario)
        $monteCarloService = new MonteCarloInventoryService($ri);
        $monteCarloResult = $monteCarloService->simulate();

        // 6️⃣ Respuesta final
        return response()->json([
            'parametros' => [
                'seed' => $seed,
                'a'    => $a,
                'c'    => $c,
                'm'    => $m,
                'n'    => $n
            ],
            'numeros_generados'    => $xi,
            'numeros_normalizados' => $ri,
            'ji_cuadrada'          => $chiResult,
            'rachas'               => $runsResult,
            'monte_carlo'          => $monteCarloResult
        ]);
    }
}