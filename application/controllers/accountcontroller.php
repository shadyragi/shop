<?php
error_reporting(0);
@session_start();
class accountcontroller extends controller
{
	public function getaccount()
	{
		$user = (new users)->find($_SESSION['user']);
		$this->view->render("myaccount.php", $user);
	}
	public function updateaccount()
	{

		$user = (new users)->find($_POST['id']);
	
		$errors = $this->validator->validate($_POST, [
			'username' => 'required|withoutspace|notstartwithnumber',
			'email'    => 'required|email|unique:users,email',
			'pwd'      => 'required|withoutspace|pwdwithnum',
			'confirmpwd' => 'required|confirmed:pwd'
			]);
		if(count($errors) == 0)
		{
		extract($_POST);
		$user->username = $username;
		$user->pwd      = $pwd;
		$user->email    = $email;

		if($user->update())
		{
		  $this->view->render("myaccount.php", $user);
		}
	}
	else
	{
		
		$this->view->render("myaccount.php", $user, $errors);
	}

	}
}

?>