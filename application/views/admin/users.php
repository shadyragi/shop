<?php
extract($otherdata);


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../../../public/css/adminproducts.css?version=100">

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
          <h1>Users</h1>
          <?php
          if(isset($notfound))
          {
          	echo "<h1> $notfound; </h1>";
          	die();

          }
          ?>
          <a href="http://localhost/shop/public/admin/adduser"><button class="add">Add User</button></a>
          
        
          <div class="cart">
          <span class="sort">SortBy</span>
          <form method="POST" action="http://localhost/shop/public/admin/users/1">
          <select name="sortoption">
          <?php
          if(isset($sortoption)) 
          {
           ?>
          
          <option value="<?php echo $sortoption; ?>"><?php echo $sortoption; ?></option>
          <?php
        }
          ?>
          <option value="username">username</option>
          <option value="email">email</option>
          <option value="id" first>id</option>

          </select>
          <input type="text" name="search" placeholder="Type Your search" value="<?php echo isset($search) ? $search : ''?>">
          <button class="go"> Go </button>
          </form>
      <table class="cart">
       	    <tr>
       	    	<th>id</th>
       	    	 <th >UserName</th>
       	    	 <th>Email</th>
       	    	 <th>Pwd</th>
       	    	
       	    </tr>
       	    
                <?php
               
               
                 foreach($data as $key => $user)
                 {

	                 

                ?>
                <tr>
                	<td> <?php echo $user->id; ?></td>
                      <td > <?php echo $user->username; ?> </td>
                      <td> <span id='price'><?php echo $user->email; ?></span> </td>
                      <form action="http://localhost/shop/public/admin/deleteuser/<?php echo $user->id; ?>" method="POST">
                      <td> <?php echo $user->pwd; ?>  </td>
                      
                      
                     
                      <td> <button name="delete" class="delete">Delete</button> </td>
                      </form>
                       <td> <button name="edit" class="addtocart"><a href="http://localhost/shop/public/admin/edituser/<?php echo $user->id; ?>">Edit</a></button> </td>

                </tr>
              
                 
                <?php
            }
            ?>
                
       	  


       </table>
       <div class="buttons">
         <?php
                 
                 if(isset($Next))
                 {
                 	?>
                  <form action="http://localhost/shop/public/admin/users/<?php echo $Next; ?>" method="POST">
                 <a class="paginate" id="1" href=""><button class="save" id="savechanges">Next</button></a>
                 <input type="hidden" name="sortoption" value="<?php echo $sortoption; ?>">
                 <input type="hidden" name="search" value="<?php echo isset($search) ?  $search : '' ?>">
                 </form>
                 <?php
                 }
                 if(isset($Previous))
                 {
                 	?>
                  <form action="http://localhost/shop/public/admin/users/<?php echo $Previous; ?>" method="POST">
                 	<a class="paginate" id="2" href="http://localhost/shop/public/admin/users/<?php echo $Previous; ?>"><button class="save" id="savechanges">Previous</button></a>
                  <input type="hidden" name="sortoption" value="<?php echo $sortoption; ?>">
                 <?php
                 }
                 ?>
                 </div>
       	
    
     
        
</body>
</html>