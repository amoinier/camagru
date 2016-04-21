<?php include('header.php');
date_default_timezone_set('Europe/Paris');
include('config/access.php');
include('base64.php');

if ($_SESSION['login']) {?>
	<script type="text/javascript" src="js/webcam.js"></script>
	<div class="container">
		<div id=snap_left>
			<div id="snap_win" class="snap_win">
				<div id="select-filter">
					<select id="filterid">
						<option value="face.png">Face</option>
						<option value="cat.png">Cat</option>
						<option value="42.png">42 Logo</option>
						<option value="hair.png">Hair</option>
					</select>
				</div>
				<video id="video" width="640" height="480" autoplay></video>
				<canvas id="canvas" width="640" height="480"></canvas>
			</div>
			<button id="snapbut">Snap Photo</button>
			<button id="savebut">Save Photo</button>
		</div>
		<?php
		if ($_POST['sub'] === 'save' && $_POST['img']) {
			base64_to_png($_POST['img'], 'resources/rendu.png');
			$source = imagecreatefrompng("resources/filtres/".$_POST['filterpost']);
			$largeur_source = imagesx($source);
			$hauteur_source = imagesy($source);
			imagealphablending($source, true);
			imagesavealpha($source, true);

			$destination = imagecreatefrompng("resources/rendu.png");

			imagecopy($destination, $source, 280, 20, 0, 0, $largeur_source, $hauteur_source);
			imagepng($destination, 'resources/rendu.png');
			$imdata = base64_encode(file_get_contents('resources/rendu.png'));
			$bdd->query('INSERT INTO snap (`login`, `date`, `img`) VALUES ("'.$_SESSION['login'].'", "'.date("Y-m-d H:i:s").'", "data:image/png;base64,'.$imdata.'");');
		}
		$log = $bdd->query("SELECT * FROM snap WHERE `login` LIKE '".$_SESSION['login']."' ORDER BY `date` DESC;");
		$result = $log->fetchAll();
			if (count($result) > 0) { ?>
				<div id='snap_right'>
			<?php
			foreach ($result as $key => $val) {
			?>
			<form class="" action="usesnap.php" method="post">
				<input type="hidden" src="resources/delete-w.png" class="id" name="id" value="<?php echo $val['id'];?>">
				<input class="deleteimg" type="image" src="resources/delete-w.png" name="deleteimg" value="delete">
				<input class="sendimg" type="image" src="resources/send.png" name="sendimg" value="send">
				<div><img class='min' src="<?php echo $val['img'];?>"/></div>
			</form>
			<?php
			}
		?>
		</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
<?php }
else {
	?>
	<meta http-equiv="refresh" content='0;URL=index.php'/>
	<?php
}?>
<div class="footersnap">
</div>
	</body>
</html>
