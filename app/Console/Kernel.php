<?php

namespace App\Console;
use App\Http\Controllers\ProductController;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        
         $schedule->call(function () {
            $client = new \GuzzleHttp\Client();
        $client->request('GET', 'https://itgacon.xyz/check_p/public/index.php/reset');
        });
        
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
