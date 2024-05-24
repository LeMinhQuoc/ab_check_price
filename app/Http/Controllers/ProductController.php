<?php

namespace App\Http\Controllers;

require_once '../vendor/autoload.php';

use App\Models\NowPrice;
use App\Models\PriceOld;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\CrawlerController;
use Goutte\Client;
use DOMDocument;
use DOMXPath;
use Exception;
use DB;


class ProductController extends Controller
{

    // Load homepage check giá
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        $detail =   DB::table('now_prices')->where('p_id', $id)->orderBy('created_at', 'desc')->get();

        return view('product.product_history', [
            'product' => $product,
            'detail' => $detail,
        ]);
    }

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
        return redirect()->route('products.index');
    }

    //Reset database
    public function reset()
    {

        $this->addProductToPNow();
        
        return redirect()->route('products.index');
    }
    // Load homepage check giá
    public function index()
    {
        $products = DB::table('products')->paginate(50);

        $p_rows = DB::select("
        SELECT * 
        FROM (
            SELECT 
            @rn:=IF(@prev = p_id, @rn + 1, 1) as rn,
            @prev:=p_id, 
            t.*
            FROM now_prices t, (SELECT @prev:=null, @rn:=0) as vars
            ORDER BY p_id, created_at DESC
        ) as subquery
        WHERE subquery.rn = 1;
    ");
        return view('product.add_product', [
            'products' => $products,
            'new_p' => $p_rows,
            'c_ab' => $this->configCompare($products, 'p_ab'),
            'c_hsk' => $this->configCompare($products, 'p_hsk'),
            'c_gu' => $this->configCompare($products, 'p_gu'),
            'c_tgk' => $this->configCompare($products, 'p_tgs'),
            'c_tl' => $this->configCompare($products, 'p_lt')
        ]);
    }




    // Load chuỗi thêm chuỗi đánh giá tăng giảm vào
    private function  configCompare($products, $var)
    {
        $array = [];
        $i = 0;
        foreach ($products as $product) {
            $rows = DB::select("
                                    SELECT *
                                    FROM (
                                        SELECT *
                                        FROM now_prices
                                        WHERE p_id = ?
                                        ORDER BY created_at DESC
                                        LIMIT 2
                                    ) subquery
                                    ORDER BY created_at ASC
                                ", [$product->id]);

            if (count($rows) > 1) {
                $array[] = $this->compare($rows[1]->$var, $rows[0]->$var);
            } else {
                $array[] = '';
            }

            $i++;
        }

        return $array;
    }
    // Load chuỗi thêm chuỗi đánh giá tăng giảm vào
    private function  configCompareP($p_olds, $p_news, $var)
    {
        $array = [];
        $i = 0;
        foreach ($p_news as $p_old) {
            $array[] = $this->compare($p_news[$i]->$var, $p_olds[$i]->$var);
            $i++;
        }
        return $array;
    }





    // So sánh nếu giá mới > giá cũ thì hiển thị tăng và ngược lại
    private function compare($new, $old)
    {
        if ($new > $old) {
            return "fa fa-chevron-up";
        } elseif ($new < $old) {
            return "fa fa-chevron-down";
        } else {
            return "";
        }
    }
    // Xóa dữ liệu giá cũ chèn dữ liệu của giá mới vào giá cũ
    private function updateOldPrice($data)
    {
        DB::table('price_olds')->delete();
        $data =  DB::select("
        SELECT * 
        FROM (
            SELECT 
            @rn:=IF(@prev = p_id, @rn + 1, 1) as rn,
            @prev:=p_id, 
            t.*
            FROM now_prices t, (SELECT @prev:=null, @rn:=0) as vars
            ORDER BY p_id, created_at DESC
        ) as subquery
        WHERE subquery.rn = 1;
    ");
        DB::table('price_olds')->insert(json_decode(json_encode($data), true));
    }
    //Lấy dữ liệu từ Products  lấy giá theo link và gán vào bản giá mới

    private function addProductToPNow()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $products = $this->checkPrice(Product::all());


        foreach ($products as $product) {
            DB::table('now_prices')->insert([
                'p_id' => $product->id,
                'p_ab' => $product->ab_beautyworld,
                'p_hsk' => $product->hasaki,
                'p_gu' => $product->guardian,
                'p_tgs' => $product->thegioiskinfood,
                'p_lt' => $product->lamthao,
                'created_at' => now(),
                'updated_at' => now(),
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

    private function abScanner($link)
    {
        return $this->selectScanner($link, 'GET', 'span.pro-price', null, 1000);
    }
    private function hasakiScanner($value)
    {
        return $this->selectScanner($value, 'GET', '#product_final_price', 'value');
    }
    private function guScanner($value)
    {
        return $this->selectScanner($value, 'GET', "//span[@class='price']", null, 1000);
    }
    private function tgScanner($value)
    {
        return $this->selectScanner($value, 'GET', "//div[@class='page-product-info-newprice']", null, 1000);
    }
    private function ltScanner($value)
    {
        return $this->selectScanner($value, 'GET', "//span[@class='current-price ProductPrice']", null, 1000);
    }

    private function selectScanner($value, $method, $selector, $attribute = null, $multiplier = 1)
    {
        $crawler = new CrawlerController();
        $gtagVa=  $crawler->getPrice($value);
  
    
       
        if ($gtagVa) {
           return $gtagVa;
            
        } else {
            $var_client = $this->generalScanner($value, $method, $selector, $attribute, $multiplier);
            if($var_client){
                
            return $var_client;

            }else{
                return $this->domScanner($value, $method, $selector, $attribute, $multiplier);
            }
            
        }
    }

    private function generalScanner($value, $method, $selector, $attribute = null, $multiplier = 1)
    {
        $client = new Client();
        try {
            $crawler = $client->request('GET', $value);
            $elements = $crawler->filter($selector);
            if ($elements->count() > 0) {
                $elementValue = ($attribute !== null) ? $elements->attr($attribute) : $elements->text();
                return $this->cTN($elementValue) * $multiplier;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }

    private function domScanner($value, $method, $selector, $attribute = null, $multiplier = 1)
    {

        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        try {
            $dom->loadHTML(file_get_contents($value));
        } catch (Exception $e) {
            return false;
        }
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);
        $prices = $xpath->query($selector);
        try {
            if ($prices->length > 0) {
                $price = $prices->item(0)->nodeValue;
                return $this->cTN($price);
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /*
    private function abScanner($link)
    {
        $client = new Client();
        try {
            $crawler = $client->request('GET', $link);
            $price = $crawler->filter('span.pro-price');
            if ($price->count() > 0) {
                // Chỉ lấy văn bản nếu có phần tử được tìm thấy
                return $this->cTN($price->text()) * 1000;
            } else {
                // Trả về giá trị ngầm định nếu không có phần tử nào
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }



    // Scanner của từng thương hiệu
    private function hasakiScanner($value)
    {
        $client = new Client();
        try {
            $crawler = $client->request('GET', $value);
            $finalPrices = $crawler->filter('#product_final_price');
            // Kiểm tra xem selector có trả về kết quả không
            if ($finalPrices->count() > 0) {
                $finalPrice = $finalPrices->attr('value');
                return $this->cTN($finalPrice);
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
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
        // Kiểm tra xem có item nào được tìm thấy không
        if ($prices->length > 0) {
            $price = $prices->item(0)->nodeValue;
            return $this->cTN($price) * 1000;
        } else {
            return 0;
        }
    }
    private function tgScanner($value) {
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
        
        // Kiểm tra xem có item nào được tìm thấy không
        if ($prices->length > 0) {
            $price = $prices->item(0)->nodeValue;
            return $this->cTN($price)*1000;
        } else {
            return 0;
        }
    }


    private function ltScanner($value) {
        $dom = new DOMDocument;
        
        libxml_use_internal_errors(true);
        try {
            $dom->loadHTML(file_get_contents($value));
        } catch (Exception $e) {
            return 0;
        }
        libxml_clear_errors();
    
        $xpath=new DOMXPath($dom);
        $prices = $xpath->query("//span[@class='current-price ProductPrice']");
        
        // Kiểm tra xem có item nào được tìm thấy không
        if ($prices->length > 0) {
            $price = $prices->item(0)->nodeValue; 
            return $this->cTN($price)*1000;
        } else {
            return 0;
        }
    } */


    // đưa giá từ chuỗi ký tự về dạng số
    private function cTN($input)
    {
        $number = preg_replace('/[^\d]/', '', $input);
        $number = (float) $number;
        if(strlen((string)$number)>=9){

            return $number/1000;
        }
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
