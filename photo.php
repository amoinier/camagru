<?php  include('header.php');
include('config/setup.php');
if (htmlspecialchars($_GET['login']) && htmlspecialchars($_GET['idphoto'])) {
	$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".htmlspecialchars($_GET['login'])."';");
	$result = $log->fetch();
	$snap = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 AND `login` LIKE '".htmlspecialchars($result['login'])."' AND `id` = ".$_GET['idphoto'].";");
	$snapnb = $snap->fetch();
	if ($result && $snapnb) {
		$counts = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 AND `login` LIKE '".htmlspecialchars($result['login'])."' ORDER BY `date` DESC;");
		$countss = $counts->fetchAll();
		?>
		<div id="blpdp">
			<span id="prevacc"><?php echo htmlspecialchars($_GET['login']); ?></span>
			<?php if ($_SESSION['login'] === htmlspecialchars($_GET['login'])) { ?>
			<a id="sett" href="editacc.php"><img id="logset" src="resources/settings.png"/></a>
			<?php } ?>
			<img id="pdp" src="<?php echo $result['pdp'];?>"/>
			<?php if (htmlspecialchars($result['facebook'])) { ?>
				<a id="linkface" href="<?php echo htmlspecialchars($result['facebook']);?>"><div id="facebook">Facebook</div></a>
				<?php } ?>
				<img class="count" src="resources/camera.png"/>
				<span id='snapnb'><?php echo count($countss); ?></span>
			</div>
			<?php if ($snapnb) {?>
				<div id='allphoto'>
					<?php
						$like = $bdd->query("SELECT * FROM love WHERE `login` LIKE '".$_GET['login']."' AND `idphoto` LIKE ".htmlspecialchars($_GET['idphoto']).";");
						$nbrlike = $bdd->query("SELECT * FROM love WHERE `like` LIKE 1 AND `idphoto` LIKE ".htmlspecialchars($_GET['idphoto']).";");
						$nbrlikef = $nbrlike->fetchall();
						$likef = $like->fetch();
						if ($likef && $likef['like'] == 1) {
							$heart = "resources/heart.png";
						}
						else {
							$heart = "resources/heartno.png";
						}
						?>
						<form action="licop.php" method="post">
							<div class='imgind'><img class='max' src="<?php echo $snapnb['img'];?>"/></div>
							<?php if ($_SESSION['login']) { ?>
							<input class="heartind" type="image" src="<?php echo $heart;?>" name="like" value="like">
							<?php } ?>
							<span class='nbrlike'><?php echo count($nbrlikef); if (count($nbrlikef) < 2) {$people = " people";} else {$people = " peoples";} echo $people;?> like this photo.</span>
							<input type="hidden" name="pid" value="<?php echo htmlspecialchars($snapnb['id']);?>">
							<input type="hidden" name="plike" value="<?php echo $likef['like'];?>">
							<input type="hidden" name="nbrpage" value="<?php echo htmlspecialchars($_GET['page']);?>">
							<input type="hidden" name="log" value="<?php echo htmlspecialchars($snapnb['login']);?>">
						</form>
						<form action="licop.php" method="post">
							<?php if ($_SESSION['login']) { ?>
							<input class="commentind" type="image" src="resources/comment.png" name="comment" value="comment">
							<?php } ?>
							<input type="hidden" name="pid" value="<?php echo htmlspecialchars($snapnb['id']);?>">
							<input type="hidden" name="log" value="<?php echo htmlspecialchars($snapnb['login']);?>">
							<?php if ($_SESSION['login']) { ?>
							<input id="textcom" type="text" name="sendcom" value="">
							<?php } ?>
						</form>
						<?php $comm = $bdd->query("SELECT * FROM comment WHERE `idphoto` LIKE ".htmlspecialchars($_GET['idphoto']).";");
						$comment = $comm->fetchall();
						if ($comment) {?>
							<div tabindex="0" class="onclick-menu">
								<ul class="onclick-menu-content">
									<?php
									foreach ($comment as $key => $value) {
										echo "<li>".htmlspecialchars($value['login']).": ".htmlspecialchars($value['text'])."</li><br />";
									}?>
								</ul>
							</div>
							<?php }?>
					</div>
			<?php }
			}
			else { ?>
				<div id="validate">This photo doesn't exists.</div>
			<?php }
		}
else {
	?>
	<meta http-equiv="refresh" content='0;URL=index.php'/>
	<?php
}?>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<div class="footersnap">
	</div>
</body>
</html>
