<?php
class product extends eloquent
{
	public $id;
	public $title;
	public $image;
	public $brand;
	public $description;
	public $dte;
	public $price;
	public $stock;
	public $sold;
	public $categ;
	public $offers;
	public $new_price;

	public function getRelatedProducts()
	{
		$objects = [];
		$data    = $this->table("product")->where("categ", "=", $this->categ)->take(3)->getAll();
		$objects = $this->makeObject($data);
		return $objects;
	}
	public function hasStock($qty)
	{
		if($this->stock >= $qty)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>