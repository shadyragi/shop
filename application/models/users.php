<?php
session_start();
class users extends eloquent
{
	public $id;
	public $username;
	public $pwd;
	public $email;

	public static function isLoggedIn()
	{
		if(isset($_SESSION['user']) && !empty($_SESSION['user']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function hasProduct($tablename, $id)
	{

		if($result = $this->table($tablename)->where("product_id", "=", $id)->andwhere("user_id", "=", $this->id)->get())
		{
		
			
			return factory::build($tablename, $result);
		}
		else
		{
			return false;
		}
	}
}

?>