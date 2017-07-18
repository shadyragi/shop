<?php
extract($otherdata);


  

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../public/css/loginstyle.css?version=50">
  

</head>
<body>
       <nav>
           <ul>
           	<li class="homepage"><a href="http://localhost/shop/public/home">Shop</a></li>
         

            
           </ul>

      </nav>
        <form name="loginform" action="http://localhost/shop/public/login" method="POST"">
         <div class="logincontainer">
         	     <h3 class="header"> Sign In</h3>
         	     <h4>Email:</h4>
               <span  id="errmsgemail"><?php echo isset($email) ? $email : ''; ?></span>
         	     <input type="email" name="email" placeholder="Email">
         	     <h4>Password:</h4>
               <span id="errmsgpwd"><?php echo isset($password) ? $password : ''; ?></span>
         	     <input type="password" name="password" placeholder="Password">
               <span id="loginerr"><?php echo isset($loginerror) ? $loginerror : ''; ?></span>
         	     <input type="submit" name="submit" value="Login">
         	     <span> OR <a href="http://localhost/shop/public/signup" class="signup"> Signup</a></span>
               <br>
               <div class="persistent">
               <span class="persistent">Remember Me   <input type="checkbox" name="persistent"></span>
             
               </div>
               
         	   
         </div>
         </form>
</body>
</html>