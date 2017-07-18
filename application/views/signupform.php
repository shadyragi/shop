<?php
$msg = ' ';

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../public/css/signupstyle.css">


  </script>
</head>
<body>
        <nav>
           <ul>
           	<li class="homepage"><a href="http://localhost/shop/public/home">Shop</a></li>

            
           </ul>

      </nav>
      <form name="signupform" action="http://localhost/shop/public/signup" method="POST">
         <div class="logincontainer">
         	     <h3 class="header"> Sign Up</h3>
         	     <h4>Email:</h4>
               <span id="errmsgemail"><?php echo isset($data['email']) ? $data['email'] : '' ?></span>

         	     <input type="email" name="email" placeholder="Email">
         	     <h4>Username</h4>
               <span id="errmsgusername"><?php echo isset($data['username']) ? $data['username'] :'' ?></span>
         	     <input type="text" name="username" placeholder="Username">
         	     <h4>Password:</h4>
               <span id="errmsgpwd"><?php echo  isset($data['password']) ? $data['password'] : '' ?></span>
         	     <input type="password" name="password" placeholder="Password">
               <span id="signuperrmsg"><?php echo $msg; ?></span>
         	     <input type="submit" name="submit" value="Signup">
         	   
         	   
         </div>
         </form>
</body>
</html>>