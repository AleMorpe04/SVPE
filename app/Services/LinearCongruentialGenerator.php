<?php

namespace App\Services;

use InvalidArgumentException;

class LinearCongruentialGenerator
{
    private int $seed;
    private int $a;
    private int $c;
    private int $m;
    private int $n;

    public function __construct(int $seed, int $a, int $c, int $m, int $n)
    {
        $this->seed = $seed;
        $this->a = $a;
        $this->c = $c;
        $this->m = $m;
        $this->n = $n;

        $this->validateParameters();
    }

    private function validateParameters(): void
    {
        if ($this->m <= 0) {
            throw new InvalidArgumentException("El valor de m debe ser mayor que 0.");
        }

        if ($this->n <= 0) {
            throw new InvalidArgumentException("El número de iteraciones debe ser mayor que 0.");
        }

        if ($this->a < 0 || $this->c < 0 || $this->seed < 0) {
            throw new InvalidArgumentException("Los parámetros a, c y seed no pueden ser negativos.");
        }
    }

    public function generate(): array
    {
        $xi = [];
        $ri = [];

        $current = $this->seed;

        for ($i = 0; $i < $this->n; $i++) {
            $current = ($this->a * $current + $this->c) % $this->m;

            $xi[] = $current;
            $ri[] = $current / $this->m;
        }

        return [
            'xi' => $xi,
            'ri' => $ri
        ];
    }
}