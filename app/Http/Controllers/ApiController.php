<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Exception;
use DB;

class ApiController extends Controller
{
    public function saveId(Request $request)
    {
        $id = $request->input('id');
        $phone = $request->input('phone');

        if (!empty($id)) {
            // Đọc file nếu tồn tại
            $path = public_path('ip_data.json');
            if (file_exists($path)) {
                $data = json_decode(file_get_contents($path), true);
            } else {
                $data = [];
            }

            // Thêm ID mới vào mảng
            $data[] = 'ip='.$id;
             $data[] = 'phone='.$phone;

            // Ghi lại vào file
            file_put_contents($path, json_encode($data));
            
            return response()->json(['message' => 'ID saved successfully']);
        } else {
            return response()->json(['error' => 'ID is required'], 400);
        }
    }
    
    
    
    public function productDetailAPI(Request $request){
    $barcode = $request->barcode;
    $pro = DB::table('product_id')->where('barcode', $barcode)->first();
    $pro_id=$pro->id;
    $baseUrl = 'https://apis.haravan.com/com/products/';
    $bearerToken = '8672E3C68AF157BDE70E4CC6DF58BF09CDED16AFA455BF167E45D15055094122';
    $client = new Client();
   
        $response = $client->request('GET', $baseUrl . $pro_id . '.json', [
            'headers' => [
                'Authorization' => 'Bearer ' . $bearerToken,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

         $data = json_decode($response->getBody(), true);


        $ab_p_url='https://abbeautyworld.com/products/';
        $url = $data['product']['handle'];
        $product = new Client();
        $response = $client->request('GET', $ab_p_url . $url . '.json');
        $data_v = json_decode($response->getBody(), true);
        return $data_v['product'];
}
}
