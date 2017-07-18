<?php
class session
{
	public function __construct()
	{
		session_start();
	}
	public function get($key, $default=false)
	{
		if(isset($_SESSION[$key]))
		{
			return $_SESSION[$key];
		}
		else {
			return $default;
		}
	}
	public function has($key)
	{
		if(isset($_SESSION[$key]))
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	public function flush()
	{
		foreach ($_SESSION as $key => $value) {
			# code...
			unset($_SESSION[$key]);
		}
	}
	public function all()
	{
		return $_SESSION;
	}
	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
	public function destroy()
	{
		session_destroy();
	}
	public function forget($key)
	{
		unset($_SESSION[$key]);
	}
}
?>