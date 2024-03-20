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
        return view('product.add_product', [
            'products' => Product::all()
        ]);
    }



    public function checkPrice($products)
        {
            foreach ($products as $product) {
                $product->hasaki = $this->hasakiScanner($product->hasaki);
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


