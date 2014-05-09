<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
function PageMain() {
	global $TMPL, $LNG, $CONF, $db, $loggedIn, $settings;
	
	if($settings['captcha']) {
		$TMPL['captcha'] = '<input type="text" name="captcha" placeholder="Captcha" />
		<span class="welcome-captcha"><img src="'.$CONF['url'].'/includes/captcha.php" /></span>';
	}
	
	if(isset($_GET['acc'])){
		$TMPL['deactivated']=  'Your account have been deactivated, if you wanna activate your account log again !';
	}


	if(isset($_POST['invitation'])){
		if (isset($_POST['email_address']) AND (!empty($_POST['email_address'])) ) { 
				
				if (filter_var($_POST['email_address'], FILTER_VALIDATE_EMAIL)) {


				    	include('./includes/class.phpmailer.php');
						$sve  = " Your friend with email ".$_POST['email_address']. " invite you to join website ";
						$mail             = new PHPMailer(); 
						$mail->AddReplyTo("name@yourdomain.com","First Last");
						$mail->SetFrom("name@yourdomain.com","Xavier Johnson");
						$mail->AddReplyTo("name@yourdomain.com","First Last");

						$address = $_POST['email_address'];

						$mail->AddAddress($address, "Xavier Johnson");
						$mail->Subject    = "Invitation for networkingout.com";
						$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
						$mail->MsgHTML($sve);
						if(!$mail->Send()) {
							$TMPL["email"] =  "Email invitation Error: " . $mail->ErrorInfo;
						} else {
							$TMPL["email"] =  "Email invitation sent!";
							
						}
				}else{
					$TMPL['invitation'] = 'Email address is invalid';
				}

			

		}else{
			$TMPL['invitation'] = 'You did not type email address !';
		}
	}



	if(isset($_POST['register'])) {
		// Register usage
		$reg = new register();
		$reg->db = $db;
		$reg->url = $CONF['url'];
		$reg->username = $_POST['username'];
		$reg->password = $_POST['password'];
		$reg->email = $_POST['email'];
		$reg->born  = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];//$_POST['born'];
		$reg->captcha = $_POST['captcha'];
		$reg->captcha_on = $settings['captcha'];
		$reg->message_privacy = $settings['mprivacy'];
		$reg->like_notification = $settings['notificationl'];
		$reg->comment_notification = $settings['notificationc'];
		$reg->shared_notification = $settings['notifications'];
		$reg->chat_notification = $settings['notificationd'];
		$reg->friend_notification = $settings['notificationf'];
		$reg->verified = $settings['verified'];
		$reg->email_like = $settings['email_like'];
		$reg->email_comment = $settings['email_comment'];
		$reg->email_new_friend = $settings['email_new_friend'];
		
		$TMPL['registerMsg'] = $reg->process();

		if($TMPL['registerMsg'] == 1) {
			if($settings['mail']) {
				sendMail($_POST['email'], sprintf($LNG['welcome_mail'], $settings['title']), sprintf($LNG['user_created'], $settings['title'], $_POST['username'], $_POST['password'], $CONF['url'], $settings['title']), $CONF['email']);
			}
			header("Location: ".$CONF['url']."/index.php?a=feed");
		}
	}
	
	if(isset($_POST['login'])) {
		// Log-in usage
		$log = new logIn();
		$log->db = $db;
		$log->url = $CONF['url'];
		$log->username = $_POST['username'];
		$log->password = $_POST['password'];
		if(isset($_POST['remember'])){
			$remember = 1;
		}else{
			$remember = 0;
		}
		$log->remember = $remember;
		
		$TMPL['loginMsg'] = notificationBox('transparent', $LNG['error'], $log->in(), 1);
	}
	
	if(isset($_SESSION['username']) && isset($_SESSION['password']) || isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		

		$verify = $loggedIn->verify();

		if($verify['username']) {
			header("Location: ".$CONF['url']."/index.php?a=feed");
		}
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
	
	$skin = new skin('welcome/content');
	
	return $skin->make();

}
?>