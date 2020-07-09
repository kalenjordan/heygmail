<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

abstract class AbstractCommand extends Command
{
    public function info($string, $verbosity = null)
    {
        if (!$this->option('silent')) {
            parent::info($string);
        }
    }
}
