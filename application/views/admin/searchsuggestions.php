<?php



?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../../../public/css/searchterms.css?version=200">

</head>
<body>
       <nav>
           <ul>
           	<li class="homepage"><a href="http://localhost/shop/public/home">ECOMMERCE</a></li>

           	<li class="cart"> <a href="http://localhost/shop/public/cart"> Cart </a> </li>
            
           </ul>

      </nav>
          <h1>Products</h1>
          
        
          <a href="http://localhost/shop/public/admin/addproduct"><button class="add">Add Product</button></a>
          
        
          <div class="cart">
          
          <form method="POST" action="http://localhost/shop/public/admin/products/1">
             <span class="sort">SortBy</span>
          <select name="sortoption">
        
          <option value="price">Price</option>
          <option value="sold">Sold</option>
          <option value="title" first>Title</option>
          <option value="stock">Stock</option>
          <option value="dte">Date</option>
          </select>
          
          <span class="search">Search By</span>
          <select name="searchkey">
        
      
        
            <option value="title">Title</option>
            <option value="price">Price </option>
            <option value="categ">category</option>
            <option value="brand">Brand</option>
            <option value="id">id</option>
            <option value="stock">Stock</option>
            <option value="sold">Sold</option>
          </select>
          <input type="search" name="search" placeholder="Type Your search" value="">
          <button class="go"> Go </button>
          </form>
          <h1><?php echo  isset($data['notfound']) ? die($data['notfound']) : ''; ?></h1>>
          <div class="searchterms">
          <span class="searchterms">Did You Mean: </span>
          <hr>
          <?php
          foreach ($data as $key => $product) {
            # code...
            
            ?>
            <a class="term" href="http://localhost/shop/public/admin/find/<?php echo $product->id; ?>"><?php echo $product->title; ?></a>
            <hr>
            <?php

          }

          ?>
          </div>
          </div>
          </body>
          </html>
