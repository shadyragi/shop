<?php
class wishlist extends eloquent
{
	public $product_id;
	public $category;
	public $product_name;
	public $price;
	public $qty;
	public $user_id;
	public $id;
	protected $dbfields = array("id", "user_id", "product_id", "price", "qty", "product_name", "category");

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