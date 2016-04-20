<?php include('header.php');
include('config/access.php');
if ($_SESSION['login']) {?>
	<script type="text/javascript" src="js/webcam.js"></script>
	<div class="container">
		<div id=snap_left>
			<div id="snap_win" class="snap_win">
				<video id="video" width="640" height="480" autoplay></video>
				<canvas id="canvas" width="640" height="480"></canvas>
			</div>
			<button id="snap">Snap Photo</button>
			<button id="save">Save Photo</button>
		</div>
		<div id='snap_right'>
		<?php
		if ($_POST['sub'] === 'save' && $_POST['img']) {
			$bdd->query('INSERT INTO snap (`login`, `img`) VALUES ("'.$_SESSION['login'].'", "'.$_POST['img'].'");');
			?><script type="text/javascript">auto_refresh();</script><?php
		}
			$log = $bdd->query("SELECT * FROM snap WHERE `login` LIKE '".$_SESSION['login']."' ORDER BY `id` DESC;");
			$result = $log->fetchAll();
			foreach ($result as $key => $val) {
			?>
				<div><img class='min' src="<?php echo $val['img'];?>"/></div>
			<?php
			}
		?>
		</div>
		<div class="clear"></div>
	</div>
<?php }
else {
	?>
	<meta http-equiv="refresh" content='0;URL=index.php'/>
	<?php
}
include('footer.php'); ?>
