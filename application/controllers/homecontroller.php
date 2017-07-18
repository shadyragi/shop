<?php
class homecontroller extends controller
{
	public function test()
	{
		echo "hi there";
	}
	public function getproducts()
	{
	
		if(isset($_COOKIE['token']))
		{
			$token = new token;
			$token->token = $_COOKIE['token'];
			$user_id      = $token->getId();
			$data  = $token->table("token")->where("user_id", "=", $user_id)->get();
			
			if($data)
			{
				$token = $token->makeObject($data);
				if($token->used > 1)
				{
					$token->token = $token->generatetoken();
					$token->used = 0;
						setcookie("token", $token->token, time() + 60 * 60 * 7);
				}
				else
				{
				++$token->used;	
				}
				$token->save();
				$_SESSION['user'] = (new users)->find($token->user_id)->id;
			}
			

		}
		$product  = new product();
		$products["bestseller"] = $product->makeObject($product->table("product")->orderBy("sold", "desc")->take(4)->getAll());
		$products['offers'] = $product->makeObject($product->table("product")->where("offers", "=", "yes")->take(4)->getAll());
		$products['latest'] = $product->makeObject($product->table("product")->orderBy("dte", "desc")->take(4)->getAll());
		
		$otherdata['loggedin'] = isset($_SESSION['user']) ? $_SESSION['user'] : false;
	

		$this->view->render("homepage.php", $products, $otherdata);




		//die();
	}
	private function getRandomProducts($data)
	{
		$randomkeys = [];
		$products = [];

		$counter = 0;
		while(1)
		{
			if($counter == 4)
			{
				break;
			}
			$key = array_rand($data);

			if(!isset($randomkeys[$key]))
		{
			$randomkeys[$key] = $key;
			$products[] = $data[$key];
			++$counter;
		}

		}
		return $products;
	}
}

?>