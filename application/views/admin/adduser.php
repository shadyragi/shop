<?php

if(isset($otherdata))
{
  extract($data);
  extract($otherdata);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
		<link rel="stylesheet" type="text/css" href="../../public/css/addproduct.css?version=110">

</head>
<body>
       <nav>
           <ul>
           	<li class="homepage"><a href="http://localhost/shop/public/home">ECOMMERCE</a></li>

<div class="items">
            <li class="cart"> <a href="http://localhost/shop/public/admin/logout"> Logout </a> </li>
              <li class="cart"> <a href="http://localhost/shop/public/admin/products"> Products </a> </li>
                <li class="cart"> <a href="http://localhost/shop/public/admin/users"> Users </a> </li>
                  <li class="cart"> <a href="http://localhost/shop/public/admin/categories"> Categories </a> </li>
                  </div>             
           </ul>

      </nav>

      <div class="editproduct">
      	<table>
      			<form method="POST" action="http://localhost/shop/public/admin/adduser">
              <tr>
              <th></th>
              <td><span><?php echo isset($errors['username']) ? $errors['username'] : '';  ?></span></td>
            </tr>
      			<tr>
      			<th>UserName: </th>
      			<td><input type="text" name="username" placeholder="Type The UserName" value="<?php echo isset($username) ? $username :  '';?>"></td>
      			</tr>
      			
      	
      			 <tr>
              <th></th>
              <td><span><?php echo isset($errors['email']) ? $errors['email'] : '';  ?></span></td>
            </tr>
      		
      			<tr>
      			<th>Email: </th>
      			<td><input type="email" name="email" placeholder="Type The Email" value="<?php echo isset($email) ? $email : ''; ?>"></td>
      			</tr>
             <tr>
              <th></th>
              <td><span><?php echo isset($errors['pwd']) ? $errors['pwd'] : '';  ?></span></td>
            </tr>
      			<tr>
      			<th>Password: </th>
      			<td><input type="Password" name="pwd" placeholder="Type The Password" value="<?php echo isset($pwd) ? $pwd : ''; ?>" ></td>
      			</tr>
             <tr>
              <th></th>
              <td><span><?php echo isset($errors['confirmpwd']) ? $errors['confirmpwd'] : '';  ?></span></td>
            </tr>
            <tr>
            <th>Confirm Password: </th>
            <td><input type="Password" name="confirmpwd" placeholder="Confirm The Password" value="<?php echo isset($confirmpwd) ? $confirmpwd : ''; ?>" ></td>
            </tr>
             <input type="hidden" name="_token" value="<?php echo $token; ?>">
      		
      			 	
      	</table>
      	<button class="save" id="savechanges">Add Usern</button>
      	</form>



      </div>

 </body>
</html>