<?php
extract($otherdata);


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../../../public/css/adminproducts.css?version=200">

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
          <h1>Products</h1>
          <?php
          if(isset($notfound))
          {
          	echo "<h1> $notfound; </h1>";
          	die();

          }
          ?>
          <a href="http://localhost/shop/public/admin/addproduct"><button class="add">Add Product</button></a>
          
        
          <div class="cart">
          
          <form method="POST" action="http://localhost/shop/public/admin/products/1">
             <span class="sort">SortBy</span>
          <select name="sortoption">
          <?php
          if(isset($sortoption)) 
          {
           ?>
          
          <option value="<?php echo $sortoption; ?>"><?php echo $sortoption; ?></option>
          <?php
        }
          ?>
          <option value="price">Price</option>
          <option value="sold">Sold</option>
          <option value="title" first>Title</option>
          <option value="stock">Stock</option>
          <option value="dte">Date</option>
          </select>
          
          <span class="search">Search By</span>
          <select name="searchkey">
          <?php
           if(isset($searchkey)) 
          {
           ?>
          
          <option value="<?php echo $searchkey; ?>"><?php echo $searchkey; ?></option>
          <?php
        }
          ?>
            <option value="title">Title</option>
            <option value="price">Price </option>
            <option value="categ">category</option>
            <option value="brand">Brand</option>
            <option value="id">id</option>
            <option value="stock">Stock</option>
            <option value="sold">Sold</option>
          </select>
          <input type="search" name="search" placeholder="Type Your search" value="<?php echo isset($search) ? $search : ''?>">
          <button class="go"> Go </button>
          </form>
      <table class="cart">
       	    <tr>
       	    	<th>Image</th>
       	    	 <th >Name</th>
       	    	 <th>Price</th>
       	    	 <th>Stock</th>
       	    	 <th>sold</th>
       	    	 <th>Date</th>
       	    </tr>
       	    
                <?php
               
               
                 foreach($data as $key => $product)
                 {

	                 

                ?>
                <tr>
                	<td><img src="<?php echo $product->image; ?>"></td>
                      <td > <?php  echo $product->title; ?> </td>
                      <td> $<span id='price'><?php echo $product->price; ?></span> </td>
                     
                      <td> <?php echo $product->stock; ?>  </td>
                      <td> <?php echo $product->sold; ?></td>
                      <td> <?php echo $product->dte; ?></td>
                       <form action="http://localhost/shop/public/admin/deleteproduct/<?php echo $product->id; ?>" method="POST">
                      <input type="hidden" name="_token" value="<?php echo $token; ?>">
                     <td><input type="checkbox" name="checkbox"> </td>
                      <td> <button name="delete" class="delete">Delete</button> </td>
                      
                       
                       </form>
                       <td> <button name="edit" class="addtocart"><a href="http://localhost/shop/public/admin/editproduct/<?php echo $product->id; ?>">Edit</a></button> </td>
                       


                </tr>
              
                 
                <?php
            }
            ?>
                
       	  


       </table>
       <div class="buttons">
         <?php
                 
                 if(isset($Next))
                 {
                 	?>
                  <form action="http://localhost/shop/public/admin/products/<?php echo $Next; ?>" method="POST">
                 <a class="paginate" id="1" href=""><button class="save" id="savechanges">Next</button></a>
                 <input type="hidden" name="sortoption" value="<?php echo $sortoption; ?>">
                 <input type="hidden" name="searchkey" value="<?php  echo isset($searchkey) ? $searchkey : ''; ?>">
                 <input type="hidden" name="search" value="<?php echo isset($search) ?  $search : ''; ?>">
                 </form>
                 <?php
                 }
                 if(isset($Previous))
                 {
                 	?>
                  <form action="http://localhost/shop/public/admin/products/<?php echo $Previous; ?>" method="POST">
                 	<a class="paginate" id="2" href="http://localhost/shop/public/admin/products/<?php echo $Previous; ?>"><button class="save" id="savechanges">Previous</button></a>
                  <input type="hidden" name="sortoption" value="<?php echo $sortoption; ?>">
                   <input type="hidden" name="searchkey" value="<?php  echo isset($searchkey) ? $searchkey : ''; ?>">
                 <input type="hidden" name="search" value="<?php echo isset($search) ?  $search : '' ?>">
                 <?php
                 }
                 ?>
                 </div>
       	
    
     
        
</body>
</html>