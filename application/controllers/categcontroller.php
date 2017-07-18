<?php

class categcontroller extends controller
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
		
		header("Location: http://localhost/shop/public/admin/categories/1");


	}
	public function getaddcategform()
	{
		$otherdata['token'] = $_SESSION['token'];
		$this->view->render("addcateg.php", null, $token);
	}
	public function addcateg()
	{

		if(!$this->csrf->verifytoken($_SESSION['token'], $_POST))
		{
			die("csrf error :");
		}

		$errors = $this->validator->validate($_POST, [
			"category_name" => "required|alpha|unique:category,category_name",
			]);
		if(count($errors) > 0)
		{
			$this->view->render("addcateg.php", null, $errors);
			die();
		}
		$categ = new category();
		foreach ($_POST as $key => $value) {
			# code...
			
			$categ->$key = $value;
		}
		if($categ->save())
		{
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
			$sortorder = "category_name";
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
	public function deletecateg($id)
	{
		$categ = (new category)->find($id);
		if($categ->delete())
		{
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
		else
		{
			"error in deletion";
		}

	}
	public function getcategs($id, $sortorder=null)
	{
		$user = new category;
		$otherdata = [];
		$search = '';
		if(!isset($_POST['search']))
		{
		$records = $user->table("category")->paginate(10, $id)->getAll();
		$records = $user->makeObject($records);
		}
		else
		{
			$search               = $_POST['search'];
			$otherdata['search']  = $_POST['search'];
			$records = $user->table("category")->where("category_name", "LIKE", $_POST['search'])->paginate(10, $id)->getAll();
			$records = $user->makeObject($records);
		}
		

		if(isset($_POST['sortoption']))
		{
			$otherdata["sortoption"] = $_POST['sortoption'];
		}
		else
		{
			$otherdata["sortoption"] = "category_name";
		}
		usort($records, [$this, "compare"]);	
		
		
		if(!$records)
		{
			$otherdata["notfound"] = "There is no records left";
		}

		if(empty($search))
	  {
       	if($nextrecords = $user->table("category")->paginate(10, $id + 1)->getAll())
       	{
       		$otherdata["Next"] = $id + 1;
       	}
       }
       else
       {
	       	if($nextrecords = $user->table("category")->where("category_name", 'LIKE', $search)->paginate(10, $id + 1)->getAll())
	       	{
	       		$otherdata["Next"] = $id + 1;
	       	}
       }

       	 if($id > 1)

       	{
       		if(empty($search))
       		{
       	if($previousrecords = $user->table("category")->paginate(10, $id - 1)->getAll())
       	{
       		
       		$otherdata["Previous"] = $id - 1;
       	}
       }
       else
       {
       	if($previousrecords = $user->table("category")->where("category_name", "LIKE", $search)->paginate(10, $id - 1)->getAll())
       	{
       		$otherdata["Previous"] = $id - 1;
       	}
       }
       }
       	
		
		$this->view->render("categories.php", $records, $otherdata);
	}
	}


?>