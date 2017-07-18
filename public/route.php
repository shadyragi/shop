<?php

class route
{
	private $route;
	private $file;
	public function __construct()
	{
		$this->file = fopen(".htaccess", "w+");
		fputs($this->file, "Options -MultiViews\n
RewriteEngine ON

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f\n
							");
	}
	public function post($route, $controllerandmethod)
	{
		
			$rule = $this->rewrite($route, $controllerandmethod);
        
			fputs($this->file, "\nRewriteCond %{REQUEST_METHOD} POST");

			fputs($this->file, $rule);

	}
	private function rewrite($route, $controllerandmethod)
	{
		$this->route = explode("/",$route);
		print_r($this->route);
		$controller  = substr($controllerandmethod, 0, strpos($controllerandmethod, ":"));
		$method      = substr($controllerandmethod, strpos($controllerandmethod, ":") + 1);
		$params      = [];
		//$file        = fopen(".htaccess", "a+");
        $rule        = "\nRewriteRule ";
        $capturecounter = 1;
        $counter     = 0;
		 for($x = 0; $x < count($this->route); ++$x)
		 {
		 	if($counter == 0)
		 	{
		 		$rule .= "^(";
		 	}
		 
		 	if(strstr($this->route[$x], "{"))
		 	{
		 		++$capturecounter;
		 		$pattern = '';
		 		$type = substr($this->route[$x], strpos($this->route[$x], ":") + 1);
		 		$type = substr($type, 0, strpos($type, "}"));
		 		echo $type;
		 		if($type == "int")
		 		{
		 			$pattern = "[0-9]+";
		 		}
		 		elseif($type == "alpha")
		 		{
		 			$pattern = "[A-z]+";
		 		}
		 		elseif($type == "alphanum")
		 		{
		 			$pattern = "[A-z0-9]+";
		 		}
		 		elseif ($type == "symbol") {
		 			# code...
		 			$pattern = "[[:punct:]]+";
		 		}
		 		elseif($type == "any")
		 		{
		 			$pattern = ".+";
		 		}
		 		else
		 		{
		 			echo "not found";
		 		}
		 	    if($counter != count($this->route) - 1)
		 		$rule .= "($pattern)/";
		 	    else
		 	    $rule .= "($pattern)";
		 		
		 	}
		 	else
		 	{
		 		if($counter != count($this->route) - 1)
		 		$rule .= $this->route[$x] . "/";
		 	    else
		 	    $rule .= $this->route[$x];
		 	}
		 		if($counter == count($this->route) - 1)
		 	{
		 		$rule .= ")$ main.php?url=$1/controller/$controller/method/$method";
		 	}
		 	
		 	++$counter;
		 }

		  if($capturecounter > 2)
		  {
		  	$rule .= "/params/";
		  	echo $capturecounter;
		  	for($x = 2; $x <= $capturecounter; ++$x)
		  	{
		  		if($x == (count($capturecounter)))
		  		$rule .= "\$$x";
		  		else
		  		$rule .= "\$$x/";
		  	}
		  }
		  elseif ($capturecounter == 2) {
		  	# code...
		  	$rule .= "/params/\$2"; 
		  }
		  

		  return $rule;
		
		 /*fputs($file, $rule);
		fclose($file);*/
	}
	public function get($route, $controllerandmethod)
	{
		
			$rule = $this->rewrite($route, $controllerandmethod);
        
			fputs($this->file, "\nRewriteCond %{REQUEST_METHOD} GET");

			fputs($this->file, $rule);
			
		

	}
	public function put($route, $controllerandmethod)
	{
			$rule = $this->rewrite($route, $controllerandmethod);
        
			fputs($this->file, "\nRewriteCond %{REQUEST_METHOD} PUT");

			fputs($this->file, $rule);
	}
	public function delete($route, $controllerandmethod)
	{
			$rule = $this->rewrite($route, $controllerandmethod);
        
			fputs($this->file, "\nRewriteCond %{REQUEST_METHOD} DELETE");

			fputs($this->file, $rule);
	
}
}
?>