<?php
session_start();
class adminlogincontroller extends controller
{
	public function getloginform()
	{

		$this->view->render("adminloginform.php");
	}
	public function postform()
	{
		$errors = $this->validator->validate($_POST, [
			"username" => "required|withoutspace|alpha_num",
			"pwd"      => "required|alpha_num"
			]);
		if(count($errors) > 0)
		{
			$this->view->render("adminloginform.php", null, $errors);
			die();
		}
		$admin = new admin;
	$data = $admin->table("admin")->where("username", "=", $_POST['username'])->andwhere("pwd", "=", $_POST['pwd'])->get();
	if($data)
	{
		
		$admin = $admin->makeObject($data);
		$_SESSION['admin'] = $admin;
		
		header("Location: http://localhost/shop/public/admin/products");
	}
	else
	{
		$loginerror['login'] = "username or password is incorrect";
		$this->view->render("adminloginform.php", null, $loginerror);
		die();
	}
	}
	public function logout()
	{
		unset($_SESSION['admin']);
		header("Location: http://localhost/shop/public/admin/login");
	}
}

?>