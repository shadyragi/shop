<?php

//session_start();
class validator
{
	private $rules = [];
	private $data = [];
    public $errors = [];
	public function validate($data = array(), $rules = array())
	{
		$this->data = $data;;
		$this->rules = $rules;
		$convertedRules = array();
		foreach ($this->data as $key => $value) {
			# code...
			if(array_key_exists($key, $this->rules))
			{
				$convertedRules = $this->convertData($this->rules[$key]);
				$this->processRules($key,  $this->data[$key], $convertedRules);

			}
		}
		if(count($this->errors) > 0)
		{
			return $this->errors;
		}
		
		
	}
	private function processRules($key, $data, $rules = array())
	{
		
		foreach ($rules as $rulekey => $rule) {
			# code...
			if(!strstr($rule, ":"))
			{
				

				$this->$rule($key, $data);
			}
			else {
					$varforconstructor     = substr($rule, strpos($rule, ":") + 1);
				if(strstr($varforconstructor, ","))
				{
					$varforconstructor = $this->makeparamtersarray($varforconstructor);
				}
					$rulename 			   = substr($rule, 0, strpos($rule, ":"));
					$this->$rulename($key, $data, $varforconstructor);
			}
		}
	}
	private function makeparamtersarray($string)
	{
		return explode(",", $string);
	}
	private function convertData($string)
	{
		return explode("|", $string);
	}
	public function required($key, $data)
	{
		if(!empty($data))
		{
			return true;
		}
		else
		{
			$this->errors[$key] = "$key must not be empty";

		}
	}
	public function notstartwithnumber($key, $data)
	{

		if(is_numeric($data[0]))
		{
			$this->errors[$key] = "$key must not start with number";
		}
	}
	public function min($key, $data, $min)
	{
		if(strlen($data) < $min)
		{
			 $this->errors[$key] = "$key must not be less than $min";
		}
	}
	public function max($key, $data, $max)
	{
		if(strlen($data) > $max)
		{
			$this->error[$key] = "$key must not be greater than $max";
		}
	}
	public function alpha($key, $data)
	{
		$pattern = '/^[A-Za-z]+$/';
		$matches = [];
		if(!preg_match($pattern, $data, $matches))
		{
			$this->error[$key] = "$key must contain letters only";
		}
	}
	public function word($key, $data)
	{
		$pattern = '/^[\w ]+$/';
		$matches = [];
		if(!preg_match($pattern, $data))
		{
			$this->errors[$key] = "$key must contain numbers, letters or underscore";
		}
	}
	public function alpha_num($key, $data)
	{
		$pattern = '/^[A-Za-z0-9]+$/';
		if(!preg_match($pattern, $data))
		{
			$this->errors[$key] = "$key must contain letters and numbers only";
		}
	}
	public function integer($key, $data)
	{
		if(!is_numeric($data))
		{
			$this->errors[$key] = "$key must be integer only";
		}
	}
	public function numeric($key, $data)
	{
		if(!is_numeric($data))
		{
			$this->errors[$key] = "$key must be numeric only";
		}
	}
	public function ip($key, $data)
	{
		if(!filter_var($data, FILTER_VALIDATE_IP))
		{
			$this->errors[$key] = "$key must be valid ip address";
		}
	}
	public function email($key, $data)
	{
		if(!filter_var($data, FILTER_VALIDATE_EMAIL))
		{
			$this->errors[$key] = "$key must be valid email address";
		}
	}
	public function between($key, $data, $paramters = array())
	{
		$this->min($data, $paramters[0]);
		$this->max($data, $paramters[1]);
	}
	public function mimes($key, $data, $paramters = array())
	{
		$pattern = "";
		$string  = "";
		$counter = 0;
		
		for($x = 0; $x < sizeof($paramters); ++$x)
		{
			if($counter != sizeof($paramters) - 1)
			{
			$string .= "\.".$paramters[$x]."|";
		}
		else
		{
			$string .= "\.".$paramters[$x];
		}
		++$counter;
	}
		$pattern = '/.+(' . $string .')/';
		if(!preg_match($pattern, $data))
		{
			$this->errors[$key] = "$key must be on of these types (" . implode(", ", $paramters) . " )"; 
		}
	

	}
	public function requiredwith($key, $data, $fieldname)
	{

		if(!empty($this->data[$key]) AND isset($this->indata[$key]))
		{

		foreach ($fieldname as $secondkey => $value) {
			# code...
			if(empty($this->data[$value]) || !isset($this->data[$value]))
		{
			$this->errors[$value] = "$value must be present";
		}
		}
	}
	}
	public function requiredwithout($key, $data, $fieldname)
	{
		if(!empty($this->data[$fieldname]))
		{
			$this->errors[$key] = "$fieldname must not be present";
		}
	}
	public function simplepwd($key, $data)
	{
		$pattern = '/^[A-Za-z]+$/';
		$matches = array();
		if(!preg_match($pattern, $data, $matches))
		{
			$this->errors[$key] = "$key must contain letters only";
		}
	}
	public function pwdwithnum($key, $data)
	{
		$pattern = '/^(?=.*[A-Za-z])(?=.*[0-9])\w+$/';
		$matches = [];
		if(!preg_match($pattern, $data, $matches))
		{
			$this->errors[$key] = "$key must contain letters and numbers only";
		}
	}
	public function complexpwd($key, $data)
	{
		$pattern = '/^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[[:punct:]])\S{7,}$/';
		if(!preg_match($pattern, $data))
		{
			$this->errors[$key] = "$key must contain letters, numbers and symbols";
		}
	}
	public function unique($key, $data, $tableinfo = [])
	{
		$tablename = $tableinfo[0];
		$columnname = $tableinfo[1];
		$builder   = new builder();
		$result = $builder->table($tablename)->where($columnname, "=", $data)->get();
		if(!empty($result))
		{
			$this->errors[$key] = "$key is not unique in the database";
		}
	}
	public function exists($key, $data, $tableinfo = [])
	{

		$tablename = $tableinfo[0];
		$columnname = $tableinfo[1];
		$builder   = new builder();
		$result = $builder->table($tablename)->where($columnname, "=", $data)->get();
		if(empty($result))
		{
			$this->errors[$key] = "$key does not exist in the database";
		}
	}
	public function In($key, $data, $values = [])
	{
		if(!in_array($data, $values))
		{
			die("error in IN rule");
		}
	}
	public function withoutspace($key, $data)
	{
		$pattern = '/\s+/';
		if(preg_match($pattern, $data))
		{
			$this->errors[$key] = "$key must not contain spaces";
		}
	}
	public function image($key, $data)
	{
		$extensions = ["jpeg", "jpg", "gif", "svg"];
		$this->mimes($data, $extensions);
	}
	public function boolean($key, $data)
	{
		$fields = ["on", true, TRUE, 1];
		$this->In($data, $fields);
	}
	public function confirmed($key, $data, $fieldname)
	{
		if($data != $this->data[$fieldname])
		{
			$this->errors[$key] = "That field must be confirmed with $fieldname";
		}
	}
	public function different($key, $data, $fieldname)
	{
		if($data == $this->data[$fieldname])
		{
			die("error in different rule");
		}
	}
}

?>