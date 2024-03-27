<!DOCTYPE html>
<html>
<head>
	<title>Price Comparison</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/add_pro.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

</head>

<body>
	<header>
		<h1>Danh Sách Sản Phẩm</h1>
	</header>
	<main>

  <section>

  <button id="showPopup" class="btn btn-secondary">Thêm Sản Phẩm</button> 

<div id="popupForm">
    <div id="formContainer">

      <form action="{{ route('products.store') }}" method="POST" class="styled-form">
        <p class="formTitle">Thêm Mới Một Sản Phẩm</p>
        @csrf
        <input type="text" class="styled-input" name="product_barcode" placeholder="Barcode">
        <input type="text" class="styled-input" name="brand" placeholder="Brand">
        <input type="text" class="styled-input" name="product_name" placeholder="Product name">
        <input type="text" class="styled-input" name="ab_beautyworld" placeholder="Link Sản Phẩm AB Beautyworld">
        <input type="text" class="styled-input" name="hasaki" placeholder="Link Sản PhẩmHasaki">
        <input type="text" class="styled-input" name="guardian" placeholder="Link Sản PhẩmGuardian">
        <input type="text" class="styled-input" name="thegioiskinfood" placeholder="Link Sản Phẩm thegioiskinfood">
        <input type="text" class="styled-input" name="lamthao" placeholder="Link Sản Phẩm lamthao">
        <button type="submit" class="styled-button">Submit</button>
      </form>
    </div>
</div>
</section>

<!--  <section>
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
</section> -->
	
    
		<section>
			<table>
            <thead>
                <tr>
                <th>STT</th>
                <th>Barcode</th>
                <th>Product</th>
                <th>Brand</th>
                <th>AB</th>
                <th>Hasaki</th>
                <th>Guardian</th>
                <th>Thegioiskinfood</th>
                <th>Lamthao</th>
                <th>Action</th>
                </tr>
            </thead>
				<tbody>
             <?php  $term =0; 
             $last_up_date='';?>      
            @foreach($products as $product)
            <?php
            $ab_icon = $c_ab[$term]; $ab_color = '';if ($ab_icon == 'fa fa-chevron-up') {$ab_color = '#63E6BE';}if ($ab_icon == 'fa fa-chevron-down') {$ab_color = 'red'; } $hsk_icon = $c_hsk[$term];$hsk_color = ''; if ($hsk_icon == 'fa fa-chevron-up') {$hsk_color = '#63E6BE';}if ($hsk_icon == 'fa fa-chevron-down') {$hsk_color = 'red'; }$gu_icon = $c_gu[$term];$gu_color = '';if ($gu_icon == 'fa fa-chevron-up') {$gu_color = '#63E6BE';}if ($gu_icon == 'fa fa-chevron-down') {$gu_color = 'red'; }$tgk_icon = $c_tgk[$term];$tgk_color = ''; if ($tgk_icon == 'fa fa-chevron-up') {$tgk_color = '#63E6BE';}if ($tgk_icon == 'fa fa-chevron-down') {$tgk_color = 'red'; } $tl_icon = $c_tl[$term]; $tl_color = '';if ($tl_icon == 'fa fa-chevron-up') {$tl_color = '#63E6BE';}if ($tl_icon == 'fa fa-chevron-down') {$tl_color = 'red'; }
            ?>
                <tr>
                <td>{{$term +1}}</td>
                    <td>{{$product->product_barcode}}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{$product->brand}}</td>
                    <td data-value="{{$new_p[$term]->p_ab}}" alt=""> <a class="link-price" href="{{$product->ab_beautyworld}}"> @if(is_numeric($new_p[$term]->p_ab )) @if($new_p[$term]->p_ab  > 0){{ number_format($new_p[$term]->p_ab , 0, ',', '.') }} (đ)@else  -  @endif @endif  <i class="{{ $c_ab[$term]}}" style=" color: <?php echo $ab_color; ?>;"></i></a> </td>
                    <td data-value="{{$new_p[$term]->p_hsk}}" alt=""> <a class="link-price" href="{{$product->hasaki}}">@if(is_numeric($new_p[$term]->p_hsk )) @if($new_p[$term]->p_hsk  > 0){{ number_format($new_p[$term]->p_hsk , 0, ',', '.') }} (đ)@else  -  @endif @endif  <i class="{{ $c_hsk[$term]}}" style=" color: <?php echo $hsk_color; ?>;"></i></a></td>
                    <td data-value="{{$new_p[$term]->p_gu}}" alt=""> <a class="link-price" href="{{$product->guardian}}">@if(is_numeric($new_p[$term]->p_gu )) @if($new_p[$term]->p_gu  > 0){{ number_format($new_p[$term]->p_gu , 0, ',', '.') }} (đ)@else  -  @endif @endif  <i class="{{ $c_gu[$term]}}" style=" color: <?php echo $gu_color; ?>;"></i></a></td>
                    <td data-value="{{$new_p[$term]->p_tgs}}" alt=""> <a class="link-price" href="{{$product->thegioiskinfood}}">@if(is_numeric($new_p[$term]->p_tgs )) @if($new_p[$term]->p_tgs  > 0){{ number_format($new_p[$term]->p_tgs , 0, ',', '.') }} (đ)@else  -  @endif @endif <i class="{{ $c_tgk[$term]}}" style=" color: <?php echo $tgk_color; ?>;"></i> </a></td>
                    <td data-value="{{$new_p[$term]->p_lt}}" alt=""> <a class="link-price" href="{{$product->lamthao}}">@if(is_numeric($new_p[$term]->p_lt )) @if($new_p[$term]->p_lt  > 0){{ number_format($new_p[$term]->p_lt , 0, ',', '.') }} (đ)@else  -  @endif @endif  <i class="{{ $c_tl[$term]}}" style=" color: <?php echo $tl_color; ?>;"></i> </a></td>
                    
                    <td>
                    <form action="{{ route('product.delete', $product->id) }}" method="POST">
                    @csrf<button type="submit" class="btn btn-danger" onclick="checkAgain()">Xóa SP</button></form>
                    <form action="{{ route('products.detail', $product->id) }}" method="get">
                    @csrf
                    <button type="submit" class="btn btn-secondary" >Lịch Sử</button>
                    </form></td>  
                </tr>
                <?php $last_up_date=$new_p[$term]->created_at;
                 $term++; ?>
            @endforeach        
        </tbody>
			</table>
		</section>
	</main>
	<footer class="footer">
    <?php $dateTime = new DateTime($last_up_date);

$formattedDate = $dateTime->format('H:i:s   d-m-Y');?>
  <p>Cập nhật lần cuối: {{$formattedDate}}</p>
 <p> Dự Án Mã Nguồn Mở <a href='https://github.com/LeMinhQuoc/ab_check_price'> GitHub </a></p>
		<p>Love you! </p>
	</footer>
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script>
  document.querySelectorAll('tr').forEach(row => {
  const td = Array.from(row.querySelectorAll('td[data-value]'));

  const values = td.map(cell => Number(cell.dataset.value));

  const min = Math.min(...values), max = Math.max(...values);

  td.forEach(cell => {
    const value = Number(cell.dataset.value);

    if (value === min) {
      cell.style.color = 'red';
      
    } else if (value === max) {
      cell.style.color = 'blue';
    }
  });
});
</script>
</html>
