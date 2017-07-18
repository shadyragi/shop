<?php


extract($otherdata);   

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../public/css/wishliststyle.css?version=100">

</head>
<body>
       <nav>
           <ul>
           	<li class="homepage"><a href="http://localhost/shop/public/home">Shop</a></li>
<div class="items">
           <?php if($loggedin) { ?>
            <li class="cart"> <a href="http://localhost/shop/public/logout"> Logout </a> </li>
          <?php } else { ?>
            <li class="cart"> <a href="http://localhost/shop/public/login"> Login </a> </li>
            <?php } ?>
              <li class="cart"> <a href="http://localhost/shop/public/cart"> Cart </a> </li>
                <li class="cart"> <a href="http://localhost/shop/public/wishlist"> Wishlist </a> </li>
                  <li class="cart"> <a href="http://localhost/shop/public/notifications"> Notifications </a> </li>
                  <li class="cart"> <a href="http://localhost/shop/public/history"> History </a> </li>
                  </div>
            
           </ul>

      </nav>
          <h1>WishList</h1>
        
          <div class="cart">
      <table class="cart">
       	    <tr>
       	    	 <th class="main">Product Name</th>
       	    	 <th>Price</th>
       	    	 <th>QTY</th>
       	    </tr>
       	    
                <?php
               
               
                 foreach($data as $key => $cartitem)
                 {

                 

                ?>
                <tr>
                      <td > <?php echo $cartitem->product_name; ?> </td>
                      <td> $<span id='price'><?php echo $cartitem->price; ?></span> </td>
                      <form action="http://localhost/shop/public/editwishlist" method="POST">
                      <td> <input name="qty" id="<?php echo $cartitem->prodcut_id; ?>"  type='number' value="<?php echo $cartitem->qty;  ?>">  </td>
                      <input type="hidden" name="id" value="<?php echo $cartitem->id ?>">
                      <td> <button name="addtocart" class="addtocart">add to cart</button> </td>
                      <td> <button name="delete" class="delete">Delete</button> </td>
                      </form>

                </tr>
                <?php
                 }
                ?>
       	  


       </table>
       <button class="save" id="savechanges"><a href='http://localhost/shop/public/cart'>Go To Cart </a></button>
     
        
</body>
</html>