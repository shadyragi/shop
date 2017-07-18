<?php
class myclass
{
	public $var3;
	public $var4;
	public function doit() {
		$objname = get_called_class();
		$object = new $objname;
	    print_r(get_object_vars($object));
	}
}

?>