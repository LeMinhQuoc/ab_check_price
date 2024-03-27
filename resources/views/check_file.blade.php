<?php
$products = [
    (object) [
        'product_name' => 'Product 1',
        'ab_beautyworld' => '1000',
        'hasaki' => '2000',
        'guardian' => '3000',
        'thegioiskinfood' => '4000',
        'lamthao' => '5000'
    ],
    (object) [
        'product_name' => 'Product 2',
        'ab_beautyworld' => '6000',
        'hasaki' => '7000',
        'guardian' => '8000',
        'thegioiskinfood' => '9000',
        'lamthao' => '10000'
    ],
    (object) [
        'product_name' => 'Product 3',
        'ab_beautyworld' => '11000',
        'hasaki' => '12000',
        'guardian' => '13000',
        'thegioiskinfood' => '14000',
        'lamthao' => '15000'
    ],
    (object) [
        'product_name' => 'Product 4',
        'ab_beautyworld' => '16000',
        'hasaki' => '17000',
        'guardian' => '18000',
        'thegioiskinfood' => '19000',
        'lamthao' => '20000'
    ],
    (object) [
        'product_name' => 'Product 5',
        'ab_beautyworld' => '21000',
        'hasaki' => '22000',
        'guardian' => '23000',
        'thegioiskinfood' => '24000',
        'lamthao' => '25000'
    ],
    (object) [
        'product_name' => 'Product 6',
        'ab_beautyworld' => '26000',
        'hasaki' => '27000',
        'guardian' => '28000',
        'thegioiskinfood' => '29000',
        'lamthao' => '30000'
    ],
    (object) [
        'product_name' => 'Product 7',
        'ab_beautyworld' => '31000',
        'hasaki' => '32000',
        'guardian' => '33000',
        'thegioiskinfood' => '34000',
        'lamthao' => '35000'
    ],
    (object) [
        'product_name' => 'Product 8',
        'ab_beautyworld' => '36000',
        'hasaki' => '37000',
        'guardian' => '38000',
        'thegioiskinfood' => '39000',
        'lamthao' => '40000'
    ],
    (object) [
        'product_name' => 'Product 9',
        'ab_beautyworld' => '41000',
        'hasaki' => '42000',
        'guardian' => '43000',
        'thegioiskinfood' => '44000',
        'lamthao' => '45000'
    ],
    (object) [
        'product_name' => 'Product 10',
        'ab_beautyworld' => '46000',
        'hasaki' => '47000',
        'guardian' => '48000',
        'thegioiskinfood' => '49000',
        'lamthao' => '50000'
    ],
];
?>

<table>
  <thead>
    <tr>
      <th>Product</th>
      <th>AB Beautyworld</th>
      <th>Hasaki</th>
      <th>Guardian</th>
      <th>thegioiskinfood</th>
      <th>Lamthao</th>
    </tr>
  </thead>
  <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->ab_beautyworld }}</td>
            <td>{{ $product->hasaki }}</td>
            <td>{{ $product->guardian }}</td>
            <td>{{ $product->thegioiskinfood }}</td>
            <td>{{ $product->lamthao }}</td>
        </tr>
    @endforeach
  </tbody>
</table>






<a href="{{ route('add_p_form') }}" class="btn btn-primary">Chuyển hướng</a>
