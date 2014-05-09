<?php
	session_start();

	include("models/user_model.php");

	$user_model = new User_model();

	$username = $_SESSION['username'];
	$get_id = $user_model->get_id_by_username($username);
	$uid = $get_id[0];

	$friends = $user_model->get_friends($uid);

	print json_encode($friends);

?>