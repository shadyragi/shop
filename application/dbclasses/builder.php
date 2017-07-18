<?php
//require_once '../ooprev/database.p
class builder 
{
	private $table=null;
	public $query = null;
	private $db;
	public function __construct()
	{
		$this->db = new database();
	}
	public function execquery($query)
	{

		
		$result = $this->db->query($query);
		$data   = $this->db->fetch($result);
		return $data;
	}
	public function timediff($time, $time2=null)
	{
		$query = "SELECT TIMEDIFF('$time', NOW())";
		$result = $this->db->query($query);
		$data   = $this->db->fetch($result);
		//print_r(array_shift($data));
		return array_shift($data);
	}
	public function table($table=null)
	{
		if(!is_null($table))
		{
			$this->table = $table;
			return $this;
		}
		else 
		{
			die("missing table argument");
		}
	}

	public function where($name=null, $operator='=', $value=null)
	{
		if($operator == 'LIKE')
		{
			$this->query  .= "WHERE $name LIKE '%$value%'";
			
		}
		else 
		{
			$this->query .= "WHERE $name $operator '$value'";
 			
		}
		return $this;

	}
	public function chunk($number, $callback)
	{
		
		$data = $this->get();
		$i = 0;
		while($i < sizeof($data))
		{
			$newdata = array();
			for($x = 0; $x < $number; ++$x)
			{
				$newdata[] = $data[$i];
				++$i;
			}
			call_user_func($callback, $newdata);
			
		}

	}
	public function andwhere($key, $operator = '=', $value)
	{
		if($operator == "LIKE")
		{
			$this->query .= " AND $key LIKE '%$value%' ";
		}
		else
		{
		$this->query .= " AND $key $operator '$value' ";
		}
		return $this;
	}
	public function countrecords()
	{
		$this->query .= " COUNT(*) FROM $this->table ";
		return $this;
	}
	public function paginate($itemsperpage, $pageid)
	{
		

		$offset       = $itemsperpage * ($pageid - 1);
		
		$this->query .= " LIMIT $itemsperpage OFFSET $offset";
		return $this;
	

	}
	 public function exist($data = [])
	 {
	  
	    
	    $dataforquery = [];
	    $counter = 0;
	    foreach ($data as $key => $value) {
	      # code...
	    	if($counter == 0 AND sizeof($data) > 0) {
	      $this->query .= "WHERE $key = '$value' AND ";
	  		}
	  		else if($counter == 0 AND sizeof($data) == 1)
	  		{
	  			$this->query .= "WHERE $key = '$value' ";
	  		}
	  		else if($counter == sizeof($data) - 1) {
	  			$this->query .= "$key = '$value' ";
	  		}
	  		else {
	  			$this->query .= "$key = '$value' AND ";
	  		}
	  		++$counter;
	    }
	    return $this;
	  }
	  public function lastId()
	  {
	  	$this->query .= " LAST_INSERT_ID() ";
	  	return $this;
	  }

	public function orderBy($argument=null, $sortorder="asc")
	{
		if(!is_null($argument))
		{
			

      	    $this->query .= "ORDER BY $argument $sortorder ";
     		
     		
         return $this;
		}
		else {
			die("missing argument in order by clause");
		}
	}
	public function take($limitnumber=null)
	{
		if(!is_null($limitnumber))
		{

		$this->query .= " LIMIT $limitnumber ";
		return $this;

		}
		else 
		{
			die("missing argument in take clause");
		}

	}
	public function skip($number)
	{
		$this->query .= " OFFSET $number ";
		return $this;
	}
	public function insert($values = array())
	{
      $table = $this->table;
      
      if(!$this->isRecursive($values))
      {
      	
      $keys = implode(', ', array_keys($values));
      $valuesforinsertion = implode("', '", array_values($values));
      $this->query = "INSERT INTO $table($keys) VALUES('$valuesforinsertion')";
      $this->exec();
     	return $this->lastId()->get();
  	  }
  	  else 
  	  {
  	  	foreach ($values as $key => $value) 
  	  	{
  	  		
	  	  $keys = implode(', ', array_keys($value));
	      $valuesforinsertion = implode("', '", array_values($value));
	      
         
	      $this->query = "INSERT INTO $table($keys) VALUES('$valuesforinsertion')";
	      
	      $this->exec();
	      return $this->lastId()->get();

  	  	}
  	  }
      
     
	}
    public function update($updates = array())
    {
    	
      $organizedUpdates = array();
      foreach ($updates as $key => $value) {
      	# code...
      	$organizedUpdates[] = "$key = '$value'";
      }
      $organizedUpdates = implode(", ", $organizedUpdates);

      $oldquery = $this->query;
   
      $this->query = "UPDATE $this->table SET $organizedUpdates " . $oldquery;
      
      return $this;
    }
    public function delete()
    {
    	$oldquery = $this->query;
    	$this->query = "DELETE FROM $this->table " . $oldquery;
    	return $this;
    }
	public function get()
	{
		if(!stristr($this->query, "select") && $this->table != null)
		{
			$oldquery = $this->query;

			$this->query = "SELECT * FROM $this->table " . $oldquery;
			
		}
		else
		{
			$oldquery = $this->query;
			$this->query = "SELECT " . $oldquery;
		}
	     
	     
		 			if($result =  $this->db->query($this->query))
		 			{
		 		     $data 	 =  $this->db->fetch($result);	
		 		    }
		 		    else
		 		    {
		 		    	return false;
		 		    }
	     $this->query = null;
	     $this->table = null;
	     return $data;

	}
	public function getAll()
	{

		if(!stristr($this->query, "select"))
		{
			$oldquery = $this->query;

			$this->query = "SELECT * FROM $this->table " . $oldquery;
			
		}

			if($result =  $this->db->query($this->query))
		 			{
		 		     $data 	 =  $this->db->fetch_all($result);	
		 		    }
		 		    else
		 		    {
		 		    	return false;
		 		    }	
	     $this->query = null;
	     $this->table = null;
	     return $data; 
	}

	public function exec()
	{
			

   	    if($result =  $this->db->query($this->query))
   	    {
   	    	$this->query = null;
   	    	$this->table = null;
   	    	return true;
   	    }
   	    else 
   	    {
   	    	$this->query = null;
   	    	$this->table = null;
   	    	return false;
   	    }

 	}

 	private function isRecursive($array = array())
 	{
 		foreach ($array as $key => $value) {
 			# code...
 			if(is_array($value))
 			{
 				return true;
 			}
 			else {
 				return false;
 			}
 		}
 	}
}

?>