<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <input type="text" name="product_barcode" placeholder="barcode">
    <input type="text" name="brand" placeholder="Brand">
    <input type="text" name="product_name" placeholder="Product name">
    <input type="text" name="ab_beautyworld" placeholder="AB Beautyworld">
    <input type="text" name="hasaki" placeholder="Hasaki">
    <input type="text" name="guardian" placeholder="Guardian">
    <input type="text" name="thegioiskinfood" placeholder="thegioiskinfood">
    <input type="text" name="lamthao" placeholder="lamthao">
    <button type="submit">Submit</button>
</form>

<table>
  <thead>
    <tr>
    <th>Barcode</th>
      <th>Product</th>
      <th>Brand</th>
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
            <td>{{$product->product_barcode}}</td>
            <td>{{ $product->product_name }}</td>
            <td>{{$product->brand}}</td>
            <td>{{ $product->ab_beautyworld }}</td>
            <td>{{ $product->hasaki }}</td>
            <td>{{ $product->guardian }}</td>
            <td>{{ $product->thegioiskinfood }}</td>
            <td>{{ $product->lamthao }}</td>
        </tr>
    @endforeach
  </tbody>
</table>