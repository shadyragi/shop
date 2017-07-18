<?php

class cartcontroller extends controller
{
	public function getcartproducts()
	{
		
		if(isset($_SESSION['user']))
		{

			$user = (new users)->find($_SESSION['user']);

			$products = $user->hasMany("cart", "user_id");
			$otherdata['loggedin'] = isset($_SESSION['user']) ? $_SESSION['user'] : false;
			return $this->view->render("cart.php", $products, $otherdata);
		}
		else
		{
			header("Location: http://localhost/shop/public/login");
		}
	}
	public function editcart()
	{
		$id = $_POST['id'];

		$cartitem = (new cart)->find($id);
		
		$product  = (new product)->find($cartitem->product_id);
		if(isset($_POST['update']))
		{
		$oldqty = $cartitem->qty;
		$cartitem->qty = $_POST['qty'];
		$mainqty       = $cartitem->qty - $oldqty;
		if($product->stock >= $mainqty)
	{
			
		if($cartitem->update())
		{
			header("Location: http://localhost/shop/public/cart");
		}
		else
		{
			die("error in updateing the record");
		}
	}
	else
	{
		die("there is no sufficent quantity for your request");
	}
}
	else
	{
		if($cartitem->delete())
		{
			header("Location: http://localhost/shop/public/cart");
		}
		else
		{
			die("error in deletion");
		}
	}
	}

}

?>