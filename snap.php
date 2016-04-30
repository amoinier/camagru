<?php include('header.php');
date_default_timezone_set('Europe/Paris');
include('config/setup.php');
include('base64.php');
$filepath = "";
if ($_SESSION['upload'] && $_SESSION['upload'] != -1) {
	$filepath = $_SESSION['upload'];
	echo "<input type='hidden' id='pathfile' name='name' value='".$_SESSION['upload']."'>";
	$_SESSION['upload'] = 0;
}
else if ($_SESSION['upload'] == -1) {
	echo "<div id='errorupload'><div class='err'>Un probleme est survenu lors de la lecture du fichier, veuille ressayer</div></div>";
	$_SESSION['upload'] = 0;
}
if ($_SESSION['login']) {?>
	<script type="text/javascript" src="js/webcam.js"></script>
	<div class="container">
		<div id=snap_left>
			<div id="snap_win" class="snap_win">
				<?php if ($filepath === "") { ?>
				<video id="video" width="640" height="480" autoplay></video>
				<?php }
				else {?>
					<img id="imgup" src="<?php echo $filepath; ?>"/>
				<?php }?>
				<canvas id="canvas" width="640" height="480"></canvas>
			</div>
			<div id="select-filter">
				<select id="filterid">
					<option value=""></option>
					<option value="face.png">Face</option>
					<option value="cat.png">Cat</option>
					<option value="42.png">42 Logo</option>
				</select>
			</div>
			<button id="snapbut">Preview Photo</button>
			<button id="savebut">Send Photo</button>
			<?php if ($filepath === "") { ?>
			<form method="POST" action="upload.php" enctype="multipart/form-data">
				<input type="file" name="upload-photo">
				<input type="submit" name="envoyer" value="Envoyer le fichier">
			</form>
			<?php } ?>
		</div>
		<?php
		if (htmlspecialchars($_POST['sub']) === 'save' && $_POST['img']) {
			base64_to_png($_POST['img'], 'resources/rendu.png');
			if(file_exists("resources/rendu.png")) {
				$destination = imagecreatefromstring(file_get_contents("resources/rendu.png"));
				if (preg_match('/.*png/', htmlspecialchars($_POST['filterpost']))) {
					$source = imagecreatefrompng("resources/filtres/".htmlspecialchars($_POST['filterpost']));
					imagealphablending($source, true);
					imagesavealpha($source, true);
					imagecopy($destination, $source, 0, 0, 0, 0, imagesx($source), imagesy($source));
				}
				imagepng($destination, 'resources/rendu.png');
				$imdata = base64_encode(file_get_contents('resources/rendu.png'));
				$bdd->query('INSERT INTO snap (`login`, `date`, `img`) VALUES ("'.$_SESSION['login'].'", "'.date("Y-m-d H:i:s").'", "data:image/png;base64,'.$imdata.'");');
				if (file_exists("resources/rendu.png")) {
					unlink("resources/rendu.png");
				}
				if (file_exists("upload")) {
					$files = glob('upload/*');
					foreach($files as $file){
						if(is_file($file)) {
							unlink($file);
						}
					}
					rmdir("upload");
				}
			}
		}
		$log = $bdd->query("SELECT * FROM snap WHERE `login` LIKE '".$_SESSION['login']."' ORDER BY `date` DESC;");
		$result = $log->fetchAll();
			if (count($result) > 0) { ?>
				<div id='snap_right'>
			<?php
			foreach ($result as $key => $val) {
				$spost = $bdd->query("SELECT post FROM snap WHERE `img` LIKE '".$val['img']."';");
				$spostres = $spost->fetch();
			?>
			<form action="usesnap.php" method="post">
				<input type="hidden" src="resources/delete-w.png" class="id" name="id" value="<?php echo $val['id'];?>">
				<input class="deleteimg" type="image" src="resources/delete-w.png" name="deleteimg" value="delete">
				<input class="sendimg" type="image" src="resources/send.png" name="sendimg" value="send">
				<div><?php if ($spostres['post'] == 1) {
					?><div id='publish'><?php echo "Published!";?></div><?php
				}
				else {
					?><div id='npublish'><?php echo "Not published yet!";?></div><?php
				}?></div>
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
		<div id="copyr"> InstaSnap &copy; amoinier 2016</div>
	</div>
		</body>
	</html>
