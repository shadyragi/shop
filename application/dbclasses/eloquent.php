<?php
//require_once 'builder.php';
//require_once 'factory.php';

 class eloquent extends paginator
{
	private $builder;
	public $table;
  public $totalpages = 0;
  public $pageid;
	protected $foriegnkey;
	protected $fields = [];
	public function __construct()
	{

      $this->builder = new builder;
      if(!isset(static::$table))
      {
      	$this->table = get_called_class();
      }
      else 
      {
      	$this->table = static::$table;
      }
    
      if(isset($this->dbfields))
      {
       $this->fields = $this->dbfields; 
      }
      else
      {
        $this->fields = $this->fieldsNames();
      }

     


    

	}
  public function test()
  {
    echo "it is a test okay ? ";
  }
  public function fieldsNames()
  {
    $record = $this->builder->table($this->table)->get();

   
    return array_keys($record);
  }
  public function exist($data)
  {
    if($record = $this->builder->table($this->table)->exist($data)->get())
    {
      return $this->makeObject($record);

    }
    else {
      return false;
    }
  }
	public function find($id)
	{
    
    if(is_array($id))
    {
      $objects = [];
      foreach ($id as $key => $value) {
        # code...
        $objects[] = $this->find($value);
      }
      return $objects;
    }
    else
    {
		$result = $this->builder->table($this->table)->where("id", '=',  $id)->get();
		if(!empty($result))
		{
			 $object = factory::build($this->table, $result);
			 
			 return $object;
		}
		else {
			return "not found record";
		}
  }
	}
  public function search($key, $query)
  {
    $objects = [];
    $result = $this->builder->table($this->table)->where($key, 'LIKE', $query)->getAll();

    if(!empty($result))
    {
      foreach ($result as $key => $value) {
        # code...
        $objects[] = factory::build($this->table, $value);
      }
      return $objects;

    }
  }
	public function findkey($key, $value)
	{
		$result = $this->builder->table($this->table)->where($key, '=', $value)->getAll();
		if(!empty($result))
		{
      $objects = [];
      foreach ($result as $key => $value) {
        # code...
        $objects[] = factory::build($this->table, $value);
         
      }
      return $objects;
			
		}
		else {
			return false;		
    }
	}
	public function all()
	{
		$result = $this->builder->table($this->table)->getAll();
		if(!empty($result))
		{
	     return $this->makeObject($result); 
		}
		else 
		{
			return "no records on that table";
		}
	}
	public function save($extradata = [])
	{
 		if($extradata != null)
 		{
 			foreach ($extradata as $key => $value) {
 				# code...
 				$this->$key = $value;
 			}
 		}
        $objvars = $this->getattrs();
        $valuesforinsertion = array();
		foreach ($objvars as $key => $value) {
			# code...
			if(empty($value))
      {
        continue;
      }
			if(in_array($key, $this->fields))
			{

				$valuesforinsertion[$key] = $value;
			}
			
		}

		
		if(!isset($objvars['id']))
		{
			
    		if($id = $this->builder->table($this->table)->insert($valuesforinsertion))
        {

          return array_shift($id);
        }
        else 
        {
          return false;
        }
		
    }
		else 
		{
    			if($this->builder->table($this->table)->update($valuesforinsertion)->where("id", '=', $objvars['id'])->exec())
          {
            return true;
          }
          else
          {
            return false;
          }
		}

	}
  /*public function paginate($itermsperpage, $currentpage)
  {
   $allrecords = $this->builder->table($this->table)->getAll();
   $allpages   = ceil(count($allrecords) / $itermsperpage);
   $offset     = $itermsperpage * ($currentpage - 1);
   $records    = $this->builder->table($this->table)->take($itermsperpage)->skip($offset)->getAll();
   $records    = $this->makeObject($records);
   return $records;
    

  }*/
    public function update($values = [], $mainkey = 'id')
    {
      if(count($values) == 0)
      {
        $objvars = $this->getattrs();
        $valuesforupdate = [];
        foreach ($objvars as $key => $value) {
          # code...
          if(in_array($key, $this->fields))
          {
            $valuesforupdate[$key] = $value;
          }
        }
        if($result = $this->builder->table($this->table)->update($valuesforupdate)->where($mainkey, "=", $valuesforupdate[$mainkey])->exec())
        {
          return true;
        }
        else
        {
          return false;
        }
      }
      
    }
	public function getattrs()
	{
		return get_object_vars($this);
	}

	public function delete()
	{
      $objvars = $this->getattrs();
      $id = $objvars['id'];
      if($this->builder->table($this->table)->delete()->where("id", '=', $id)->exec())
      {
        return true;
      }
      else {
        return false;
      }
	}
    public function comments()
    {
    	
    	$comment = new comments();
    	$comment->posts_id = $this->id;
    	return $comment;
    }

