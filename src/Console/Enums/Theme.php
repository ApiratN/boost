<?php

declare(strict_types=1);

namespace Laravel\Boost\Console\Enums;

class Theme
{
    public const LARAVEL_RED = 'laravel_red';
    public const GRAY = 'gray';
    public const OCEAN = 'ocean';
    public const VAPORWAVE = 'vaporwave';
    public const SUNSET = 'sunset';

    private static array $gradients = [
        self::LARAVEL_RED => [196, 160, 124, 88, 52, 88],
        self::GRAY => [250, 248, 245, 243, 240, 238],
        self::OCEAN => [81, 75, 69, 63, 57, 21],
        self::VAPORWAVE => [213, 177, 141, 105, 69, 39],
        self::SUNSET => [214, 208, 202, 196, 160, 124],
    ];

    /**
     * @return array<int, int>
     */
    public static function gradient(string $theme): array
    {
        return self::$gradients[$theme];
    }

    public static function primary(string $theme): int
    {
        return self::$gradients[$theme][0];
    }

    public static function accent(string $theme): int
    {
        return self::$gradients[$theme][2];
    }

    public static function random(): string
    {
        $cases = [
            self::LARAVEL_RED,
            self::GRAY,
            self::OCEAN,
            self::VAPORWAVE,
            self::SUNSET,
        ];

        return $cases[array_rand($cases)];
    }
}
