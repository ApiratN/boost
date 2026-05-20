<?php

declare(strict_types=1);

namespace Laravel\Boost\Install\Enums;

class Platform
{
    public const DARWIN = 'darwin';
    public const LINUX = 'linux';
    public const WINDOWS = 'windows';

    public static function current(): string
    {
        switch (PHP_OS_FAMILY) {
            case 'Windows':
                return self::WINDOWS;
            case 'Darwin':
                return self::DARWIN;
            default:
                return self::LINUX;
        }
    }
}
