<?php


class controller
{
	protected $view;
	protected $validator;
	protected $registry;
	protected $csrf;
	protected $container = [];
	protected $app;
	public function __construct()
	{
		@session_start();
		error_reporting(0);
		$this->view = new view();
		$this->validator = new validator();
		$this->csrf      = new csrf();
	}
	protected function isAdmin()
	{
		if(isset($_SESSION['admin']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	protected function isUser()
	{
		if(isset($_SESSION['user']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>