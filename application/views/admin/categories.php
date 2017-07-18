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
          <h1>Categories</h1>
          <?php
          if(isset($notfound))
          {
          	echo "<h1> $notfound; </h1>";
          	die();

          }
          ?>
          <a href="http://localhost/shop/public/admin/addcateg"><button class="add">Add Category</button></a>
          
        
          <div class="cart">
          <span class="sort">SortBy</span>
          <form method="POST" action="http://localhost/shop/public/admin/categories/1">
          <select name="sortoption">
          <?php
          if(isset($sortoption)) 
          {
           ?>
          
          <option value="<?php echo $sortoption; ?>"><?php echo $sortoption; ?></option>
          <?php
        }
          ?>
          <option value="category_name">name</option>
         
          <option value="id" >id</option>

          </select>
          <input type="text" name="search" placeholder="Type Your search" value="<?php echo isset($search) ? $search : ''?>">
          <button class="go"> Go </button>
          </form>
      <table class="cart">
       	    <tr>
       	    	<th>id</th>
       	    	 <th >Category_name</th>
       	    	 
       	    </tr>
       	    
                <?php
               
               
                 foreach($data as $key => $categ)
                 {

	                 

                ?>
                <tr>
                	<td> <?php echo $categ->id; ?></td>
                      <td > <?php echo $categ->category_name; ?> </td>
                     
                      <form action="http://localhost/shop/public/admin/deletecateg/<?php echo $categ->id; ?>" method="POST">
                  
                      
                      
                     
                      <td> <button name="delete" class="delete">Delete</button> </td>
                      </form>
                       <td> <button name="edit" class="addtocart"><a href="http://localhost/shop/public/admin/editcategory/<?php echo $user->id; ?>">Edit</a></button> </td>

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
                  <form action="http://localhost/shop/public/admin/categories/<?php echo $Next; ?>" method="POST">
                 <a class="paginate" id="1" href=""><button class="save" id="savechanges">Next</button></a>
                 <input type="hidden" name="sortoption" value="<?php echo $sortoption; ?>">
                 <input type="hidden" name="search" value="<?php echo isset($search) ?  $search : '' ?>">
                 </form>
                 <?php
                 }
                 if(isset($Previous))
                 {
                 	?>
                  <form action="http://localhost/shop/public/admin/categories/<?php echo $Previous; ?>" method="POST">
                 	<a class="paginate" id="2" href="http://localhost/shop/public/admin/categories/<?php echo $Previous; ?>"><button class="save" id="savechanges">Previous</button></a>
                  <input type="hidden" name="sortoption" value="<?php echo $sortoption; ?>">
                 <?php
                 }
                 ?>
                 </div>
       	
    
     
        
</body>
</html>