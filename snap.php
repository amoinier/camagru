<?php include('header.php');
if ($_SESSION['login']) {?>
		<script type="text/javascript" src="js/webcam.js"></script>
		<div id="floating_button" class="floating_button">+</div>
		<div id="snap_win" class="snap_win">
			<video id="video" width="640" height="480" autoplay></video>
			<button id="snap">Snap Photo</button>
			<button id="save">Save Photo</button>
			<canvas id="canvas" width="640" height="480"></canvas>
			<script type="text/javascript">
			</script>
		</div>
<?php }
else {
	?>
	<meta http-equiv="refresh" content='0;URL=index.php'/>
	<?php
}
include('footer.php'); ?>
