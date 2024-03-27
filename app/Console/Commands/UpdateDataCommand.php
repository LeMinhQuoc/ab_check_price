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
/*
array(2) { [0]=> array(2) { 
    [0]=> object(stdClass)#1273 (9)
     { 
        ["id"]=> int(30) 
        ["p_id"]=> int(1) 
        ["p_ab"]=> int(5000) 
        ["p_hsk"]=> int(5000) 
        ["p_gu"]=> int(5000) 
        ["p_tgs"]=> int(5000) 
        ["p_lt"]=> int(5000)
        ["created_at"]=> string(19) "2024-03-27 10:13:32" 
        ["updated_at"]=> string(19) "2024-03-27 10:13:32" } 
    [1]=> object(stdClass)#1272 (9)
     { 
        ["id"]=> int(31) 
        ["p_id"]=> int(1) 
        ["p_ab"]=> int(5000)
        ["p_hsk"]=> int(5000)
        ["p_gu"]=> int(5000)
        ["p_tgs"]=> int(5000)
        ["p_lt"]=> int(5000)
        ["created_at"]=> string(19) "2024-03-27 10:13:35" 
        ["updated_at"]=> string(19) "2024-03-27 10:13:35" 
    } 
} 
[1]=> array(1) 
{ [0]=> object(stdClass)#304 (9) 
    { 
        ["id"]=> int(28) 
        ["p_id"]=> int(3) 
        ["p_ab"]=> int(536250) 
        ["p_hsk"]=> int(415000) 
        ["p_gu"]=> int(549000) 
        ["p_tgs"]=> int(209000) 
        ["p_lt"]=> int(119000) 
        ["created_at"]=> NULL 
        ["updated_at"]=> NULL } } }
        */