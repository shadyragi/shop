<?php

class csrf
{
	public function generatetoken($type)
	{

		$token = uniqid($type, true);
		return $token;
	}
	public function verifytoken($token, $data)
	{
		if(isset($data['_token']) AND $data['_token'] == $token)
		{
			return true;
		}
		return false;
	}
}

?>