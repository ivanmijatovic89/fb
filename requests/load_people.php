﻿<?php
include("../includes/config.php");
include("../includes/classes.php");
require_once(getLanguage(null, (!empty($_GET['lang']) ? $_GET['lang'] : $_COOKIE['lang']), 2));
session_start();
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");

$resultSettings = $db->query(getSettings()); 
$settings = $resultSettings->fetch_assoc();

// The theme complete url
$CONF['theme_url'] = $CONF['theme_path'].'/'.$settings['theme'];

if(isset($_POST['start']) && isset($_POST['q']) && ctype_digit($_POST['start'])) {
	$feed = new feed();
	$feed->db = $db;
	$feed->url = $CONF['url'];
	if(isset($_SESSION['username']) && isset($_SESSION['password']) || isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		$loggedIn = new loggedIn();
		$loggedIn->db = $db;
		$loggedIn->url = $CONF['url'];
		$loggedIn->username = (isset($_SESSION['username'])) ? $_SESSION['username'] : $_COOKIE['username'];
		$loggedIn->password = (isset($_SESSION['password'])) ? $_SESSION['password'] : $_COOKIE['password'];
		
		$verify = $loggedIn->verify();
		
		
		$feed->username = $verify['username'];
		$feed->id = $verify['idu'];
		$feed->online_time = $settings['conline'];
		
		if(!empty($_POST['list'])) {
			echo $feed->onlineUsers(2, $_POST['q']);
			return;
		}
	}
	$feed->per_page = $settings['perpage'];
	$feed->c_per_page = $settings['cperpage'];
	$feed->c_start = 0;
	$feed->profile = $_POST['profile'];
	$feed->profile_data = $feed->profileData(null, $_POST['id']);
	$feed->s_per_page = $settings['sperpage'];
	$feed->subsList = $feed->getSubs($feed->profile_data['idu'], $_POST['type'], $_POST['start']);
	
	if($_POST['live']) {
		echo $feed->getSearch(0, 5, $_POST['q'], null, 1);
	} else {
		echo $feed->getSearch($_POST['start'], $settings['qperpage'], $_POST['q'], $_POST['filter']);
	}
}
?>