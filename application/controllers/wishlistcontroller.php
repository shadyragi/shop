<?php
error_reporting(0);

class wishlistcontroller extends controller
{
	
	public function getwishlistproducts()
	{
		if(isset($_SESSION['user']))
		{	
				$user = (new users)->find($_SESSION['user']);
				$products = $user->hasMany("wishlist", "user_id");
				$otherdata['loggedin'] = isset($_SESSION['user']) ? $_SESSION['user'] : '';
				return $this->view->render("wishlist.php", $products, $otherdata);
		}
		else
		{
			header("Location: http://localhost/shop/public/login");
		}
	}
	public function editwishlist()
	{
		$id = $_POST['id'];
		$qty = $_POST['qty'];
		$values = [];
		$user = (new users)->find($_SESSION['user']);
		$wishlistitem = (new wishlist)->find($id);
		
		$product  = (new product)->find($wishlistitem->product_id);
	
		foreach ($wishlistitem as $key => $value) {
			# code...
			if($key != "id")
		{
				$values[$key] = $value;
		}
		}
		if(isset($_POST['addtocart']))
		{
			
			if($cart = $user->hasProduct("cart", $wishlistitem->product_id))
			{
				
				$cart->qty = $cart->qty + $qty;
				if($product->stock >= $cart->qty)
				{
				if($cart->save())
				{
					$wishlistitem->delete();
					header("Location:http://localhost/shop/public/wishlist");
				}
				}
				else
				{
					die("there is no stock available");
				}

			}
			else
			{
				$values['qty'] = $qty;
				if($product->stock >= $values['qty'])
				{
				$cart = new cart();
				$cart->save($values);
				$wishlistitem->delete();
				header("Location: http://localhost/shop/public/wishlist");
				}
				else
				{
					die("there is no stock available");
				}
			}
			
		}
		else
		{
			if($wishlistitem->delete())
			{
				header("Location: http://localhost/shop/public/wishlist");
			}
			else
			{
				die("Error in deletion");
			}
		}
	}
}

?>