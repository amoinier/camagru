<?php  include('header.php');
include('config/access.php');
if ($_SESSION['login'] && $_GET['login']) {
	$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".$_GET['login']."';");
	$result = $log->fetch();
	if ($result) {
		$snap = $bdd->query("SELECT * FROM snap WHERE `login` LIKE '".$result['login']."' ORDER BY `date` DESC;");
		$snapnb = $snap->fetchAll();
		?>
		<div id="blpdp">
			<?php if ($_SESSION['login'] === $_GET['login']) { ?>
			<a id="sett" href="editacc.php"><img id="logset" src="resources/settings.png"/></a>
			<?php } ?>
			<img id="pdp" src="<?php echo $result['pdp'];?>"/>
			<?php if ($result['facebook']) { ?>
				<a id="linkface" href="<?php echo $result['facebook'];?>"><div id="facebook">Facebook</div></a>
				<?php } ?>
				<img class="count" src="resources/camera.png"/>
				<span id='snapnb'><?php echo count($snapnb); ?></span>
			</div>
			<?php if ($snapnb) {?>
				<div id='allphoto'>
					<?php foreach ($snapnb as $key => $val) {
						$like = $bdd->query("SELECT * FROM love WHERE `login` LIKE '".$_SESSION['login']."' AND `idphoto` LIKE ".$val['id'].";");
						$nbrlike = $bdd->query("SELECT * FROM love WHERE `like` LIKE 1 AND `idphoto` LIKE ".$val['id'].";");
						$nbrlikef = $nbrlike->fetchall();
						$likef = $like->fetch();
						if ($likef && $likef['like'] == 1) {
							$heart = "resources/heart.png";
						}
						else {
							$heart = "resources/heartno.png";
						}
						?>
						<form action="lico.php" method="post">
							<div class='imgind'><img class='max' src="<?php echo $val['img'];?>"/></div>
							<input class="heartind" type="image" src="<?php echo $heart;?>" name="like" value="like">
							<span class='nbrlike'><?php echo count($nbrlikef); if (count($nbrlikef) < 2) {$people = " people";} else {$people = " peoples";} echo $people;?> like this photo.</span>
							<input type="hidden" name="pid" value="<?php echo $val['id'];?>">
							<input type="hidden" name="plike" value="<?php echo $likef['like'];?>">
							<input type="hidden" name="nbrpage" value="<?php echo $_GET['page'];?>">
						</form>
						<form action="lico.php" method="post">
							<input class="commentind" type="image" src="resources/comment.png" name="comment" value="comment">
							<input type="hidden" name="pid" value="<?php echo $val['id'];?>">
							<input type="hidden" name="log" value="<?php echo $val['login'];?>">
							<input type="hidden" name="nbrpage" value="<?php echo $_GET['page'];?>">
							<input id="textcom" type="text" name="sendcom" value="">
						</form>
						<?php $comm = $bdd->query("SELECT * FROM comment WHERE `idphoto` LIKE ".$val['id'].";");
						$comment = $comm->fetchall();
						if ($comment) {?>
							<div tabindex="0" class="onclick-menu">
								<ul class="onclick-menu-content">
									<?php
									foreach ($comment as $key => $value) {
										echo "<li>".$value['login'].": ".$value['text']."</li><br />";
									}?>
								</ul>
							</div>
							<?php }
						} ?>
					</div>
			<?php }
			}
			else { ?>
				<div id="validate">This profile doesn't exists.</div>
			<?php }
		}
else {
	?>
	<meta http-equiv="refresh" content='0;URL=index.php'/>
	<?php
}
if (count($snapnb) < 2) { ?>
	<div class="footer">
	</div>
</body>
</html><?php
}
else {?>
	<br />
	<br />
	<div class="footersnap">
	</div>
</body>
</html>
<?php }
?>
