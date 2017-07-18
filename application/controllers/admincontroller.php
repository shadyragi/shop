<?php

class admincontroller extends controller
{
	public function __construct()
	{
		parent::__construct();
		if(!$this->isAdmin())
		{
			header("Location: http://localhost/shop/public/admin/login");
		}
		
	}
	public function changelocation()
	{
		
		header("Location: http://localhost/shop/public/admin/products/1");

	}
	public function find($id)
	{
		$product = (new product)->find($id);
		$data["product"] = $product;
		$this->view->render("products.php", $data, null);
	}
	
	public function getaddproductform()
	{
		$otherdata['token'] = $_SESSION['token'];
		$this->view->render("addproduct.php", null, $otherdata);
	}
	public function addproduct()
	{
		$errors = $this->validator->validate($_POST, [
			
			"title" => "required|alpha_num",
			"price" => "required|numeric",
			"stock" => "required|integer",
			"categ" => "required|alpha",
			"brand" => "required|alpha",
			"description" => "required",
			"new_price"   => "requiredwith:date,time"
			]);
		if(count($errors) > 0)
		{
			
			$this->view->render("addproduct.php", null, $errors);
			die();
		}

	
		if(!$this->csrf->verifytoken($_SESSION['token'], $_POST))
		{
			die("csrf error :");
		}
		$product = new product();
		foreach ($_POST as $key => $value) {
			# code...
			if($value == "_token" OR $value == "data" or $value == "time")
			{
				continue;
			}
			if($key == "new_price" AND $value > 0)
			{
				$product->offers = "yes";

			}
			$product->$key = $value;
		}
		if($id = $product->save())
		{
			$builder = new builder;
			$datetime = $_POST['date'] . " " . $_POST['time'];
			$timediff = $builder->timediff($datetime);
			$timediff = substr($timediff, 0, strrpos($timediff, ":"));

			$hours = $timediff;
			$pid       = $id;
			$eventname = "id" . $pid;
			$query = "
			CREATE EVENT $eventname 
			ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL '$hours' HOUR_MINUTE
			DO
			UPDATE product SET offers = 'no' AND new_price = '0' WHERE id = '$pid';
			";
			$builder->execquery($query);
			
			
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
		else
		{
			die("error in adding the product");
		}

	}
	public function compare($object1, $object2)
	{
		if(isset($_POST['sortoption']))
		{
			$sortorder = $_POST['sortoption'];
		}
		else
		{
			$sortorder = "title";
		}
		if($object1->$sortorder == $object2->$sortorder)
		{
			return 0;
		}
		if($object1->$sortorder < $object2->$sortorder)
		{
			return -1;
		}
		if($object1->$sortorder > $object2->$sortorder)
		{
			return 1;
		}
	}
	public function getproducts($id, $sortorder=null)
	{
		
		$product = new product;
		$otherdata = [];
		$search = '';
		$records = [];

		if(!isset($_POST['search']) OR empty($_POST['search']))
		{
		$records = $product->table("product")->paginate(10, $id)->getAll();
		$records = $product->makeObject($records);
		}
		else
		{
			$search               = rtrim($_POST['search']);
			$searchkey            = $_POST['searchkey'];
			$otherdata['search']  = $_POST['search'];
			$otherdata['searchkey'] = $searchkey;
			$records = $product->table("product")->where($searchkey, "LIKE", $_POST['search'])->paginate(10, $id)->getAll();
			if($records)
			{

			$records = $product->makeObject($records);
			}
			else
			{
				/* product => [a-z]+roduct */
				$patterns = [];
				for($i = 0; $i < strlen($search); ++$i)
				{

					$pattern = ".*";
					if($i == 0)
					{

				$patterns[] = $pattern . substr($search, $i + 1);
				}
				else
				{
				$patterns[] = substr($search, 0, $i) . $pattern . substr($search, $i + 1);
				}
			}
				foreach ($patterns as $key => $value) {
				# code...
				$recordsdata = $product->table("product")->where($searchkey, "REGEXP", $value)->get();
				if($recordsdata)
				{


				$records[]   = $product->makeObject($recordsdata);
			}
				else
				{
					$records['notfound'] = "There Is NO Records";
				}
			}
			
				return $this->view->render("searchsuggestions.php", array_unique($records), null);
			}
		
		
			
		}
		

		if(isset($_POST['sortoption']))
		{
			$otherdata["sortoption"] = $_POST['sortoption'];
		}
		else
		{
			$otherdata["sortoption"] = "title";
		}
		usort($records, [$this, "compare"]);	
		
		
		if(!$records)
		{
			$otherdata["notfound"] = "There is no records left";
		}

		if(empty($search))
	  {
       	if($nextrecords = $product->table("product")->paginate(10, $id + 1)->getAll())
       	{
       		$otherdata["Next"] = $id + 1;
       	}
       }
       else
       {
	       	if($nextrecords = $product->table("product")->where($searchkey, 'LIKE', $search)->paginate(10, $id + 1)->getAll())
	       	{
	       		$otherdata["Next"] = $id + 1;
	       	}
       }

       	 if($id > 1)

       	{
       		if(empty($search))
       		{
       	if($previousrecords = $product->table("product")->paginate(10, $id - 1)->getAll())
       	{
       		
       		$otherdata["Previous"] = $id - 1;
       	}
       }
       else
       {
       	if($previousrecords = $product->table("product")->where($searchkey, "LIKE", $search)->paginate(10, $id - 1)->getAll())
       	{
       		$otherdata["Previous"] = $id - 1;
       	}
       }
       }
       	$otherdata['token'] = $_SESSION['token'];
	
		$this->view->render("products.php", $records, $otherdata);
	}
	public function deleteproduct($id)
	{

		if(!$this->csrf->verifytoken($_SESSION['token'], $_POST))
		{
			die("csrf ya 5awal :D");
		}
		$product = (new product)->find($id);
		$cart    = (new cart)->findkey("product_id", $id);
		foreach ($cart as $key => $object) {
				# code...
				$object->delete();
			}
		if($product->delete())
		{

			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
		else
		{
			"error in deletion";
		}

	}
	public function geteditproduct($id)
	{
		
		$product = (new product)->find($id);
		$otherdata["token"] = $_SESSION['token'];
		$this->view->render("editproduct.php", $product, $otherdata);
	}
	public function editproduct($id)
	{
		if(!$this->csrf->verifytoken($_SESSION['token'], $_POST))
		{
			die("csrf error :)");
		}

		$product = (new product)->find($id);
		
		foreach ($_POST as $key => $value) {
			# code...
			if($value == "_token")
			{
				continue;
			}
			if($key == "new_price" AND $value > 0)
			{
				$product->offers = "yes";
			}
			elseif($key == "new_price" AND $value == 0)
			{
				$product->offers = "no";
			}
			$product->$key = $value;
		}
		if($product->save())
		{
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
		else
		{
			die("error in update");
		}
	}
	public function filterproduct()
	{
		
	}
}

?>	