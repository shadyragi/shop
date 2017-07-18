<?php
extract($otherdata);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
		<link rel="stylesheet" type="text/css" href="../../../public/css/editproduct.css?version=70">

</head>
<body>
       <nav>
           <ul>
           	<li class="homepage"><a href="http://localhost/shop/public/home">ECOMMERCE</a></li>

           	<li class="cart"> <a href="http://localhost/shop/public/cart"> Cart </a> </li>
            
           </ul>

      </nav>

      <div class="editproduct">
      	<table>
      			<form method="POST" action="http://localhost/shop/public/admin/editproduct/<?php echo $data->id;?>">
      			<tr>
      			<th>Title:</th>
      			<td><input type="text" name="title" value="<?php echo $data->title; ?>"></td>
      			</tr>
      			<tr>
      			<th>Price</th>

      			<td><input type="number" name="price" value="<?php echo $data->price; ?>"></td>
      			</tr>
      			<tr>
      			<th>Stock</th>
      			<td><input type="number" name="stock" value="<?php echo $data->stock; ?>"></td>
      			</tr>
      			<tr>
      			<th>Descrption</th>
      			<td>

      			<textarea name="description" rows="20" cols="50">
      				<?php echo $data->description; ?>
      			</textarea>

      			</td>
      			</tr>
      			<tr>
      			<th>Brand</th>
      			<td><input type="text" name="Brand" value="<?php echo $data->brand; ?>"></td>
      			</tr>
      			<tr>
      			<th>Category</th>
      			<td><input type="text" name="categ" value="<?php echo $data->categ; ?>"></td>
      			</tr>
      			<tr>
      			<th>New Offer</th>
      			<td><input type="number" name="new_price" value="<?php if($data->offers == "yes") echo $data->new_price; else echo 0; ?>">></td>
      			</tr>
      			 	<input type="hidden" name="_token" value="<?php echo $token; ?>">
      	</table>
      	<button class="save" id="savechanges">Save Changes</button>
      	</form>



      </div>

 </body>
</html>