<?php
@session_start();
class cartandwishlistcontroller
{
	
	public function addproduct()
	{

		
		if(isset($_POST['addtocart']))
		{
			
			$user = (new users)->find($_SESSION['user']);

			$product = (new product)->find($_POST['id']);
			if($product->stock >= $_POST['qty'])
			{	
						if($cart = $user->hasProduct("cart", $product->id))
						{
						
							$cart->qty = $cart->qty +  $_POST['qty'];
							if($cart->save())
							{
								header("Location: ".$_SERVER['HTTP_REFERER']);
							}
							else
							{
								die("error in adding the product");
							}
						}
						else
						{	
									$cart = new cart();
									$cart->user_id    = $_SESSION['user'];
									$cart->product_id = $product->id;
									$cart->category   = $product->categ;
									$cart->price       = $product->price;
									$cart->product_name = $product->title;
									$cart->qty          = $_POST['qty'];
									if($id = $cart->save())
									{
										header("Location: ". $_SERVER['HTTP_REFERER']);
									}
									else
									{
										die("error in adding the product");
									}
						}
					}
				else
				{
					die("quantity is too large for the product stock");
				}

		}
		elseif(isset($_POST['addtowishlist']))

		{
			$wishlist = new wishlist();
			$user     = (new users)->find($_SESSION['user']);
			$product = (new product)->find($_POST['id']);
			if(!$user->hasProduct("wishlist", $product->id))
			{	
							$wishlist->user_id    = $_SESSION['user'];
							$wishlist->product_id = $product->id;
							$wishlist->price       = $product->price;
							$wishlist->product_name = $product->title;
							$wishlist->qty          = $_POST['qty'];
							$wishlist->category     = $product->categ;
							
							if(!$wishlist->save())
							{
								die("error in adding the product");
							}
			}	
			header("Location: http://localhost/shop/public/details/" .$product->id);
		}
		
	}
}

?>