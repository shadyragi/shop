<?php
$msg = ' ';

if(isset($otherdata))
{
  extract($otherdata);
}
  

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../../public/css/loginstyle.css?version=10">
  

</head>
<body>
       <nav>
           <ul>
           	<li class="homepage"><a href="http://localhost/shop/public/home">ECOMMERCE</a></li>
         

           	<li class="cart"> <a href="http://localhost/shop/public/cart"> Cart </a> </li>
            
           </ul>

      </nav>
        <form name="loginform" action="http://localhost/shop/public/admin/login" method="POST"">
         <div class="logincontainer">
         	     <h3 class="header"> Sign In</h3>
         	     <h4>UserName:</h4>
               <span  id="errmsgemail"><?php echo isset($username) ? $username :''; ?></span>
         	     <input type="text" name="username" placeholder="UserName">
         	     <h4>Password:</h4>
                <span  id="errmsgemail"><?php echo isset($pwd) ? $pwd :''; ?></span>
         	     <input type="password" name="pwd" placeholder="Password">
               <span id="loginerr"><?php echo isset($login) ? $login : ''; ?></span>
         	     <input type="submit" name="submit" value="Login">
         	     
         	   
         </div>
         </form>
</body>
</html>