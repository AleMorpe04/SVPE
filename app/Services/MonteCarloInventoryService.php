<?php

namespace App\Services;

class MonteCarloInventoryService
{
    private $randomNumbers;
    private $demands = [];

    public function __construct(array $randomNumbers)
    {
        $this->randomNumbers = $randomNumbers;
    }

    public function simulate()
    {
        foreach ($this->randomNumbers as $ri) {
            $this->demands[] = $this->mapDemand($ri);
        }

        return $this->calculateStatistics();
    }

    private function mapDemand($ri)
    {
        if ($ri >= 0.00 && $ri <= 0.20) {
            return 10;
        } elseif ($ri <= 0.50) {
            return 20;
        } elseif ($ri <= 0.80) {
            return 30;
        } else {
            return 40;
        }
    }

    private function calculateStatistics()
    {
        $total = array_sum($this->demands);
        $count = count($this->demands);

        $average = $count > 0 ? $total / $count : 0;
        $max = max($this->demands);
        $min = min($this->demands);

        return [
            'demanda_simulada' => $this->demands,
            'demanda_total' => $total,
            'demanda_promedio' => $average,
            'demanda_maxima' => $max,
            'demanda_minima' => $min
        ];
    }
}