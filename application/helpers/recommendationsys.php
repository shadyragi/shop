<?php
session_start();
error_reporting(0);
class recommendationsys 
{
	public $objects = [];
	public $user_id;
	
	public function __construct()
	{
		$this->user_id		 = 	   $_SESSION['user'];
		$this->objects["cart"] 	     = 	   new cart();
		$this->objects["wishlist"]     =     new wishlist;
		$this->objects["productview"]  =     new productview();

		$this->cart->user_id     = 	   $this->user_id;
		$this->wishlist->user_id = $this->user_id;
	 $this->productview->user_id = $this->user_id;


	}
	public function getCategory()
	{
		$categs = [];
		foreach ($this->objects as $key => $value) {
			# code...
			$categs[] = $value->getMostFrequentCategory();
		}
		
		return ($this->numofrepeat($categs));
		
		
	}
	
	public function __get($key)
	{
		return $this->objects[$key];
	}
	private function numofrepeat($data = [])
	{
		$filter = [];
		foreach ($data as $key => $value) {
			# code...
			if(!isset($filter[$value]))
			{
				$filter[$value] = 1;
			}
			else
			{
				$filter[$value] += 1;
			}
		}
		arsort($filter);
		return key($filter);
	}
}

?>