<?php

   if(isset($_POST['productid']))
   {
      session_start();
      require 'dbconnector.php';
      $userid = $_SESSION['userid'];
      $productid = $_POST['productid'];
      $price = $_POST['price'];
      $qty = $_POST['qty'];
      $query = mysqli_query($dbconnector, "UPDATE product SET stock = stock - '$qty', sold = sold + 1 WHERE id = '$productid'");
      $result = mysqli_query($dbconnector, "INSERT INTO cart(user_id, product_id, qty, price ) VALUES('$userid', '$productid', '$qty', '$price')");
       
      echo "added";
   }
 

?>