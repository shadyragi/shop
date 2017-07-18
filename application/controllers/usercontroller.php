<?php

class usercontroller extends controller
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
		
		header("Location: http://localhost/shop/public/admin/users/1");

	}
	public function getadduserform()
	{
		$otherdata['token'] = $_SESSION['token'];
		$this->view->render("adduser.php", null, $otherdata);
	}
	
	public function adduser()
	{
		if(!$this->csrf->verifytoken($_SESSION['token'], $_POST))
		{
			die("csrf error :");
		}
		$errors = $this->validator->validate($_POST, [
			"username" => "required",
			"pwd"      => "required|alpha_num",
			"confirmpwd" => "required|confirmed:pwd",
			"email"      => "required|email|unique:users,email"
			]);

		
		
		
		if(count($errors) > 0)
		{
			$correctdata = [];
			foreach ($_POST as $key => $value) {
			# code...
			if(!isset($errors[$key]))
			{
				$correctdata[$key] = $value;
			}
		}
			$otherdata['errors'] = $errors;
			$this->view->render("adduser.php", $correctdata, $otherdata);
			die();
		}
	
		$user = new users();
		foreach ($_POST as $key => $value) {
			# code...
			
			$user->$key = $value;
		}
		if($user->save())
		{
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
		else
		{
			die("error in adding the product");
		}

	}
	public function getusers($id, $sortorder=null)
	{
		$user = new users;
		$otherdata = [];
		$search = '';
		if(!isset($_POST['search']))
		{
		$records = $user->table("users")->paginate(10, $id)->getAll();
		$records = $user->makeObject($records);
		}
		else
		{
			$search               = $_POST['search'];
			$otherdata['search']  = $_POST['search'];
			$records = $user->table("users")->where("username", "LIKE", $_POST['search'])->paginate(10, $id)->getAll();
			$records = $user->makeObject($records);
		}
		

		if(isset($_POST['sortoption']))
		{
			$otherdata["sortoption"] = $_POST['sortoption'];
		}
		else
		{
			$otherdata["sortoption"] = "username";
		}
		usort($records, [$this, "compare"]);	
		
		
		if(!$records)
		{
			$otherdata["notfound"] = "There is no records left";
		}

		if(empty($search))
	  {
       	if($nextrecords = $user->table("users")->paginate(10, $id + 1)->getAll())
       	{
       		$otherdata["Next"] = $id + 1;
       	}
       }
       else
       {
	       	if($nextrecords = $user->table("users")->where("username", 'LIKE', $search)->paginate(10, $id + 1)->getAll())
	       	{
	       		$otherdata["Next"] = $id + 1;
	       	}
       }

       	 if($id > 1)

       	{
       		if(empty($search))
       		{
       	if($previousrecords = $user->table("users")->paginate(10, $id - 1)->getAll())
       	{
       		
       		$otherdata["Previous"] = $id - 1;
       	}
       }
       else
       {
       	if($previousrecords = $user->table("users")->where("username", "LIKE", $search)->paginate(10, $id - 1)->getAll())
       	{
       		$otherdata["Previous"] = $id - 1;
       	}
       }
       }
       	
		
		$this->view->render("users.php", $records, $otherdata);
	}
	public function deleteuser($id)
	{
		$user = (new users)->find($id);
		if($user->delete())
		{
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
		else
		{
			"error in deletion";
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
			$sortorder = "username";
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
}

?>