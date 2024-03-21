<?php

namespace App\Http\Controllers;

use App\Models\NowPrice;
use App\Models\PriceOld;
use Illuminate\Http\Request;
use App\Models\Product;
require_once '../vendor/autoload.php';
use Goutte\Client;
use DOMDocument;
use DOMXPath;
use Exception;
use DB;
            

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        
        $product_checked=Product::all();
        $now_p=NowPrice::all();
        $old_p=PriceOld::all();

    

        return view('product.add_product', [
            'products' => $product_checked,
            'old_p'=> $old_p,
            'new_p'=> $now_p,
            'c_ab' => $this->configCompare($old_p,$now_p,'p_ab'),
            'c_hsk' => $this->configCompare($old_p,$now_p,'p_hsk'),
            'c_gu' => $this->configCompare($old_p,$now_p,'p_gu'),
            'c_tgk' => $this->configCompare($old_p,$now_p,'p_tgk'),
            'c_tl' => $this->configCompare($old_p,$now_p,'p_tl')
        ]);
    //   $this-> updateOldPrice();
    }

    private function  configCompare($p_olds,$p_news,$var){
            $array=[];
            $i=0;

            foreach($p_olds as $p_old ){
                
                $array[]=$this->compare($p_news[$i]->$var,$p_olds[$i]->$var);
                $i++;
            }
            return $array;
            
    }

    private function compare($new,$old){
       
       
            if($new > $old){
                return "tăng";
            }elseif($new < $old){
                return "giảm";
            }else {
                return "";
            }

        
    }
    public function updateOldPrice(){
        DB::table('price_olds')->delete();
        $data = DB::table('now_prices')->get()->toArray();
        DB::table('price_olds')->insert(json_decode(json_encode($data), true));
    }

    public function addProductToPNow()
    {
        $products=$this->checkPrice(Product::all());
        DB::table('now_prices')->delete();

         foreach($products as $product){
            var_dump($product->hasaki);
            DB::table('now_prices')->insert([
                'p_id' => $product->id,
                'p_ab' => $product->ab_beautyworld,
                'p_hsk'=> $product->hasaki,
                'p_gu'=> $product->guardian,
                'p_tgs'=> $product->thegioiskinfood,
                'p_lt'=> $product->lamthao,
            ]);
         }
    }


    private function checkPrice($products)
        {
            foreach ($products as $product) {
                $product->ab_beautyworld = $this->abScanner($product->ab_beautyworld);
                $product->hasaki = $this->hasakiScanner($product->hasaki);
                $product->guardian = $this->guScanner($product->guardian);
                $product->thegioiskinfood = $this->tgScanner($product->thegioiskinfood);
                $product->lamthao = $this->ltScanner($product->lamthao);
            }
            return $products;
        }

        private function hasakiScanner($value)
        {
            $client = new Client();
        try {
            $crawler = $client->request('GET', $value);
            $finalPrice = $crawler->filter('#product_final_price')->attr('value');
        } catch (Exception $e) {
            return 0;
        }
            return $this->cTN($finalPrice);
        }

        private function guScanner($value)
        { 
           
            $dom = new DOMDocument;

            libxml_use_internal_errors(true);
            try {
            $dom->loadHTML(file_get_contents($value));
        } catch (Exception $e) {
            return 0;
        }
            libxml_clear_errors();
    
            $xpath = new DOMXPath($dom);
            $prices = $xpath->query("//span[@class='price']");
            $price = $prices->item(0)->nodeValue;
            return $this->cTN($price)*1000;

        }
        private function tgScanner($value)
        {
        $dom = new DOMDocument;

        libxml_use_internal_errors(true);
        try {
        $dom->loadHTML(file_get_contents($value));
         } catch (Exception $e) {
        return 0;
         }
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $prices = $xpath->query("//div[@class='page-product-info-newprice']");
        $price = $prices->item(0)->nodeValue;
        
        return $this->cTN($price)*1000;
        }
           
      
        private function ltScanner($value)
        { 
        $dom = new DOMDocument;
        
        libxml_use_internal_errors(true);
        try {
        $dom->loadHTML(file_get_contents($value));}
        catch (Exception $e) {
            return 0;
             }
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $prices = $xpath->query("//span[@class='current-price ProductPrice']");
        $price = $prices->item(0)->nodeValue; // Remove the trailing text from the price

        $price = $this->cTN($price)*1000;  
        
        return $price;        
        }
        private function abScanner($link)
        {
            $client = new Client();
            try {
            $crawler = $client->request('GET', $link);
            $price = $crawler->filter('span.pro-price');
            
        } catch (Exception $e) {
            // Handle the exception here
            return 0;
        }return $this->cTN($price->text())*1000;
            
        }

        private function cTN($input) {
            // Remove any non-numeric characters and currency symbols
            $number = preg_replace('/[^\d,.]/', '', $input);
        
            // Replace commas with decimal points
            $number = str_replace(',', '.', $number);
        
            // Convert the number to a float
            $number = (float) $number;
        
            return $number;
        }

        


       



    public function store(Request $request)
{
    $validatedData = $request->validate([
        'product_barcode' => 'required|max:255',
        'brand' => 'required|max:255',
        'product_name' => 'required|max:255',
        'ab_beautyworld' => 'required|max:255',
        'hasaki' => 'required|max:255',
        'guardian' => 'required|max:255',
        'thegioiskinfood' => 'required|max:255',
        'lamthao' => 'required|max:255',
    ]);

    $product = Product::create($validatedData);

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}

}


