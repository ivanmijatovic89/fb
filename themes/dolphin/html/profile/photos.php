{$username}
<div class="photos-content" style="padding: 4%;">
	<h2>Photos</h2>

	<div id="my_photos"></div>
</div>

<script type="text/javascript">
	$('.photos-content').parent().css({ "width" : "100%" });

	var url = window.location.href.split('&');

	var user = url[1].split('=');

	$.post("/custom/ajax.php",{ action: 'get_photos', username: user[1] },function(data){
		$('#my_photos').html(data);
	});

</script>