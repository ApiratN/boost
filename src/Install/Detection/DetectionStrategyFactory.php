<?php

declare(strict_types=1);

namespace Laravel\Boost\Install\Detection;

use Illuminate\Container\Container;
use InvalidArgumentException;
use Laravel\Boost\Install\Contracts\DetectionStrategy;

class DetectionStrategyFactory
{
    private const TYPE_DIRECTORY = 'directory';

    private const TYPE_COMMAND = 'command';

    private const TYPE_FILE = 'file';

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function make(string|array $type, array $config = []): DetectionStrategy
    {
        if (is_array($type)) {
            return new CompositeDetectionStrategy(
                array_map(fn (string|array $singleType): DetectionStrategy => $this->make($singleType, $config), $type)
            );
        }

        switch ($type) {
            case self::TYPE_DIRECTORY:
                return $this->container->make(DirectoryDetectionStrategy::class);
            case self::TYPE_COMMAND:
                return $this->container->make(CommandDetectionStrategy::class);
            case self::TYPE_FILE:
                return $this->container->make(FileDetectionStrategy::class);
            default:
                throw new InvalidArgumentException("Unknown detection type: {$type}");
        }
    }

    public function makeFromConfig(array $config): DetectionStrategy
    {
        $type = $this->inferTypeFromConfig($config);

        return $this->make($type, $config);
    }

    protected function inferTypeFromConfig(array $config): string|array
    {
        $typeMap = [
            'files' => self::TYPE_FILE,
            'paths' => self::TYPE_DIRECTORY,
            'command' => self::TYPE_COMMAND,
        ];

        $types = collect($typeMap)
            ->only(array_keys($config))
            ->values()
            ->all();

        if (empty($types)) {
            throw new InvalidArgumentException(
                'Cannot infer detection type from config keys. Expected one of: '.collect($typeMap)->keys()->join(', ')
            );
        }

        return count($types) > 1 ? $types : reset($types);
    }
}
