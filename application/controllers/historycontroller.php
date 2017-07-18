<?php

class historycontroller extends controller
{
	public function gethistory()
	{
		$history = (new history)->findKey("user_id", $_SESSION['user']);
		$history = array_reverse($history);
		$otherdata['loggedin'] = isset($_SESSION['user']) ? $_SESSION['user'] : false;
		if(!$_SESSION['user'])
		{
			header("Location: http://localhost/shop/public/login");
		}
		$this->view->render("history.php", $history, $otherdata);

	}
	public function deletehistory($id)
	{
		$history = (new history)->find($id);
		if($history->delete())
		{
			header("Location: " . $_SERVER['HTTP_REFERER']);
		}
	}
}

?>