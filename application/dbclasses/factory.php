<?php

class factory
{
	public static function build($type, $data)
	{
		
		$fullpath = $type;
		$object = new $fullpath;
		foreach ($data as $key => $value) {
			# code...
			if(array_key_exists($key, get_object_vars($object)))
			{
				$object->$key = $value;
			}
		}
		return $object;
	}
}

?>