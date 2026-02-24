<?php

namespace App\Services;

class RunsTestService
{
    public function test(array $ri): array
    {
        // 1️⃣ Total de números
        $n = count($ri);

        // 2️⃣ Contar mayores y menores a 0.5
        $n1 = 0;
        $n2 = 0;

        foreach ($ri as $r) {
            if ($r >= 0.5) {
                $n1++;
            } else {
                $n2++;
            }
        }

        // 3️⃣ Contar rachas
        $runs = 1;
        $prev = $ri[0] >= 0.5;

        for ($i = 1; $i < $n; $i++) {
            $current = $ri[$i] >= 0.5;

            if ($current !== $prev) {
                $runs++;
                $prev = $current;
            }
        }

        // 4️⃣ Esperanza matemática
        $expectedRuns = ((2 * $n1 * $n2) / $n) + 1;

        // 5️⃣ Varianza
        $variance = (
            (2 * $n1 * $n2) * (2 * $n1 * $n2 - $n)
        ) / (pow($n, 2) * ($n - 1));

        // 6️⃣ Estadístico Z
        $z = ($runs - $expectedRuns) / sqrt($variance);

        // 7️⃣ Valor crítico para α = 0.05
        $criticalZ = 1.96;

        // 8️⃣ Decisión
        $passes = abs($z) < $criticalZ;

        // 9️⃣ Retornar resultado
        return [
            'total_runs' => $runs,
            'expected_runs' => $expectedRuns,
            'z_value' => $z,
            'critical_value' => $criticalZ,
            'alpha' => 0.05,
            'passes' => $passes,
            'conclusion' => $passes
                ? 'No se rechaza H0. La secuencia es independiente.'
                : 'Se rechaza H0. La secuencia no es independiente.'
        ];
    }
}