<?php

namespace App\Console\Commands;

use App\Models\NfeSuccesses;
use App\Modules\Nfe\Nfe;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;

class ProcessNfe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:nfe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Nfe. Get from Arquivei and Store in database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $nfe = app()->make(Nfe::class);
        $nfe->GetAndStoreAllNfe();
    }
}
