<?php

 extract($otherdata);
 
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="http://localhost/shop/public/css/productstyle.css?version=100">
 
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
        
       <img class="productimg" src="<?php echo $data->image;?>">
       
       <div class="container">
       <h2> Product Details </h2>
       
         <div class="details">
               <div class="item">
         	   <h3 class="details"> NAME: </h3>
               <span class="details" style="padding-left:52px;"> <?php echo $data->title; ?></span>
               </div>
               
               <div class="item">
                <h3 class="details" > PRICE: </h3>
               <span class="details"  style="color:#208dc6; font-weight:bolder; padding-left:50px;">$<span id="price"><?php echo $data->price; ?></span></span>
               </div>
               <div class="item">
                 <h3 class="details">BRAND: </h3>
                 <span class="details" style="color:#208dc6; font-weight:bolder; padding-left:40px;"><?php echo $data->brand; ?></span>
               </div>
               <div class="item">
                <h3 class="details"> STOCK: </h3>
                <?php
                if($data->stock > 0)
                {


                ?>
                <span class="instock"> In stock </span>
                <?php
                 }
                 else 
                 {


                ?>
               <span class="outofstock"> Out of stock </span>
               <?php
               }
               ?>
               </div>
               
               <div class="item">
                <h3 class="details" > ID: </h3>
               <span class="details " id="productid" style="padding-left:99px;"> <?php echo $data->id; ?> </span>
               </div>
               
              
                <?php
                 if(users::isLoggedIn())
                 {


                ?>
              
                <form action="http://localhost/shop/public/addproduct" method="POST">
                <div class="item">
                <h3 class="details" > QUANTITY: </h3>
                  <span class="details"> <input name="qty" type="number" value="1" min="1" ></span>
                  </div>
               <div class="cartbtn">

                  <input type="hidden" name="id" value="<?php echo $data->id; ?>">
               	  <button class="addtocart" name="addtocart">     ADD TO CART    </button>
                  <button class="addtowishlist" name="addtowishlist"> ADD TO WISHLIST</button>
                    
               </div>

               </form>
               
               
               <?php
               }
               ?>
         </div>
         </div>
         <div class="desc">
               <h2> Description</h2>
               <div class="desccontent">
               <p class="content"> <?php echo $data->description; ?></p>
</div>
         </div>
<div class="related">
   <h2>Related Products</h2>
   <?php
      $relatedproducts = $data->getRelatedProducts();
     
      $counter = 0;
      
      foreach($relatedproducts as $key => $product)

      {


      
   ?>
      <figure>
                <img src="<?php echo $product->image; ?>">
                <a href="http://localhost/shop/public/details/<?php echo $product->id; ?>"> <?php echo $product->title; ?> </a>
                <span class = 'price'>Price: $<?php echo $product->price; ?> </span>
        </figure>
     <?php
     }
     ?>
       
</div>
  <br>
<div class="otheritems">
   <h2>Customers Who Purchased This Also Purchased</h2>
      <figure>
                <img src='http://www.placehold.it/200/300'>
                <a href='#'> Product 1 </a>
                <span class = 'price'> Price: $20 </span>
        </figure>
        <figure>
                <img src='http://www.placehold.it/200/300'>
                <a href='#'> Product 1 </a>
                <span class = 'price'> Price: $20 </span>
        </figure>
        <figure>
                <img src='http://www.placehold.it/200/300'>
                <a href='#'> Product 1 </a>
                <span class = 'price'> Price: $20 </span>
        </figure>
</div>

</body>
</html>