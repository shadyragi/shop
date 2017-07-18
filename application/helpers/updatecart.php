<?php
    if(isset($_POST['pid']) && isset($_POST['qty']))
    {
    	require 'dbconnector.php';
    	$remainqty = 0;
    	$pid = $_POST['pid'];
    	$qty = $_POST['qty'];
    	$query = mysqli_query($dbconnector, "SELECT qty FROM cart WHERE product_id = '$pid'");
        $oldqty = mysqli_fetch_assoc($query);

        if($oldqty['qty'] > $qty)
        {
            $remainqty = $oldqty['qty'] - $qty;
        	$query2 = mysqli_query($dbconnector, "UPDATE product SET stock = stock + '$remainqty' WHERE id = '$pid'");
            if($qty == 0)
            {
                $deletequery = mysqli_query($dbconnector, "DELETE FROM cart WHERE product_id = '$pid'");
            }
        }
        else if($oldqty['qty'] < $qty) {
           $remainqty = $qty - $oldqty['qty'];
           $query3 = mysqli_query($dbconnector, "UPDATE product SET stock = stock - '$remainqty' WHERE id = '$pid'");
        }

        $result = mysqli_query($dbconnector, "UPDATE cart SET qty = '$qty' WHERE product_id = '$pid'");
        if(!empty(mysqli_error($dbconnector)))
        {
            echo mysqli_error($dbconnector);
        }
        else {
             
             echo "updated";
        }
    }
?>