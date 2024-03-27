<!DOCTYPE html>
<html>
<head>
	<title>Price Comparison</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/add_pro.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
<style>
.link-price {
	text-decoration: none;
	color: gray;
}
.link-price:hover{
  text-decoration: none;
  color: black;
}
th {
    text-align: center;
}
.footer {
   position: fixed;
   bottom: 0;
   width: 100%;
   text-align: center;
}


body {
    background-color: #f0f0f0;
}

.styled-form {
    background-color: #333333;
    padding: 20px;
    color: #fff;
    width: 254px;
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
    body {
	font-family: Arial, sans-serif;
	margin: 0;
	padding: 0;
}

header {
	background-color: #333;
	color: #fff;
	padding: 1rem;
}

header h1 {
	margin: 0;
}

main {
	padding: 2rem;
}

section {
	margin-bottom: 2rem;
}

table {
	border-collapse: collapse;
	width: 100%;
}

th, td {
	border: 1px solid #ddd;
	padding: 0.5rem;
	text-align: left;
}

th {
	background-color: #f2f2f2;
	font-weight: bold;
}

tr:nth-child(even) {
	background-color: #f2f2f2;
}

img {
	height: 100px;
	width: 100px;
}

footer {
	background-color: #333;
	color: #fff;
	padding: 1rem;
	text-align: center;
}
a {
	text-decoration: none;
	color: black;
}
#popupForm {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        /* Style the form and position it in the center */
        #formContainer {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1001;
        }

        /* Style the form elements */
        #formContainer input,
        #formContainer textarea,
        #formContainer select,
        #formContainer button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 5px;
            font-size: 16px;
        }

        /* Add a transition for the popup animation */
        #popupForm {
            transition: opacity 0.3s ease-in-out;
        }

        /* Show the form when the "Show" button is clicked */
        #showPopup:focus {
            outline: none;
        }
        #showPopup:focus ~ #popupForm {
            display: block;
        }

        /* Hide the form when the form is submitted */
        #formContainer form {
            display: flex;
            flex-direction: column;
        }
        #formContainer form input[type="submit"]:focus {
            outline: none;
        }
        #formContainer form input[type="submit"]:active {
            opacity: 0.5;
        }
        #formContainer form input[type="submit"]:active ~ #popupForm {
            opacity: 0;
            transition: opacity 0s 0.3s ease-in-out;
        }



</style>
</head>

<body>
	<header>
		<h1>Price Comparison</h1>
	</header>
	<main>



<section>

<button id="showPopup">Show</button>

<div id="popupForm">
    <div id="formContainer">
        <form action="#">
            <input type="text" placeholder="Name" required>
            <input type="email" placeholder="Email" required>
            <textarea placeholder="Message" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>
</section>

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
  
	
</html>
