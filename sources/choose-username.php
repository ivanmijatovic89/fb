<?php
// ini_set('display_errors',1);
// ini_set('display_startup_errors',1);
// error_reporting(-1);






function PageMain() {
	global $TMPL, $LNG, $CONF, $db, $loggedIn, $settings;
	
	
	if(isset($_SESSION['username']) && isset($_SESSION['password']) || isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		
		$verify = $loggedIn->verify();

		if($verify['username']) {
			header("Location: ".$CONF['url']."/index.php?a=feed");
		}
	}







  
		

	if (isset($_POST['username']) AND (!empty($_POST['username'])) ) { //AND (!empty($_POST['choose-username']))
		$username = $_POST['username'];
		$provider_uid = $_SESSION['provider_uid'];
 
   


		
		$query = sprintf("SELECT * FROM `users` WHERE `username` = '%s' ", $db->real_escape_string($username));
		$result = $db->query($query);
		$count =    ($result->num_rows == 0) ? 0 : $result->num_rows;  
		
		$query_deactivated = sprintf("SELECT * FROM `users_deactivated` WHERE `username` = '%s' ", $db->real_escape_string($username));
		$result_deactivated = $db->query($query_deactivated);
		$count_deactivated =    ($result_deactivated->num_rows == 0) ? 0 : $result_deactivated->num_rows;  

		if(($count==0) AND ($count_deactivated ==0) ){
			// ako nema usera sa istim imenom u bazi
			if($db->query("UPDATE `users` SET `username` = '{$username}' WHERE `provider_uid` = '{$provider_uid}' ")){
				//echo ' uspesno ste update username ';
				$_SESSION['username'] = $username; // username
		        $_SESSION['password'] = md5($provider_uid);
		        // da obrise session;
				unset($_SESSION['provider_uid']);

		        $log = new logIn();
		        $log->db           = $db;
		        $log->url          = $CONF['url'];
		        $log->username     = $username;
		        $log->provider_uid = $provider_uid;
		        $log->password     = md5($provider_uid);
		        
	        	$TMPL['loginMsg'] = notificationBox('transparent', $LNG['error'], $log->socialIn(), 1);
			}

		}else{
			$TMPL['errors']= 'Username already exists !';
		}
	}else{
		$TMPL['errors']= 'You must type username ! ';
	}
	
	// Start displaying the home-page users
	
	$result = $db->query("SELECT * FROM `users` WHERE `image` != 'default.png' ORDER BY `idu` DESC LIMIT 10 ");
	while($row = $result->fetch_assoc()) {
		$users[] = $row;
	}
	
	$TMPL['rows'] = showUsers($users, $CONF['url']);
	
 	
	$TMPL['url'] = $CONF['url'];
	$TMPL['title'] = $LNG['welcome'].' - '.$settings['title'];
	
	$TMPL['ad'] = $settings['ad1'];
	
	$skin = new skin('welcome/choose-username');
	return $skin->make();
}
?>
