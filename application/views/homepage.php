<?php
extract($otherdata);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../public/css/homepage.css?version=150">
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
      <div class="sidebar">
      <div class="categories">

      	    <h2>Categories</h2>
            
      	    <a href="categ.php?categ=sport">Sport</a>
      	    <hr>
      	    <a href="categ.php?categ=tshirt">T-shirts</a>
      	    <hr>
      	    <a href="categ.php?categ=technology">Technology</a>
      	    <hr>
      	    <a href="categ.php?categ=cameras">Cameras</a>
      	    <hr>
      	    <a href="categ.php?categ=jacket">Jackets</a>

      </div>
          <div class="cart">
              <h2> SEARCH </h2>     
              <form action="http://localhost/shop/public/search" method="POST">
              <input type="text" name="search" placeholder="type your search">
              <input type="submit" name="submit" value="search">  
              </form>
        </div>
        <div></div>>
         
       </div>
      <div class="container">
      <h1>Best Seller</h1>
       <?php
         

        $counter = 0;
        foreach($data['bestseller'] as $key => $product)
        {
          if($counter == 4)
          {
            break;
          }
        ?>
        <figure>
                <img src='<?php echo $product->image; ?>'>
                <a href='details/<?php echo $product->id; ?>'> <?php echo $product->title; ?> </a>
                <span class = 'price'> Price:  $<?php echo $product->price; ?> </span>
        </figure>
        <?php
        ++$counter;
         }

         ?>



          <h1 class="margintophigh">Offers</h1>
             <?php
            $counter = 0;

        foreach($data['offers'] as $key => $product)
        {
          if($counter == 4)
          { break; }
        ?>
        <figure>

                <img src='<?php echo $product->image; ?>'>
                <a href="details/<?php echo $product->id; ?>"> <?php echo $product->title; ?> </a>
                <span class = 'price'> Price:  $<?php echo $product->price ?> </span>
        </figure>
        <?php
         ++$counter;
          }
        ?>
        
         <h1 class="margintophigh">New Arrivals</h1>
             <?php
            $counter = 0;

        foreach($data['latest'] as $key => $product)
        {
          if($counter == 4)
          { break; }
        ?>
        <figure>
                <img src='<?php echo $product->image; ?>'>
                <a href="details/<?php echo $product->id; ?>"> <?php echo $product->title; ?> </a>
                <span class = 'price'> Price:  $<?php echo $product->price ?> </span>
        </figure>
        <?php
         ++$counter;
          }
        ?>
        </div>
       
       
      
       
     
</body>
</html>