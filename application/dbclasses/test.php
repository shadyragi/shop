<?php
require_once 'testparent.php';
class test extends myclass
{
  
	public $var1;
	public $var2;
	public function store()
	{
		$this->var1 = 90;
	}
}
$obj = new test();
$obj->store();
$obj->doit();

?>
