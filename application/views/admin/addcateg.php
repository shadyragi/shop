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
		<link rel="stylesheet" type="text/css" href="../../public/css/addproduct.css?version=120">

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
      			<form method="POST" action="http://localhost/shop/public/admin/addcateg">
            <tr>
              <th></th>
              <td><span><?php echo isset($category_name) ? $category_name : ''; ?></span></td>
            </tr>
      			<tr>
      			<th>Category Name : </th>
      			<td><input type="text" name="category_name" placeholder="Type The Name"></td>
      			</tr>
      				</table>
             <input type="hidden" name="_token" value="<?php echo $token; ?>">
      	<button class="save" id="savechanges">Add Category</button>
      	</form>



      </div>

 </body>
</html>