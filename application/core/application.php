<?php

class application
{
	private $objects = [];
	protected $controller;
	protected $method;
	public static $counter = 0;
	protected $registry;
	private static $instance =null;
	protected $params = [];
	public static function getInstance()
	{
		if(is_null(self::$instance))
		{	
			self::$instance = new self;
			
		}
		else
		{
			self::$counter = 1;
			
		}
		return self::$instance;
		
	}
	private function __construct()
	{
	
		/*
		if($object = new $url[0])
		{
			$this->controller = $url[0];
			if(method_exists($object, $url[1]))
			{
				$this->method = $url[1];
			}
			else {
				die("undefined method " . $url[1]);
			}
			if(count($url) > 2)
			{
				for($x = 2; $x < count($url); ++$x)
				{
					$this->params[] = $url[$x];
				}
			}*/

			//call_user_func_array([$object, $this->method], $this->params);
	/*
		else
		{
			die("not found controller");
		}*/
	}
	public function process()
	{
			$this->registry = registry::getInstance();
		
		$url = $this->parseUrl();
		$this->objects["homecontroller"] = new homecontroller;
		$controllerindex = array_search("controller", $url) + 1;
		$methodindex     = array_search("method", $url) + 1;
		$paramsindex     = array_search("params", $url) + 1;
		for($x = $paramsindex; $x < count($url); ++$x)
		{
			$this->params[] = $url[$x];
		}
			$index = $url[$controllerindex];
			$controller = new $index;
		
		
		$method          = $url[$methodindex];
	
		call_user_func_array([$controller, $method], $this->params);
	}
	public function parseUrl()
	{
		
		return explode("/", filter_var($_GET['url'], FILTER_SANITIZE_URL));
	}

}
?>