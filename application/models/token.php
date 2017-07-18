<?php

class token extends eloquent
{
	public $id;
	public $user_id;
	public $token;
	public $used;
	public function generatetoken()
	{
		return uniqid($this->user_id."|", true);
	}
	public function getId()
	{
		return substr($this->token, 0, strpos($this->token, "|"));
	}
}

?>