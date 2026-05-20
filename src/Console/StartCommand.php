<?php

declare(strict_types=1);

namespace Laravel\Boost\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class StartCommand extends Command
{
    protected $name = 'boost:mcp';

    protected $description = 'Starts Laravel Boost (usually from mcp.json)';

    public function handle(): int
    {
        return Artisan::call('mcp:start laravel-boost');
    }
}
