<?php

class blocked extends eloquent
{
	public $id;
	public $blocked_ip;
	protected $dbfields = ["id", "blocked_ip"];
}

?>