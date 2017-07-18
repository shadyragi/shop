<?php




?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../public/css/searchstyle.css?version=1">
</head>
<body>
      <nav>
           <ul>
           	<li class="homepage"><a href="http://localhost/shop/public/home">ECOMMERCE</a></li>
           	
            
           	<li class="cart"> <a href="http://localhost/shop/public/cart"> Cart </a> </li>
            
           </ul>

      </nav>

      <h1>You Searched For "<?php echo $otherdata; ?>"</h1>
      <hr>
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
        <div> </div>
        </div>
      <div class="container">
    
       <?php
         

        $counter = 0;
        if(!empty($data))
        {
        foreach($data as $key => $product)
        {
          ?>
        <figure>
                <img src='<?php echo $product->image; ?>'>
                <a href='details/<?php echo $product->id; ?>'> <?php echo $product->title; ?> </a>
                <span class = 'price'> Price:  $<?php echo $product->price; ?> </span>
        </figure>
        <?php
        ++$counter;
         }
     }
     	else {
         ?>
         
         <h2>There is no records</h2>
         <?php } ?>
         </div>

      </body>
      </html>
  