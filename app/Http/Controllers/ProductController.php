<?php

namespace App\Http\Controllers;
require_once '../vendor/autoload.php';
use App\Models\NowPrice;
use App\Models\PriceOld;
use Illuminate\Http\Request;
use App\Models\Product;
use Goutte\Client;
use DOMDocument;
use DOMXPath;
use Exception;
use DB;
            

class ProductController extends Controller
{
// Form thêm sản phẩm 
    public function addForm()
    {
        return view('product.add_product_form');
    }
// Xóa 1 dòng Sản Phẩm
    public function delete($id)
    {
        DB::table('products')->where('id', $id)->delete();
        DB::table('now_prices')->where('p_id', $id)->delete();
        DB::table('price_olds')->where('p_id', $id)->delete(); 
        return redirect()->route('products.index'); 
    }

//Reset database
    public function reset() {
        $this->updateOldPrice();
        $this->addProductToPNow();
        return redirect()->route('products.index'); 
    }
// Load homepage check giá
    public function index()
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
            'c_tgk' => $this->configCompare($old_p,$now_p,'p_tgs'),
            'c_tl' => $this->configCompare($old_p,$now_p,'p_tl')
        ]);
    }
// Load chuỗi thêm chuỗi đánh giá tăng giảm vào
    private function  configCompare($p_olds,$p_news,$var){
            $array=[];
            $i=0;
            foreach($p_olds as $p_old ){
                $array[]=$this->compare($p_news[$i]->$var,$p_olds[$i]->$var);
                $i++;
            }
            return $array;
    }
// So sánh nếu giá mới > giá cũ thì hiển thị tăng và ngược lại
    private function compare($new,$old){
            if($new > $old){
                return "fa fa-chevron-up";
            }elseif($new < $old){
                return "fa fa-chevron-down";
            }else {
                return "";
            } 
    }
// Xóa dữ liệu giá cũ chèn dữ liệu của giá mới vào giá cũ
    private function updateOldPrice(){
        DB::table('price_olds')->delete();
        $data = DB::table('now_prices')->get()->toArray();
        DB::table('price_olds')->insert(json_decode(json_encode($data), true));
    }
//Lấy dữ liệu từ Products  lấy giá theo link và gán vào bản giá mới

    private function addProductToPNow()
    {
        $products=$this->checkPrice(Product::all());
        DB::table('now_prices')->delete();
         foreach($products as $product){
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

// Check giá theo link
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
// Scanner của từng thương hiệu
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
        $price = $prices->item(0)->nodeValue; 
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
            return 0;
        }return $this->cTN($price->text())*1000;
            
        }
        // đưa giá từ chuỗi ký tự về dạng số
        private function cTN($input) {
            $number = preg_replace('/[^\d,.]/', '', $input);
            $number = str_replace(',', '.', $number);
            $number = (float) $number;
            return $number;
        }
// Nhập dữ liệu mới theo Form 
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