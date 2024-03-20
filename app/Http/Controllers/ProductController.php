<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
require_once '../vendor/autoload.php';
use Goutte\Client;
            

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        $product_checked=Product::all();
        return view('product.add_product', [
            'products' => $product_checked
        ]);
    }



    public function checkPrice($products)
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
            $crawler = $client->request('GET', $value);
            $finalPrice = $crawler->filter('#product_final_price')->attr('value');
            return $finalPrice;
        }

        private function guScanner($value)
        {
            $client = new Client();
            $crawler = $client->request('GET', $value);
            $finalPrice = $crawler->filter('span.price')->attr('value');
            return $finalPrice;
        }
        private function tgScanner($value)
        {
            $client = new Client();
            $crawler = $client->request('GET', $value);
            $finalPrice = $crawler->filter('span.page-product-info-newprice span')->attr('value');
            return $finalPrice;
        }
        private function ltScanner($link)
        {
            $client = new Client();
            $crawler = $client->request('GET', $link);
            $price = $crawler->filter('span.ProductPrice');
            return $price->text();
            
        }
        private function abScanner($link)
        {
            $client = new Client();
            $crawler = $client->request('GET', $link);
            $price = $crawler->filter('span.pro-price');
            return $price->text();
            
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


