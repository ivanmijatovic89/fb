<?php
	session_start();

	include("models/user_model.php");

	call_user_func($_POST['action']);

	function get_photos(){
		$user_model = new User_model();

		global $get_photos;
		global $get_all_album_photos;
		global $get_albums;
		global $get_img;
		global $username;
		global $uid;
		global $uri;

		$uri = $_POST['uri'];

		$username = $_POST['username'];
		$get_id = $user_model->get_id_by_username($username);
		$uid = $get_id[0];

		$get_photos = $user_model->get_photos($uid);
		$get_all_album_photos = $user_model->get_all_album_photos($uid);
		$get_albums = $user_model->get_albums($uid);		
		$get_timeline_photos = $user_model->get_timeline_photos($uid);		

		include('views/get_photos.php');
		
	}

	function open_album(){
		$user_model = new User_model();

		global $get_album_photos;
		global $username;
		global $uid;
		global $if_timeline;
		global $get_album;

		$username = $_POST['username'];
		$get_id = $user_model->get_id_by_username($username);
		$uid = $get_id[0];

		$get_album = $user_model->get_album($_POST['id']);

		if($_POST['id'] != 0){
			$get_album_photos = $user_model->get_album_photos($_POST['id'], $uid);
			$if_timeline = 0;
		}else{
			$get_album_photos = $user_model->get_timeline_photos($uid);
			$if_timeline = 1;
		}
		

		include('views/open_album.php');
	}

	function post_photos(){
		$user_model = new User_model();

		$username = $_POST['username'];
		$get_id = $user_model->get_id_by_username($username);
		$uid = $get_id[0];

		$imgs = $_POST['imgs'];
		$name = $_POST['name'];

		if($name == ""){
			$name = "Untitled Album";
		}

		$description = $_POST['desc'];
		$tags = "";
		$public = 1;

		$album_id = $user_model->create_album($uid, $name, $tags, $description);

		$pictures = "";

		foreach($imgs as $img){
			$name = $user_model->save_image($img[0]);

			$pictures .= $name.',';

			$user_model->add_photo($uid, $album_id, $name, $img[2], $img[1]);
		}

		$pictures = substr($pictures, 0, -1);

		//post added images
		$user_model->post_album($uid, $album_id, $pictures, $public, $description);
	}

	function add_photos(){
		$user_model = new User_model();

		$username = $_POST['username'];
		$get_id = $user_model->get_id_by_username($username);
		$uid = $get_id[0];

		$imgs = $_POST['imgs'];
		$name = $_POST['name'];

		if($name == ""){
			$name = "Untitled Album";
		}

		$description = $_POST['desc'];
		$tags = "";
		$location = "";
		$public = 1;

		$album_id = $_POST['album_id'];

		$pictures = "";

		foreach($imgs as $img){
			$name = $user_model->save_image($img[0]);

			$pictures .= $name.',';

			$user_model->add_photo($uid, $album_id, $name,  $img[2], $img[1]);
		}

		$pictures = substr($pictures, 0, -1);

		//post added images
		$user_model->post_album($uid, $album_id, $pictures, $public, $description);
	}

	function delete_photo(){
		$user_model = new User_model();

		$username = $_POST['username'];
		$get_id = $user_model->get_id_by_username($username);
		$uid = $get_id[0];

		print $user_model->delete_photo($_POST['id'], $_POST['value'], $uid);

	}

	function delete_album(){
		$user_model = new User_model();

		$username = $_POST['username'];
		$get_id = $user_model->get_id_by_username($username);
		$uid = $get_id[0];

		$user_model->delete_album($_POST['id'], $uid);

		$user_model->delete_album_images($_POST['id'], $uid);

		
	}

?>