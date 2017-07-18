<?php
$db = mysqli_connect('localhost', 'root', '', 'oop');


	$result = mysqli_query($db, "SELECT * FROM notifications WHERE status = 'new' ORDER BY id DESC");
	$data = mysqli_fetch($result);
	echo json_encode($data);


?>