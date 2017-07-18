<?php
	/*
	*
	*
	this class is only for learning relflection api
	
	*/
	interface I1
	{
		public function sayhi($name);
	}
	class parentclass
	{

	}
final class myclass extends parentclass implements I1, Iterator
{
	public $x;
	private $values;
	public static $table;
	private $password;
	protected $name;
	private $position;
	private function __clone()
	{

	}
	public function __construct($name=null, $pwd=null)
	{
		echo "hi i am the constructor";
	}
	public function serialize()
	{
		echo "serializing ..";
	return serialize(["name" => $this->name, "password" => $this->password]);
	}/*
	public function unserialize($data)
	{
		echo "unserialing ...";
		$objectdata = unserialize($data); 
		$this->name = $objectdata['name'];
		$this->password = $objectdata['password'];
	}*/
	public function current()
	{
		var_dump(__METHOD__);
		return $this->values[$this->position];
	}
	public function key()
	{
		var_dump(__METHOD__);
		return $this->position;
	}
	public function next()
	{
		var_dump(__METHOD__);
		++$this->position;
	}
	public function valid()
	{
		var_dump(__METHOD__);
		return isset($this->values[$this->position]);
	}
	public function rewind()
	{
		var_dump(__METHOD__);
		$this->position = 0;
	}
	public static function statfunc()
	{
		return "static testing ...";
	}
	public function sayhi($names = [])
	{
		$values = implode(" ", $names);
		
	}
	public function getname()
	{
		return $this->name;
	}
	public function setname(parentclass &$name,  $pwd=10)
	{
		$this->name = $name;
		$this->password = $pwd;
	}
	public function variadic(...$args)
	{
		foreach ($args as $key => $value) {
			# code...
			echo $value . "<br>";
		}
	}
	private function myfunc()
	{
		return "testing..";
	}

}
function func()
{
	for($i =0; $i < 5; ++$i)
	{
		yield $i;
	}
}


$pwd = password_hash("password", PASSWORD_BCRYPT);
if(password_verify('password', $pwd))
{
	echo "welcome";
}
else {
	echo "not welcome yabn l ws5a :D";
}