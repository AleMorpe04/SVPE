<?php

namespace App\Services;

class RunsTestService
{
    private array $numbers;
    private float $alpha;

    public function __construct(array $numbers, float $alpha = 0.05)
    {
        $this->numbers = $numbers;
        $this->alpha = $alpha;
    }

    public function run()
    {
        $n = count($this->numbers);

        if ($n < 20) {
            throw new \InvalidArgumentException("La muestra es demasiado pequeña para prueba de rachas.");
        }

        $binary = array_map(fn($x) => $x >= 0.5 ? 1 : 0, $this->numbers);

        $runs = 1;
        for ($i = 1; $i < $n; $i++) {
            if ($binary[$i] !== $binary[$i - 1]) {
                $runs++;
            }
        }

        $n1 = array_sum($binary);
        $n0 = $n - $n1;

        $mean = (2 * $n1 * $n0) / $n + 1;
        $variance = (2 * $n1 * $n0 * (2 * $n1 * $n0 - $n)) 
                    / (pow($n, 2) * ($n - 1));

        $z = ($runs - $mean) / sqrt($variance);

        $critical = 1.96;

        return [
            'rachas' => $runs,
            'z_calculado' => $z,
            'z_critico' => $critical,
            'decision' => abs($z) < $critical 
                ? "Se acepta H₀ (Independencia)" 
                : "Se rechaza H₀ (Dependencia)"
        ];
    }
}