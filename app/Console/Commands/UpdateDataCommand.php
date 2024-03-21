<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use DB;

class UpdateDataCommand extends Command
{
   
    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
   // Tên và mô tả cho command
   protected $signature = 'update:data';
   protected $description = 'Update data from p_now to p_past';

   public function __construct()
   {
       parent::__construct();
   }

   // Hàm handle chính xác là nơi chúng ta đặt logic
   public function handle()
   {
       // Xóa dữ liệu từ p_past
       DB::table('price_olds')->delete();
       
       // Sao chép dữ liệu từ p_now sang p_past
       $data = DB::table('now_prices')->get()->toArray();
       DB::table('price_olds')->insert(json_decode(json_encode($data), true));
   }
}
