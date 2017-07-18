<?php
   if(isset($_POST['productid']))
   {
   	require 'dbconnector.php';
   	session_start();
   	$pid = $_POST['productid'];
   	$uid = $_SESSION['userid'];
   	$result = mysqli_query($dbconnector, "SELECT * FROM cart WHERE user_id = '$uid' AND product_id = '$pid'");
   	if(mysqli_affected_rows($dbconnector) > 0)
   	{
   		echo "found";
   	}
   	else 
   	{
   		echo "not found";
   	}
   }
?>