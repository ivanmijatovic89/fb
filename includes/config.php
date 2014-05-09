<?php


// ini_set('display_errors',1);
// ini_set('display_startup_errors',1);
// error_reporting(-1);
error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);

$CONF = $TMPL = array();

// The MySQL credentials
$CONF['host'] = 'localhost';
$CONF['user'] = 'root';
$CONF['pass'] = '';
$CONF['name'] = 'facebookkiller';

// The Installation URL
$CONF['url'] = 'http://fb.killer';

// The Notifications e-mail
$CONF['email'] = 'stefan.stex@yahoo.com';

// The themes directory
$CONF['theme_path'] = 'themes';

$action = array('admin'			=> 'admin',
				'feed'			=> 'feed',
				'settings'		=> 'settings',
				'messages'		=> 'messages',
				'post'			=> 'post',
				'recover'		=> 'recover',
				'timeline'		=> 'timeline',
				'profile'		=> 'profile',
				'notifications'	=> 'notifications',
				'search'		=> 'search',
				'page'			=> 'page'
				);
?>