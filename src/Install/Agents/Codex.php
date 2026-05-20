<?php

declare(strict_types=1);

namespace Laravel\Boost\Install\Agents;

use Laravel\Boost\Contracts\SupportsGuidelines;
use Laravel\Boost\Contracts\SupportsMcp;
use Laravel\Boost\Contracts\SupportsSkills;
use Laravel\Boost\Install\Enums\McpInstallationStrategy;
use Laravel\Boost\Install\Enums\Platform;

class Codex extends Agent implements SupportsGuidelines, SupportsMcp, SupportsSkills
{
    public function name(): string
    {
        return 'codex';
    }

    public function displayName(): string
    {
        return 'Codex';
    }

    public function systemDetectionConfig(string $platform): array
    {
        switch ($platform) {
            case Platform::DARWIN:
            case Platform::LINUX:
                return [
                    'command' => 'which codex',
                ];
            case Platform::WINDOWS:
                return [
                    'command' => 'where codex 2>nul',
                ];
            default:
                return [];
        }
    }

    public function projectDetectionConfig(): array
    {
        return [
            'paths' => ['.codex'],
            'files' => ['AGENTS.md'],
        ];
    }

    public function guidelinesPath(): string
    {
        return config('boost.agents.codex.guidelines_path') ?? 'AGENTS.md';
    }

    public function mcpInstallationStrategy(): string
    {
        return McpInstallationStrategy::SHELL;
    }

    public function shellMcpCommand(): string
    {
        return 'codex mcp add {key} -- {command} {args}';
    }

    public function skillsPath(): string
    {
        return config('boost.agents.codex.skills_path') ?? '.codex/skills';
    }
}
