<?php

declare(strict_types=1);

namespace Laravel\Boost\Install\Agents;

use Laravel\Boost\Contracts\SupportsGuidelines;
use Laravel\Boost\Contracts\SupportsMcp;
use Laravel\Boost\Contracts\SupportsSkills;
use Laravel\Boost\Install\Enums\McpInstallationStrategy;
use Laravel\Boost\Install\Enums\Platform;

class KiloCode extends Agent implements SupportsGuidelines, SupportsMcp, SupportsSkills
{
    public function name(): string
    {
        return 'kilo_code';
    }

    public function displayName(): string
    {
        return 'Kilo Code';
    }

    public function systemDetectionConfig(string $platform): array
    {
        switch ($platform) {
            case Platform::DARWIN:
            case Platform::LINUX:
                return [
                    'command' => 'command -v kilo-code 2>/dev/null',
                ];
            case Platform::WINDOWS:
                return [
                    'command' => 'where kilo-code 2>nul',
                ];
            default:
                return [];
        }
    }

    public function projectDetectionConfig(): array
    {
        return [
            'paths' => ['.kilocode'],
            'files' => ['.kilocode/rules/AGENTS.md'],
        ];
    }

    public function mcpInstallationStrategy(): string
    {
        return McpInstallationStrategy::FILE;
    }

    public function mcpConfigPath(): string
    {
        return '.kilocode/mcp.json';
    }

    public function guidelinesPath(): string
    {
        return config('boost.agents.kilo_code.guidelines_path') ?? '.kilocode/rules';
    }

    public function skillsPath(): string
    {
        return config('boost.agents.kilo_code.skills_path') ?? '.kilocode/skills';
    }

    public function frontmatter(): bool
    {
        return true;
    }
}
