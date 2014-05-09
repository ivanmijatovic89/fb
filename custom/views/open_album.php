<?php if(!$if_timeline){ ?>
<a href="#modal" onclick="forward_album_info('<?=$get_album[2]?>','<?=$get_album[4]?>','add_photos','<?=$get_album[0]?>');" class="add_photos" style="float:right;">Add Photos</a><br/>
<?php } ?>

<?php
	foreach($get_album_photos as $photo){
		if(!$if_timeline){
			echo '<div class="my-img" id="img'.$photo['id'].'">';
		}else{
			echo '<div class="my-img" id="post'.$photo['id'].'">';	
		}		
			echo '<a href="javascript:void(0);" id="'.$photo['value'].'" onclick="gallery('."'".$photo['value']."'".','."'".$uid."'".', '."'media'".')" style="width:200px;float:left;margin:5px;">';
				echo '<img src="thumb.php?src='.$photo['value'].'&w=200&h=200&t=m" alt="">';
			echo '</a>';
			if($_SESSION['username'] == $username){
				if(!$if_timeline){
					echo '<div class="edit-img">';
						echo '<img src="/custom/imgs/delete-img.png" class="delete-img" onclick="delete_img('.$photo['id'].','."'".$photo['value']."'".','."'".$_SESSION['username']."'".'),remove_this('.$photo['id'].');">';
					echo '</div>';
				}else{
					echo '<div class="edit-img">';
						echo '<img src="/custom/imgs/delete-img.png" class="delete-img" onclick="delete_post('.$photo['id'].'),remove_this('.$photo['id'].');">';
					echo '</div>';
				}
			}
		echo '</div>';
	}
?>

<script type="text/javascript">
	function remove_this(id){
		$('#img'+id).remove();
		$('#post'+id).remove();
	}
</script>