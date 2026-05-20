<?php

declare(strict_types=1);

namespace Laravel\Boost\Install\Agents;

use Laravel\Boost\Contracts\SupportsGuidelines;
use Laravel\Boost\Contracts\SupportsMcp;
use Laravel\Boost\Contracts\SupportsSkills;
use Laravel\Boost\Install\Enums\Platform;

class Gemini extends Agent implements SupportsGuidelines, SupportsMcp, SupportsSkills
{
    public function name(): string
    {
        return 'gemini';
    }

    public function displayName(): string
    {
        return 'Gemini CLI';
    }

    public function systemDetectionConfig(string $platform): array
    {
        switch ($platform) {
            case Platform::DARWIN:
            case Platform::LINUX:
                return [
                    'command' => 'command -v gemini',
                ];
            case Platform::WINDOWS:
                return [
                    'command' => 'where gemini 2>nul',
                ];
            default:
                return [];
        }
    }

    public function projectDetectionConfig(): array
    {
        return [
            'paths' => ['.gemini'],
            'files' => ['GEMINI.md'],
        ];
    }

    public function mcpConfigPath(): string
    {
        return '.gemini/settings.json';
    }

    public function guidelinesPath(): string
    {
        return config('boost.agents.gemini.guidelines_path') ?? 'GEMINI.md';
    }

    public function skillsPath(): string
    {
        return config('boost.agents.gemini.skills_path') ?? '.gemini/skills';
    }
}
