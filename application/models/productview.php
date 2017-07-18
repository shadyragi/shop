<?php

class productview extends eloquent
{
	public $id;
	public $user_id;
	public $product_id;
	public $category;
	protected $dbfields = ["id", "user_id", "product_id", "category"];

	public function Refresh()
	{
		if($this->maxrowsnumber())
		{
			
			$data = $this->table("productview")->where("user_id", "=", $this->user_id)->orderBy("id")->take(1)->get();
			$object = $this->makeObject($data);
			$object->delete();
		}
	

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
	private function maxrowsnumber()
	{
		
		$data = $this->findkey("user_id", $this->user_id);
		if(count($data) >= 10)
		{
			return true;
		}
		return false;

	}
}

?>