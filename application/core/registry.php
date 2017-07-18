<?php
class registry
{
	public static  $objects = [];
	private static $instance;
	private static $counter = 0;
	private function __construct()
	{

	}
	public static function getInstance()
	{
		
		if(!isset(self::$instance))
		{

			self::$instance = new self;
			return self::$instance;
		}
		else
		{
			return self::$instance;
		}
	}

	public function getObjects()
	{
		return $this->objects;
	}
	public static function getObject($objectname)
	{
		if(isset(self::$objects[$objectname]))
		{
			return self::$objects[$objectname];
		}
		return false;
	}
	public static function setObject($objectname, $object)
	{
		if(!isset(self::$objects[$objectname]))
			{
		self::$objects[$objectname] = $object;
			}
		return self::$objects[$objectname];
	}
	
}

?>