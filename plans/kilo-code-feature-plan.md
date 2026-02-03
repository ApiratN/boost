# Kilo Code Feature Implementation Plan

## Overview

This plan outlines the implementation of Kilo Code support for Laravel Boost. Kilo Code is an AI-powered coding assistant that needs to be integrated as a new Agent in the Boost ecosystem.

## Current Architecture Understanding

### Agent System
- **Base Class**: [`Agent`](../src/Install/Agents/Agent.php) (abstract)
- **Supported Interfaces**:
  - [`SupportsGuidelines`](../src/Contracts/SupportsGuidelines.php) - AI guidelines support
  - [`SupportsMcp`](../src/Contracts/SupportsMcp.php) - MCP server support
  - [`SupportsSkills`](../src/Contracts/SupportsSkills.php) - Agent skills support

### Existing Agents
- Junie, Cursor, Claude Code, Codex, Copilot, OpenCode, Gemini

### Key Components
- [`BoostManager`](../src/BoostManager.php) - Manages registered agents
- [`ToolRegistry`](../src/Mcp/ToolRegistry.php) - Manages MCP tools
- [`InstallCommand`](../src/Console/InstallCommand.php) - Installation CLI

## Implementation Steps

### Step 1: Create KiloCode Agent Class

**File**: `src/Install/Agents/KiloCode.php`

**Requirements**:
- Extend `Agent` abstract class
- Implement appropriate interfaces based on Kilo Code's capabilities
- Define detection configurations for all platforms (Darwin, Linux, Windows)

**Key Methods to Implement**:
```php
- name(): string → 'kilo_code'
- displayName(): string → 'Kilo Code'
- systemDetectionConfig(Platform $platform): array
- projectDetectionConfig(): array
- mcpConfigPath(): string '.kilocode/mcp.json'
- guidelinesPath(): string '.kilocode/rules'
- skillsPath(): string '.kilocode/skills/'
- frontmatter(): bool true
```

**Platform Detection Strategy**:
- Need to determine how Kilo Code is installed:
  - CLI command (e.g., `kilo`, `kilo-code`)
  - Desktop application path
  - VS Code extension path
  - Project-specific markers (e.g., `.kilo`, `KILO.md`)

### Step 2: Register KiloCode in BoostManager

**File**: `src/BoostManager.php`

**Changes**:
- Add `'kilo_code' => KiloCode::class` to the `$agents` array

### Step 3: Add Configuration Options

**File**: `config/boost.php`

**Optional Enhancement**:
- Add Kilo Code specific configuration section if needed:
```php
'agents' => [
    'kilo_code' => [
        'guidelines_path' => '.kilocode/rules/AGENTS.md',
        'skills_path' => '.kilocode/skills',
    ],
],
```

### Step 4: Create Unit Tests

**Test Files**:
- `tests/Unit/Install/Agents/KiloCodeTest.php` - Basic agent functionality
- `tests/Feature/Install/Agents/KiloCodePathResolutionTest.php` - Path resolution tests

**Test Coverage**:
- Agent name and display name
- System detection for each platform
- Project detection
- MCP configuration path
- Guidelines path
- Skills path (if applicable)

### Step 5: Update Documentation

**Documentation Updates**:
- Update README.md to mention Kilo Code support
- Add Kilo Code specific documentation if needed


### 1. Kilo Code Capabilities
- Does Kilo Code support MCP (Model Context Protocol)? Yes
- Does Kilo Code accept AI guidelines files? Yes
- Does Kilo Code support agent skills? Yes

## Implementation Checklist

- [ ] Gather information about Kilo Code's capabilities
- [ ] Determine detection strategy for Kilo Code
- [ ] Identify configuration file paths for Kilo Code
- [ ] Create `src/Install/Agents/KiloCode.php` class
- [ ] Implement required methods in KiloCode class
- [ ] Register KiloCode in `src/BoostManager.php`
- [ ] Add configuration options to `config/boost.php` (if needed)
- [ ] Create `tests/Unit/Install/Agents/KiloCodeTest.php`
- [ ] Create `tests/Feature/Install/Agents/KiloCodePathResolutionTest.php`
- [ ] Update README.md documentation
- [ ] Test installation with `php artisan boost:install`
- [ ] Verify MCP configuration is written correctly
- [ ] Verify guidelines are written correctly (if supported)
- [ ] Verify skills are synced correctly (if supported)
