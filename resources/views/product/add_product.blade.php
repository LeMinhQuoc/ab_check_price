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