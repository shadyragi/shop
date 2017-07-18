<?php
session_start();
class notificationscontroller extends controller
{
	public $notifications;
	
	public function getnotifications()
	{
		$notification = new notification();
		$this->notifications = $notification->findkey("user_id", $_SESSION['user']);
		$_SESSION['notifications'] = $this->notifications;
		$otherdata['loggedin'] = isset($_SESSION['user']) ? $_SESSION['user'] : false;
		if(!$_SESSION['user'])
		{
			header("Location: http://localhost/shop/public/login");
		}
		
		return $this->view->render("notifications.php", $this->notifications, $otherdata);
	}
	public function deletenotification()
	{
		$notification = (new notification)->find($_POST['id']);
		$message      = "Notification has been deleted successfully";
		if($notification->delete())
		{
			
			header("Location: http://localhost/shop/public/notifications");
		}
		else
		{
			die("error in deleting the notification");
		}
	}
}

?>