    public function phones()
    {
    	return $this->hasOne("phones");
    }
    public function degrees()
    {
    	return $this->ManytoMany("users_degree", "user_id");
    }
    public function paginate($itermsperpage, $pageid)
    {
      if($this->totalpages == 0)
      {
        $count = count($this->builder->table($this->table)->getAll());
        $this->totalpages = ceil($count / $itermsperpage);
      }
      $this->pageid = $pageid;
      if($records = $this->builder->table($this->table)->paginate($itermsperpage, $pageid)->getAll())
      {
        return $this->makeObject($records);
      }

    }
    public function next()
    { 
      ++$this->pageid;
    }
    public function previous()
    {
      --$this->pageid;
    }
    public function hasNext()
    {
      if(++$this->pageid <= $this->totalpages)
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
        if(--$this->pageid > 1)
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    protected function ManytoMany($tablename, $foriegnkey = null)
    {
    	$degrees = array();
    	$maintablename = substr($tablename, strpos($tablename, "_") + 1);
  		$result = $this->builder->table($tablename)->where($foriegnkey, '=', $this->id)->getAll();
  		

  		
  		foreach ($result as $key => $value) {
  			# code...

  			$result2 = $this->builder->table($maintablename)->where("id", '=', $value['education_id'])->get();
  			$degreeObject = factory::build("degree", $result2);
  			array_push($degrees, $degreeObject);
  		}
  		return $degrees;
  		
    }

    public function hasMany($tablename, $foriegnkey=null)
    {
      if(is_null($foriegnkey))
      {     
        $foriegnkey = $this->table . "_id";
      
      }   
       	$records = array();
    	//$builder = new builder();
    	$result = $this->builder->table($tablename)->where($foriegnkey, '=', $this->id)->getAll();
     
    	foreach ($result as $key => $value) 
    	{
    		# code...
    		array_push($records, factory::build($tablename, $value));
    	}
    	return $records;
    	
    	

    }

    public function has($tablename, $operator=null, $number=null, $foriegnkey=null)
    {
    	$foriegnkey = $this->table . "_id";
    	
    	$allrecords = $this->builder->table($this->table)->getAll();
    	$allrecordsobjects = array();
    	foreach($allrecords as $key => $value)
    	{
    		/*
    		$recordobject = factory::build($this->table, $value);
    		$data = $recordobject->hasMany($tablename);
    		*/
    		$data = $this->builder->table($tablename)->where($foriegnkey, '=', $value['id'])->getAll();

    		if(!empty($data))
    		{
    			$recordobject = factory::build($this->table, $value);
    			array_push($allrecordsobjects, $recordobject);
    		}
    	}
    	return $allrecordsobjects;

    	
    	
    }
    public function doesnothave($tablename, $foriegnkey=null)
    {
    	$foriegnkey = $this->table . "_id";
    	$allrecords = $this->builder->table($this->table)->getAll();
    	$allrecordsobjects = array();
    	foreach($allrecords as $key => $value)
    	{
    		/*
    		$recordobject = factory::build($this->table, $value);
    		$data = $recordobject->hasMany($tablename);
    		*/
    		$data = $this->builder->table($tablename)->where($foriegnkey, '=', $value['id'])->getAll();

    		if(empty($data))
    		{
    			$recordobject = factory::build($this->table, $value);
    			array_push($allrecordsobjects, $recordobject);
    		}
    	}
    	return $allrecordsobjects;
    }

    protected function hasOne($tablename, $foriegnkey=null)
    {
      if(is_null($foriegnkey))
      {
          $foriegnkey = $this->table . "_id";
      }
 	
 		$result = $this->builder->table($tablename)->where($foriegnkey, '=', $this->id)->get();
    if($result)
 	  { 
      $phoneObject = factory::build("phones", $result);
  
       return $phoneObject;
     }
     else
     {
      return false;
     }
    }


	public function makeObject($data)
	{
    $objects = [];
    foreach ($data as $key => $value) {
      # code...
      if(is_array($value))
      {
        $objects[] = factory::build(get_called_class(), $value);

      }
      else
      {
        break;
       
      }
    }
    if(count($objects) > 0)
      return $objects;
     return factory::build(get_called_class(), $data);
  }

	public function __call($name, $argument)
	{
		$arguments = implode(", ", $argument);
		$this->builder->$name($arguments);
		return $this->builder;
	}
	public function __get($key)
	{
		return $this->hasMany($key);
	}



}


?>