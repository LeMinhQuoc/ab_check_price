<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
require_once '../vendor/autoload.php';
use Goutte\Client;
use DOMDocument;
use DOMXPath;
use Exception;
            

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        $product_checked=$this->checkPrice(Product::all());
        return view('product.add_product', [
            'products' => $product_checked
        ]);
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
            return "liên kêt không tồn tại hoặc sai định dạng";
        }
            return $finalPrice;
        }

        private function guScanner($value)
        { 
           
            $dom = new DOMDocument;

            libxml_use_internal_errors(true);
            try {
            $dom->loadHTML(file_get_contents($value));
        } catch (Exception $e) {
            return "liên kêt không tồn tại hoặc sai định dạng";
        }
            libxml_clear_errors();
    
            $xpath = new DOMXPath($dom);
            $prices = $xpath->query("//span[@class='price']");
            $price = $prices->item(0)->nodeValue;
            return $price;

        }
        private function tgScanner($value)
        {
        $dom = new DOMDocument;

        libxml_use_internal_errors(true);
        try {
        $dom->loadHTML(file_get_contents($value));
         } catch (Exception $e) {
        return "liên kêt không tồn tại hoặc sai định dạng";
         }
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $prices = $xpath->query("//div[@class='page-product-info-newprice']");
        $price = $prices->item(0)->nodeValue;
        
        return $price;
        }
           
      
        private function ltScanner($value)
        { 
        $dom = new DOMDocument;
        
        libxml_use_internal_errors(true);
        try {
        $dom->loadHTML(file_get_contents($value));}
        catch (Exception $e) {
            return "liên kêt không tồn tại hoặc sai định dạng";
             }
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $prices = $xpath->query("//span[@class='current-price ProductPrice']");
        $price = $prices->item(0)->nodeValue; // Remove the trailing text from the price

        $price = $price;
        
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
            return "liên kêt không tồn tại hoặc sai định dạng";
        }return $price->text();
            
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


