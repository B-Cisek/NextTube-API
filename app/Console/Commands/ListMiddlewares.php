<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Http\Kernel;

class ListMiddlewares extends Command
{
    protected $signature = 'middleware:list';

    protected $description = 'List all middlewares';

    public function handle(): void
    {
        /** @var Kernel $kernel */
        $kernel = $this->getLaravel()->make(Kernel::class);

        $this->info('Global Middlewares:');
        foreach ($kernel->getGlobalMiddleware() as $middleware) {
            $this->line($middleware);
        }

        $this->info("\nRoute Middleware Groups:");
        foreach ($kernel->getMiddlewareGroups() as $group => $middlewares) {
            $this->info("  {$group}:");
            foreach ($middlewares as $middleware) {
                $this->line("    - {$middleware}");
            }
        }

        $this->info("\nRoute Middlewares:");
        foreach ($kernel->getRouteMiddleware() as $alias => $middleware) {
            $this->line("  {$alias}: {$middleware}");
        }
    }
}
