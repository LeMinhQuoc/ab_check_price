<!DOCTYPE html>
<html>
<head>
	<title>Price Comparison</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/add_pro.css') }}">
    
</head>
<body>
	<header>
		<h1>Price Comparison</h1>
	</header>
	<main>
<section>
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
</section>
		<section>
			<label for="search">Search:</label>
			<input type="text" id="search" name="search">
			<button>Search</button>
		</section>
		<section>
			<table>
            <thead>
                <tr>
                <th>Barcode</th>
                <th>Product</th>
                <th>Brand</th>
                <th>AB</th>
                <th>Hasaki</th>
                <th>Guardian</th>
                <th>Thegioiskinfood</th>
                <th>Lamthao</th>
                </tr>
            </thead>
				<tbody>
                    {{ $term =0 }}
            @foreach($products as $product)
                <tr>
                    <td>{{$product->product_barcode}}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{$product->brand}}</td>
                    <td data-value="{{$new_p[$term]->p_ab}}">  @if(is_numeric($new_p[$term]->p_ab )) @if($new_p[$term]->p_ab  > 0){{ number_format($new_p[$term]->p_ab , 0, ',', '.') }} (đ)@else  -  @endif @endif   {{ $c_ab[$term]}}</td>
                    <td data-value="{{$new_p[$term]->p_hsk}}">@if(is_numeric($new_p[$term]->p_hsk )) @if($new_p[$term]->p_hsk  > 0){{ number_format($new_p[$term]->p_hsk , 0, ',', '.') }} (đ)@else  -  @endif @endif  </td>
                    <td data-value="{{$new_p[$term]->p_gu}}"> @if(is_numeric($new_p[$term]->p_gu )) @if($new_p[$term]->p_gu  > 0){{ number_format($new_p[$term]->p_gu , 0, ',', '.') }} (đ)@else  -  @endif @endif  </td>
                    <td data-value="{{$new_p[$term]->p_tgk}}"> @if(is_numeric($new_p[$term]->p_tgk )) @if($new_p[$term]->p_tgk  > 0){{ number_format($new_p[$term]->p_tgk , 0, ',', '.') }} (đ)@else  -  @endif @endif </td>
                    <td data-value="{{$new_p[$term]->p_lt}}"> @if(is_numeric($new_p[$term]->p_lt )) @if($new_p[$term]->p_lt  > 0){{ number_format($new_p[$term]->p_lt , 0, ',', '.') }} (đ)@else  -  @endif @endif  </td>
                </tr>
                
                {{ $term++ }}
            @endforeach
        </tbody>
			</table>
		</section>
	</main>
	<footer>
		<p>Love you!</p>
	</footer>
</body>
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
</script>
</html>
