<?php

class cart extends eloquent
{
	public $id;
	public $user_id;
	public $product_id;
	public $qty;
	public $price;
	public $product_name;
	public $category;
	protected $dbfields = ["id", "user_id", "product_id", "qty", "price", "category"];
	
	public function productName()
	{
		$this->product_name = (new product)->find($this->product_id)->title;

	
		return $this->product_name;
	}
	public function getMostFrequentCategory()
	{
		$objects = $this->findkey("user_id", $this->user_id);
		$filter  = [];
		foreach ($objects as $key => $object) {
			# code...
			if(!isset($filter[$object->category]))
			{
				$filter[$object->category] = 1;
			}
			else
			{
				$filter[$object->category] += 1;
			}

		}
		arsort($filter);
		return key($filter);
	
		
		
	}
}

?>