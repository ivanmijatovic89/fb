<div>
	<span><a href="javascript:void(0);" id="show_your_photos" class="show_img">Your photos</a></span>
	<span><a href="javascript:void(0);" id="show_albums" class="show_img">Albums</a></span>
	<br/>

	<div id="your_photos">
	<?php
		//ALL YOUR PICTURES
		foreach($get_photos as $photo){
			echo '<div class="my-img" id="post'.$photo['id'].'">';				
				echo '<a href="javascript:void(0);" id="'.$photo['value'].'" onclick="gallery('."'".$photo['value']."'".','."'".$uid."'".', '."'media'".')" style="width:200px;float:left;margin:5px;">';
					echo '<img src="thumb.php?src='.$photo['value'].'&w=200&h=200&t=m" alt="">';					
				echo '</a>';
				if($_SESSION['username'] == $username){
					echo '<div class="edit-img">';
						echo '<img src="/custom/imgs/delete-img.png" class="delete-img" onclick="delete_post('.$photo['id'].');">';
					echo '</div>';
				}
			echo '</div>';
		}

		foreach($get_all_album_photos as $photo){
			echo '<div class="my-img" id="img'.$photo['id'].'">';
				echo '<a href="javascript:void(0);" id="'.$photo['value'].'" class="my-img" onclick="gallery('."'".$photo['value']."'".','."'".$uid."'".', '."'media'".')" style="width:200px;float:left;margin:5px;z-index:99;">';
					echo '<img src="thumb.php?src='.$photo['value'].'&w=200&h=200&t=m" alt="">';				
				echo '</a>';
				if($_SESSION['username'] == $username){
					echo '<div class="edit-img">';
						echo '<img src="/custom/imgs/delete-img.png" class="delete-img" onclick="delete_img('.$photo['id'].','."'".$photo['value']."'".','."'".$_SESSION['username']."'".');">';
					echo '</div>';
				}
			echo '</div>';
		}


	?>
	</div>

	<div id="albums">
	<?php
		//IF IS ME, SHOW CREATE ALBUM BOX
		if($_SESSION['username'] == $username){
			echo '<a href="'.$uri.'#modal" onclick="forward_album_info(0,0,'."'create_album'".',0);">';
				echo '<span style="width:198px;height:198px;border:1px dashed silver;float:left;margin:5px;text-align:center;">';
					echo '<br/><br/><br/><br/>Create Album';
				echo '</span>';
			echo '</a>';
		}

		//TIMELINE ALBUM (AT FIRST PLACE IF NOT EMPTY)
		if(!empty($get_timeline_photos)){
			echo '<div style="width:200px;float:left;margin:5px;">';
				echo '<a href="javascript:void(0);" onclick="open_album(0);"><img src="thumb.php?src='.$get_timeline_photos[0]['value'].'&w=200&h=200&t=m" alt=""><br/>Timeline Photos</a>';
			echo '</div>';
		}

		//OTHER ALBUMS
		foreach($get_albums as $album){		
			echo '<div class="my-img" id="album'.$album['aid'].'">';
				echo '<div style="width:200px;float:left;margin:5px;">';
					echo '<a href="javascript:void(0);" onclick="open_album('.$album['aid'].')"><img src="thumb.php?src='.$album['img'].'&w=200&h=200&t=m" alt=""><br/>'.$album['name'].'</a>';
				echo '</div>';			
			if($_SESSION['username'] == $username){
				echo '<div class="edit-img">';
					echo '<img src="/custom/imgs/delete-img.png" class="delete-img" onclick="delete_album('.$album['aid'].');">';
				echo '</div>';
			}
			echo '</div>';
		}
	?>
	</div>

</div>

<div id="open_album"></div>

<script type="text/javascript">
	//SHOW / HIDE PHOTOS AND ALBUMS
	$('#albums').hide();

	$('.show_img').click(function(){
		var id = $(this).attr('id');

		if(id == "show_your_photos"){
			$('#albums').hide();
			$('#your_photos').show();	
			$('#open_album').hide();	

		}

		if(id == "show_albums"){
			$('#your_photos').hide();	
			$('#albums').show();
			$('#open_album').hide();					
		}
	});
</script>
