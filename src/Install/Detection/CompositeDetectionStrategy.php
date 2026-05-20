<?php

declare(strict_types=1);

namespace Laravel\Boost\Install\Detection;

use Laravel\Boost\Install\Contracts\DetectionStrategy;

class CompositeDetectionStrategy implements DetectionStrategy
{
    /**
     * @param  DetectionStrategy[]  $strategies
     */
    private array $strategies;

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    public function detect(array $config, ?string $platform = null): bool
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->detect($config, $platform)) {
                return true;
            }
        }

        return false;
    }
}
