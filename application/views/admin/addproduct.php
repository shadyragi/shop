<?php

if(isset($otherdata))
{
  extract($otherdata);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
		<link rel="stylesheet" type="text/css" href="../../public/css/addproduct.css?version=150">

</head>
<body>
       <nav>
           <ul>
           	<li class="homepage"><a href="http://localhost/shop/public/home">ECOMMERCE</a></li>

  <div class="items">
            <li class="cart"> <a href="http://localhost/shop/public/admin/logout"> Logout </a> </li>
              <li class="cart"> <a href="http://localhost/shop/public/admin/products"> Products </a> </li>
                <li class="cart"> <a href="http://localhost/shop/public/admin/users"> Users </a> </li>
                  <li class="cart"> <a href="http://localhost/shop/public/admin/categories"> Categories </a> </li>
                  </div>            
           </ul>

      </nav>

      <div class="editproduct">
      	<table>
      			<form method="POST" action="http://localhost/shop/public/admin/addproduct" enctype="multipart/form-data">
            <tr>
              <th>Image: </th>
              <td><input type="file" name="image"></td>
            </tr>>
            <tr>
            <th></th>
              <td><span><?php echo isset($title) ? $title : ''; ?></span></td>
            </tr>
      			<tr>
      			<th>Title: </th>
           
      			<td><input type="text" name="title" placeholder="Type The Title"></td>
           
      			</tr>
            <tr>
            <th></th>
              <td><span><?php echo isset($price) ? $price : ''; ?></span></td>
            </tr>
      			<tr>
      			<th>Price: </th>

      			<td><input type="number" name="price" placeholder="Type The Price" min="1" ></td>
      			</tr>
            <tr>
            <th></th>
              <td><span><?php echo isset($stock) ? $stock : ''; ?></span></td>
            </tr>
      			<tr>
      			<th>Stock: </th>
      			<td><input type="number" name="stock" placeholder="Type The Number Of Stock" min="1" ></td>
      			</tr>
            <tr>
            <th></th>
              <td><span><?php echo isset($description) ? $description : ''; ?></span></td>
            </tr>
      			<tr>
      			<th>Descrption: </th>
      			<td>

      			<textarea name="description" rows="20" cols="50" placeholder="Type The Descrption"></textarea>

      			</td>
      			</tr>
            <tr>
            <th></th>
              <td><span><?php echo isset($brand) ? $brand : ''; ?></span></td>
            </tr>
      			<tr>
      			<th>Brand: </th>
      			<td><input type="text" name="brand" placeholder="Type The Brand Name" ></td>
      			</tr>
            <tr>
            <th></th>
              <td><span><?php echo isset($categ) ? $categ : ''; ?></span></td>
            </tr>
      			<tr>
      			<th>Category: </th>
      			<td><input type="text" name="categ" placeholder="Type The Category Name" ></td>
      			</tr>
            
      			<tr>
      			<th>New Offer: </th>
      			<td><input type="number" name="new_price" placeholder="Type The Offer Price" min="1"></td>
      			</tr>
             <tr>
            <th></th>
              <td><span><?php echo isset($date) ? $date : ''; ?></span></td>
            </tr>
             <tr>
            <th></th>
              <td><span><?php echo isset($time) ? $time : ''; ?></span></td>
            </tr>
            <tr>
              <th>Offer Until: </th>
              <td><span class="offer"> Date: </span>: <input type="date" name="date"> <span class="offer"> Time: </span> <input type="time" name="time"></td>
            </tr>
            <input type="hidden" name="_token" value="<?php echo $token ?>">
      			 	
      	</table>
      	<button class="save" id="savechanges">Add Product</button>
      	</form>



      </div>

 </body>
</html>