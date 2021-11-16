<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\equipo;

class updateCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateCode:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        //return Command::SUCCESS;
//        $equipos = equipo::all();
//        $alea = rand(000000, 999999);
//        equipo::where('id','=',2)->update(['code' => $alea]);
//            if (sizeof($equipos) > 0) {
//                $i = 0;
//                while ($i < sizeof($equipos)) {
//                    $colocado = false;
//                    while (!$colocado) {
//                        $alea = rand(000000, 999999);
//                        $repetido = false;
//                        while (!$repetido) {
//                            foreach ($equipos as $k => $equipo) {
//                                if ($equipo->code == $alea) {
//                                    $repetido = true;
//                                }
//                            }
//                        }
//                        if (!$colocado && !$repetido) {
//                            equipo::where('id','=',$i+1)->update(['code' => $alea]);
//                            $colocado = true;
//                            $i++;
//                        }
//                    }
//                }
//            }
    }
}
