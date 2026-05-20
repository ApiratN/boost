<?php

declare(strict_types=1);

namespace Laravel\Boost\Install\Agents;

use Laravel\Boost\Contracts\SupportsGuidelines;
use Laravel\Boost\Contracts\SupportsMcp;
use Laravel\Boost\Contracts\SupportsSkills;
use Laravel\Boost\Install\Enums\McpInstallationStrategy;
use Laravel\Boost\Install\Enums\Platform;

class ClaudeCode extends Agent implements SupportsGuidelines, SupportsMcp, SupportsSkills
{
    public function name(): string
    {
        return 'claude_code';
    }

    public function displayName(): string
    {
        return 'Claude Code';
    }

    public function systemDetectionConfig(string $platform): array
    {
        switch ($platform) {
            case Platform::DARWIN:
            case Platform::LINUX:
                return [
                    'command' => 'command -v claude',
                ];
            case Platform::WINDOWS:
                return [
                    'command' => 'where claude 2>nul',
                ];
            default:
                return [];
        }
    }

    public function projectDetectionConfig(): array
    {
        return [
            'paths' => ['.claude'],
            'files' => ['CLAUDE.md'],
        ];
    }

    public function mcpInstallationStrategy(): string
    {
        return McpInstallationStrategy::FILE;
    }

    public function mcpConfigPath(): string
    {
        return '.mcp.json';
    }

    public function guidelinesPath(): string
    {
        return config('boost.agents.claude_code.guidelines_path') ?? 'CLAUDE.md';
    }

    public function skillsPath(): string
    {
        return config('boost.agents.claude_code.skills_path') ?? '.claude/skills';
    }
}
