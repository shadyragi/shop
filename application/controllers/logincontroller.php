<?php

class logincontroller extends controller
{
	public function getform()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$block = (new blocked)->findkey("blocked_ip", $ip);
		if($block)
		{
			die("You Are Blocked");
		}

		if(isset($_SESSION['user']))
			{
			  header("Location: http://localhost/shop/public/home");
			}
			else
		$this->view->render("loginform.php");
	}
	public function getsignupform()
	{
			if(isset($_SESSION['user']))
			{
			  header("Location: http://localhost/shop/public/home");
			}
		$this->view->render("signupform.php");
	}
	public function postform($email=null, $pwd=null)
	{

		$data['email'] = $_POST['email'];
		$data['pwd']   = $_POST['password'];
		$errors        = $this->validator->validate($_POST, [
			"email" => "required|email",
		
			"password"      => "required|alpha_num"
			]);
		if(count($errors) > 0)
		{
			$this->view->render("loginform.php", null, $errors);
			die();
		}
		if($user = (new users)->exist($data))
		{
			$_SESSION['user'] = $user->id;

			
			if($_POST['persistent'] == "on")
			{
				$token = new token;
				$data  = $token->table("token")->where("user_id", "=", $user->id)->get();
				if($data)
				{
					$token = $token->makeObject($data);
					$token->token = $token->generatetoken();
					$token->used = 0;
					$token->save();
				}
				
				else
				{
				
				$token->user_id = $user->id;
				$token->token   = $token->generatetoken();
				if(!$token->save())
				{
					die("error in saveing the token");
				}
			}
				setcookie("token", $token->token, time() + 60 * 60 * 7);
			}
			header("Location: http://localhost/shop/public/home");
		}
		
		else
		{

			if(isset($_SESSION['incorrect']))
		{
			if($_SESSION['incorrect'] > 3)
			{
				$builder = new builder();
				$block = new blocked();
				$ip = $_SERVER['REMOTE_ADDR'];
				
				$block->blocked_ip = $ip;
				if($id = $block->save())
				{
					
					$eventname = "blockevent" . $id;
					$sql = "CREATE EVENT $eventname ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 24 hour 
							DO DELETE FROM blocked WHERE id = '$id';
					";
					$builder->execquery($sql);
					die("You Are Blocked");
				}
				else
				{
					die("error in saving the record");
				}


			}
		else
		{
			++$_SESSION['incorrect'];
		}
		}
		else
		{
			$_SESSION['incorrect'] = 1;
			
		}
		$errors['loginerror'] = "Email Or Password is Incorrect";
		$this->view->render("loginform.php", null, $errors);
		die();

		}
	}
	public function postsignupform()
	{
		$data['email'] = $_POST['email'];
		$data['username'] = $_POST['username'];
		$data['password'] = $_POST['password'];
		$errors = $this->validator->validate($data, [
			'email'    => 'required|email|unique:users,email',
			"username" => 'required|withoutspace|notstartwithnumber',
			"password" => 'required|withoutspace|pwdwithnum'

			]);
		 
		 if(count($errors) > 0)
		 {
		 	$this->view->render("signupform.php", $errors);
		 }
		 else
		 {
		 	$user = new users();
			$user->email = $data['email'];
			$user->username = $data['username'];
			$user->pwd      = $data['password'];		 		
		 	if($id = array_shift($user->save($data)))
		 	{
		 		$_SESSION['user'] = $id;
		 		header("Location: http://localhost/shop/public/home");
		 	}
		 	else
		 	{
		 		die("error in inserting the record");
		 	}
		 }
	}
	public function logout()
	{
	
		
		if(isset($_COOKIE['token']))
		{
			$token = new token();
			setcookie("token", '', time() - 60 * 60 * 7);
			$data = $token->table("token")->where("user_id", "=", $_SESSION['user'])->get();
			$token = $token->makeObject($data);
			
			$token->delete();
			
		}
		
	
		unset($_SESSION['user']);
	
		header("Location: http://localhost/shop/public/home");
	}

}

?>