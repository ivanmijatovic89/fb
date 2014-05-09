<?php

	include("../includes/config.php");	

	class User_model{
		private $db;

		function __construct() {

			//$this->db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
			$this->db = new mysqli('localhost', 'root', '', 'facebookkiller');
			if ($this->db->connect_errno) {
			    echo "Failed to connect to MySQL: (" . $this->db->connect_errno . ") " . $this->db->connect_error;
			}
	   	}

	   	function fetchArray($query) {
		
			$result = $this->db->query($query);

			// Define an array to store the results
			$columns = array();
			
			// Fetch the results set
			while ($row = $result->fetch_array()) {
				// Store the result into array
				$columns[] = $row;
			}
			
			// Return the array;
			return $columns;
		}

	   	function get_photos($uid){
	   		$query = sprintf("SELECT m.id,m.uid,m.message,m.value FROM messages m WHERE type='%s' AND uid=%d","picture", $uid);

	   		return $this->fetchArray($query);
	   	}

	   	function get_all_album_photos($uid){
	   		$query = sprintf("SELECT a.id,a.value FROM album_photos a WHERE a.uid='%s'", $uid);

	   		return $this->fetchArray($query);
	   	}

	   	function get_albums($uid){
	   		$query = sprintf("SELECT a.id as aid,a.name FROM albums a WHERE a.uid=%d", $uid);

	   		$result = $this->db->query($query);

			$columns = array();

			while ($row = $result->fetch_array()) {
				$album_img = $this->get_img_for_album($row['aid']);

				if(!empty($album_img)){
					$img = $album_img[0];
				}else{
					$img = 'default_album.png';
				}	

				$row['img'] = $img;	
				$columns[] = $row;
			}
			
			return $columns;
	   		
	   	}

	   	function get_album($aid){
	   		$query = sprintf("SELECT * FROM albums a WHERE a.id=%d", $aid);

	   		$result = $this->db->query($query);

			return $result->fetch_row();
	   	}

	   	function get_timeline_photos($uid){
	   		$query = sprintf("SELECT m.id,m.value FROM messages m WHERE m.type='picture' AND parent_id=0 AND m.uid=%d", $uid);

	   		return $this->fetchArray($query);
	   	}

	   	function get_album_photos($aid, $uid){
	   		$query = sprintf("SELECT a.id,a.value FROM album_photos a WHERE a.album_id=%d AND a.uid=%d", $aid, $uid);

	   		return $this->fetchArray($query);
	   	}

	   	function get_img_for_album($aid){
	   		$query = sprintf("SELECT a.value FROM album_photos a WHERE a.album_id=%d LIMIT 1", $aid);

	   		$result = $this->db->query($query);

			return $result->fetch_row();
	   	}

	   	function get_id_by_username($username){
	   		$query = sprintf("SELECT u.idu FROM users u WHERE u.username='%s'", $username);

	   		$result = $this->db->query($query);

			return $result->fetch_row();
	   	}

	   	function get_user($id){
	   		$query = sprintf("SELECT u.username FROM users u WHERE u.idu='%s'", $id);

	   		$result = $this->db->query($query);

			return $result->fetch_row();
	   	}

	   	function create_album($uid, $name, $tags, $description){
	   		$query = sprintf("INSERT INTO `albums` (`uid`, `name`, `tags`, `description`, `date`) VALUES ('%s', '%s', '%s', '%s', '%s')", $uid, $name, $tags, $description, time());

	   		$result = $this->db->query($query);

	   		return $this->db->insert_id; 
	   	}

	   	function add_photo($uid, $album_id, $value, $tags, $location){
	   		$tags = explode(",", $tags);

	   		$tag_users = array();

	   		foreach($tags as $id){
	   			$tag_users[] = $this->get_user($id)[0];
	   		}

	   		$query = sprintf("INSERT INTO `album_photos` (`uid`, `album_id`, `value`, `tags`, `location`, `likes`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $uid, $album_id, $value, serialize($tag_users), $location, 0);

	   		return $this->db->query($query);

	   	}

	   	function post_album($uid, $parent_id, $value, $public, $description){
	   		$query = sprintf("INSERT INTO `messages` (`uid`, `message`, `tag`, `type`, `parent_id`, `value`, `time`, `public`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', CURRENT_TIMESTAMP, '%s')", $uid, $description, '', 'album', $parent_id, $value, $public);

	   		return $this->db->query($query);

	   	}

	   	function delete_photo($id, $value, $uid){
	   		$stmt = $this->db->prepare("DELETE FROM `album_photos` WHERE `id` = '{$this->db->real_escape_string($id)}'");

	   		if($stmt->execute()){
	   			define('UPLOAD_DIR', '../uploads/media/');
	   			unlink(UPLOAD_DIR.$value);

	   			$check_post = $this->check_image_name_from_post($uid,$value);

	   			if(!empty($check_post)){

	   				foreach ($check_post as $val) {
	   					$val_exp = explode(',', $val['value']);

	   					foreach ($val_exp as $key => $ve) {
	   						if($ve == $value){
	   							unset($val_exp[$key]);
	   						}
	   					}

	   					$impl = implode(',', $val_exp);

	   					$this->remove_image_name_from_post($val['id'], $impl);

	   				}

	   			}

	   			return 1;
	   		}else{
	   			return 0;
	   		}
	   	}

	   	function delete_album($aid, $uid){
	   		$stmt = $this->db->prepare("DELETE FROM `albums` WHERE `id` = '{$this->db->real_escape_string($aid)}' AND `uid` = '{$this->db->real_escape_string($uid)}'");

	   		return $stmt->execute();
	   	}

	   	function delete_album_images($aid, $uid){
	   		$query = sprintf("SELECT a.id,a.value FROM album_photos a WHERE a.album_id=%d AND a.uid=%d", $aid, $uid);

	   		$result = $this->fetchArray($query);

	   		foreach($result as $img){
	   			$this->delete_photo($img['id'], $img['value'], $uid);
	   		}


	   	}

	   	function remove_image_name_from_post($id, $value){
	   		$stmt = $this->db->prepare("UPDATE `messages` SET `value` = '{$this->db->real_escape_string($value)}' WHERE `id` = '{$this->db->real_escape_string($id)}'");		
			// Execute the statement
			return $stmt->execute();
	   	}

	   	function check_image_name_from_post($uid,$name){
	   		$query = "SELECT m.id,m.value FROM messages m WHERE m.uid=".$uid." AND m.value LIKE '%".$name."%'";

	   		return $this->fetchArray($query);
	   	}

	   	function save_image($image){
			define('UPLOAD_DIR', '../uploads/media/');

			$img = explode(',', $image);

			//$str = 'data:image/jpeg;base64';

			$ext1 = explode('/', $img[0]);

			$ext2 = explode(';', $ext1[1]);

			$ext = $ext2[0];

			if(substr($img[0],0,10) == 'data:image'){

				$img = str_replace(' ', '+', $img[1]);
				$data = base64_decode($img);
				$name = md5(uniqid());
				$file = UPLOAD_DIR . $name . '.'. $ext;

				$success = file_put_contents($file, $data);
				    
				if($success){
					return $name . '.'. $ext;
				}else{
					return 0;
				}

			}
	    }

	    function get_friends($id){
	    	$query = sprintf("SELECT username as name, idu as id FROM `relations`, `users` WHERE `relations`.`leader` = '%s' AND `relations`.`subscriber` = `users`.`idu` $start ORDER BY `relations`.`id` DESC $limit", $this->db->real_escape_string($id));

	    	$result = $this->db->query($query);

			while($row = $result->fetch_assoc()) {
				$array [] = $row;
			}
			return $array;
	    }
	   	

	}
?>