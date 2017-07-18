<?php
function __autoload($classname)
{
	$path = $classname . ".php";
	if(file_exists($path))
	{
		require_once $path;
	}
	else {
		die("not found class" . $classname);
	}
}

?>