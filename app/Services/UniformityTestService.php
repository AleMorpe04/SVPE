<?php

namespace App\Services;

class UniformityTestService
{
    private array $numbers;
    private int $k;
    private float $alpha;

    public function __construct(array $numbers, int $k = 10, float $alpha = 0.05)
    {
        $this->numbers = $numbers;
        $this->k = $k;
        $this->alpha = $alpha;
    }

    public function run()
    {
        $n = count($this->numbers);

        if ($n < 20) {
            throw new \InvalidArgumentException("La muestra es demasiado pequeña para Ji-Cuadrada.");
        }

        $intervalWidth = 1 / $this->k;
        $observed = array_fill(0, $this->k, 0);

        foreach ($this->numbers as $number) {
            $index = min((int) floor($number / $intervalWidth), $this->k - 1);
            $observed[$index]++;
        }

        $expected = $n / $this->k;

        $chiSquare = 0;
        foreach ($observed as $oi) {
            $chiSquare += pow($oi - $expected, 2) / $expected;
        }

        $critical = $this->getCriticalValue($this->k - 1);

        return [
            'chi_calculado' => $chiSquare,
            'chi_critico' => $critical,
            'decision' => $chiSquare < $critical 
                ? "Se acepta H₀ (Uniforme)" 
                : "Se rechaza H₀ (No uniforme)",
            'frecuencias_observadas' => $observed,
            'frecuencia_esperada' => $expected
        ];
    }

    private function getCriticalValue(int $df)
    {
        $table = [
            5 => 11.07,
            6 => 12.59,
            7 => 14.07,
            8 => 15.51,
            9 => 16.92,
            10 => 18.31
        ];

        return $table[$df] ?? 16.92;
    }
}