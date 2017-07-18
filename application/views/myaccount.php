<?php

?>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="  ../public/css/account.css?version=50">

</head>
<body>
       <nav>
           <ul>
           	<li class="homepage"><a href="http://localhost/shop/public/home">ECOMMERCE</a></li>

           	<li class="cart"> <a href="http://localhost/shop/public/cart"> Cart </a> </li>
            
           </ul>

      </nav>

          <h1>My Account</h1>
          <hr>
       		<div class="userdata">
          <form method="POST" action="http://localhost/shop/public/myaccount">
           <span class="error"><?php echo $otherdata['username']; ?></span>
          <input type="text" name="username" value="<?php echo $data->username; ?>">
        	
        
           
          <span class="error"><?php echo $otherdata['email']; ?></span>
          <input type="text" name="email" value="<?php echo $data->email; ?>">
     
     
         <span class="error"><?php echo  $otherdata['pwd']; ?></span>
          <input type="password" name="pwd" value="<?php echo $data->pwd ?>">
   
         <span class="error"><?php echo $otherdata['confirmpwd']; ?></span>
          <input type="password" name="confirmpwd" value="<?php echo $data->pwd; ?>">
            
          <input type="submit" name="submit" value="Save Changes">
          </form>
          </div>
         
</html>