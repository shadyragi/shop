<?php

class paginator
{
	public $totalpages;
	public $itemsperpage;
	public $currentpage;

	

	public function paginate($itemsperpage, $currentpage)
	{
		$this->itemsperpage = $itemsperpage;
		$this->currentpage  = $currentpage;
		$this->totalpages   = ceil($this->countrecords() / $itemsperpage);
			$offset             = ceil($this->itemsperpage * ($this->currentpage - 1));
			$records            = $this->table($this->table)->take($this->itemsperpage)->skip($offset)->getAll();
			$records            = $this->makeObject($records);
			return $records;


	}
	private function countrecords()
	{

		return count($this->all());

	}
	public function next()
	{
		return $this->currentpage + 1;

	}
	public function previous()
	{
		return --$this->currentpage;
	}
	public function hasNext()
	{
		if(++$this->currentpage <= $this->totalpages)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function hasPrevious()
	{
		if(--$this->currentpage > 1)
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