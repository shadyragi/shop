<?php

extract($otherdata);
   

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../public/css/cartstyle.css?version=50">
  <script type="text/javascript" src='jquery.min.js'></script>
  
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
          <h1>Cart</h1>
        
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
                      <td > <?php echo $cartitem->productName(); ?> </td>
                      <td> $<span id='price'><?php echo $cartitem->price; ?></span> </td>
                      <form action="http://localhost/shop/public/editcart" method="POST">
                      <td> <input name="qty" id="<?php echo $cartitem->prodcut_id; ?>"  type='number' value="<?php echo $cartitem->qty;  ?>">
                        </td>
                        <input type="hidden" name="id" value="<?php echo $cartitem->id; ?>" >
                        <td> <button name="update" class="update">update</button></td>
                        
                        <td><button name="delete"  class="delete">delete</button></td>
                        </form>
                </tr>
                <?php
                 }
                ?>
       	  


       </table>
       <button class="save" id="savechanges">Save Changes</button>
       </div>
       <div class="total">
       <table class="total">
       	   <tr>
       	   	   <th>SubTotal:</th>
       	   	   <td id="subtotal"></td>

       	   </tr>
       	   <tr>
       	   	   <th>Shipping cost:</th>
       	   	   <td>$10</td>
       	   </tr>
       	   <tr>
       	   	<th>Total:</th>
       	    <td id="total"></td>
       	   </tr>

       </table>
       <button class="checkout">Check Out</button>
       </div>
        
</body>
</html>