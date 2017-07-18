<?php

class database
{
	private $db;
	public function __construct()
	{
		try {
      $this->db = @mysqli_connect('127.0.0.1', 'root', '', 'ecommerce');
      if(!$this->check_connection())
      {
         throw new Exception("error in connecting to the database");	
      
      }
      else {
      	//echo "connected";
      }
	}
	catch(Exception $ex)
	{
      die($ex->getMessage());
	}
}
	private function check_connection()
	{
		if(mysqli_connect_errno() == 0)
		{
			return true;
		}
		else {
			return false;
		}
	}
	public function query($sql)
	{
		
		$result = mysqli_query($this->db, $sql);

		
		try
		{
		if(!$this->check_query($result))
		{

			//echo $sql;
			echo $sql;
			throw new Exception("error in executing the query");
		}
		else {

			return $result;
		}
	}
	catch(Exception $ex)
	{
		echo $ex->getMessage() . " " . mysqli_error($this->db);
	}
}
	
	
	public function fetch($result)
	{
      $data = mysqli_fetch_assoc($result);
      return $data;   
	}
	public function fetch_all($result)
	{
		$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $data;
	}
	public function affected_rows()
	{
		return mysqli_affected_rows($this->db);

	}
	private function check_query($result)
	{
		if($result)
		{
			return true;
		}
		else {
			return false;
		}
	}
}
?>