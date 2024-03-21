<style>
.styled-form {
    background-color: #333333;
    padding: 20px;
    color: #fff;
    width: 200px;
}

.styled-input {
    display: block;
    margin-bottom: 10px;
    padding: 10px;
    border: none;
    border-radius: 5px;
    color: #333333;
}

.styled-button {
    padding: 10px 20px;
    background-color: #fff;
    border: none;
    border-radius: 5px;
    color: #333333;
    cursor: pointer;
}

.styled-button:hover {
    background-color: #dddddd;
}
</style>



<form action="{{ route('products.store') }}" method="POST" class="styled-form">
    @csrf
    <input type="text" class="styled-input" name="product_barcode" placeholder="barcode">
    <input type="text" class="styled-input" name="brand" placeholder="Brand">
    <input type="text" class="styled-input" name="product_name" placeholder="Product name">
    <input type="text" class="styled-input" name="ab_beautyworld" placeholder="AB Beautyworld">
    <input type="text" class="styled-input" name="hasaki" placeholder="Hasaki">
    <input type="text" class="styled-input" name="guardian" placeholder="Guardian">
    <input type="text" class="styled-input" name="thegioiskinfood" placeholder="thegioiskinfood">
    <input type="text" class="styled-input" name="lamthao" placeholder="lamthao">
    <button type="submit" class="styled-button">Submit</button>
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