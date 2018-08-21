<?php

namespace Modules\Evolutly\Console\Commands;

use Modules\Evolutly\Evolutly;
use Illuminate\Console\Command;

class VersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'evo:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View the current Evolutly version';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('<info>Evoluty</info> version <comment>'.Evolutly::$version.'</comment>');
    }
}
