<?php

extract($otherdata);

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="  ../public/css/history.css?version=100">

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
            <?php } ?>              <li class="cart"> <a href="http://localhost/shop/public/cart"> Cart </a> </li>
                <li class="cart"> <a href="http://localhost/shop/public/wishlist"> Wishlist </a> </li>
                  <li class="cart"> <a href="http://localhost/shop/public/notifications"> Notifications </a> </li>
                  <li class="cart"> <a href="http://localhost/shop/public/history"> History </a> </li>
                  </div>            
           </ul>

      </nav>
          <h1>History</h1>
          <hr>
          <span class="message"><?php echo isset($message) ? $message : "" ?></span>>
          <?php
          foreach ($data as $key => $history) {
            # code...
            $product = (new product)->find($history->product_id);
          
          ?>
          <div class="notifications">
          
          <img src="<?php echo $product->image; ?>">
          <div class="content">
               <span class="date"><?php echo $history->dte; ?></span>
             <p>You Have <?php echo $history->type; ?> <strong><?php echo $product->title; ?></strong> To Your Cart </p>
              
                
                <a href="http://localhost/shop/public/details/<?php echo $product->id; ?>"><button name="addtocart"> Go To Product</button> </a>
              
               <form  action="http://localhost/shop/public/deletehistory/<?php echo $history->id; ?>" method="POST">
               <input type="hidden" name="id" value="<?php echo $notification->id; ?>">
               <button class="notification" name="deletenotification"> Delete</button>
               </form>
             </div>
           

              <hr>
          </div>
            <?php
           }

             ?>
     
        
          
     
        
</body>
</html>