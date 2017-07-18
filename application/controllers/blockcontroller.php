<?php

class blockcontroller extends controller
{
 	  public function check()
 	  {
 	  	$ip    = $_SERVER['REMOTE_ADDR'];
 	  	$blocked = (new blocked)->findkey("blocked_ip", $ip);
 	  	if($blocked)
 	  	{
 	  		die("you are blocked");
 	  	}
 	  	else
 	  	{
 	  		
 	  		header("Location: http://localhost/" . $_SERVER['REQUEST_URI'] );
 	  	}
 	  }
}

?>