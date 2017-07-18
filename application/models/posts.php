<?php
require_once '/../public/vendor/autoload.php';
class posts extends eloquent 
{
	public $id;
	public $description;
	public $user_id;
	
}
$post = (new posts)->find(9);

?>