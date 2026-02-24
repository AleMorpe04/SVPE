<?php

namespace App\Services;

class UniformityTestService
{
    public function test(array $ri): array
    {
        // 1️⃣ Cantidad de números
        $n = count($ri);

        // 2️⃣ Número de intervalos (k)
        $k = 10;

        // 3️⃣ Frecuencia esperada
        $expected = $n / $k;

        // 4️⃣ Inicializar arreglo de frecuencias observadas
        $observed = array_fill(0, $k, 0);

        // 5️⃣ Contar frecuencias por intervalo
        foreach ($ri as $r) {
            $index = min((int)($r * $k), $k - 1);
            $observed[$index]++;
        }

        // 6️⃣ Calcular estadístico Ji-Cuadrada
        $chiSquare = 0;

        foreach ($observed as $obs) {
            $chiSquare += pow($obs - $expected, 2) / $expected;
        }

        // 7️⃣ Grados de libertad
        $degreesOfFreedom = $k - 1;

        // 8️⃣ Valor crítico para α = 0.05 y gl = 9
        $criticalValue = 16.919;

        // 9️⃣ Decisión
        $passes = $chiSquare < $criticalValue;

        // 🔟 Retornar resultado completo
        return [
            'chi_square' => $chiSquare,
            'critical_value' => $criticalValue,
            'degrees_of_freedom' => $degreesOfFreedom,
            'alpha' => 0.05,
            'passes' => $passes,
            'conclusion' => $passes
                ? 'No se rechaza H0. La secuencia es uniforme.'
                : 'Se rechaza H0. La secuencia no es uniforme.'
        ];
    }
}