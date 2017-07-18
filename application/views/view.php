<?php
class view
{

	public function render($viewname, $data=null, $otherdata=null)
	{
	
		if(strstr($_SERVER['REQUEST_URI'], "admin"))
		{
			require_once "admin/".$viewname;
		}
		else
		{
		require_once $viewname;
		}
}
}

?>