<?php  include('header.php');
include('config/access.php');
if ($_SESSION['login'] && $_GET['login']) {
	$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".$_GET['login']."';");
	$result = $log->fetch();
	if ($result) {
		$page = 0;
		if ($_GET['page'] && $_GET['page'] > 0) {
			$page = ($_GET['page'] - 1) * 5;
		}
		$snap = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 AND `login` LIKE '".$result['login']."' ORDER BY `date` DESC LIMIT 5 OFFSET ".$page.";");
		$snapnb = $snap->fetchAll();
		$counts = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 AND `login` LIKE '".$result['login']."' ORDER BY `date` DESC;");
		$countss = $counts->fetchAll();
		?>
		<div id="blpdp">
			<span id="prevacc"><?php echo $_GET['login']; ?></span>
			<?php if ($_SESSION['login'] === $_GET['login']) { ?>
			<a id="sett" href="editacc.php"><img id="logset" src="resources/settings.png"/></a>
			<?php } ?>
			<img id="pdp" src="<?php echo $result['pdp'];?>"/>
			<?php if ($result['facebook']) { ?>
				<a id="linkface" href="<?php echo $result['facebook'];?>"><div id="facebook">Facebook</div></a>
				<?php } ?>
				<img class="count" src="resources/camera.png"/>
				<span id='snapnb'><?php echo count($countss); ?></span>
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
						<form action="licou.php" method="post">
							<div class='imgind'><img class='max' src="<?php echo $val['img'];?>"/></div>
							<input class="heartind" type="image" src="<?php echo $heart;?>" name="like" value="like">
							<span class='nbrlike'><?php echo count($nbrlikef); if (count($nbrlikef) < 2) {$people = " people";} else {$people = " peoples";} echo $people;?> like this photo.</span>
							<input type="hidden" name="pid" value="<?php echo $val['id'];?>">
							<input type="hidden" name="plike" value="<?php echo $likef['like'];?>">
							<input type="hidden" name="nbrpage" value="<?php echo $_GET['page'];?>">
							<input type="hidden" name="log" value="<?php echo $val['login'];?>">
						</form>
						<form action="licou.php" method="post">
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
			$snap = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 AND `login` LIKE '".$result['login']."' ORDER BY `date` DESC;");
			$snapnbr = $snap->fetchAll();
			$photo = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 AND `login` LIKE '".$result['login']."' ORDER BY `date` DESC;");
			$photonbr = $photo->fetchAll();
			if (count($photonbr) / 5 + 1 >= $_GET['page'] && count($photonbr) != 0) { ?>
			<div id="page">
			<form action="users.php" method="get">
				<?php if ($page / 5 - 1 >= 0) { ?>
				 <input class="pagef" type="image" src="resources/pagef.png" name="page" value="<?php if ($page / 5 - 1 >= 0) {echo $page / 5;} else {$page = 0;} ?>">
				 <?php } ?>
				 <span class="page-nbr"><?php echo $page / 5 + 1; ?></span>
				 <?php if ($page / 5 + 2 < (count($snapnbr) / 5) + 1) { ?>
				 <input class="pagel" type="image" src="resources/pagel.png" name="page" value="<?php if ($page / 5 + 2 <= (count($snapnbr) / 5) + 1) {echo $page / 5 + 2;}?>">
				 <?php } ?>
				 <input type="hidden" name="login" value="<?php echo $_GET['login'];?>">
			</form>
			</div>
			<?php
			}
			}
			else { ?>
				<div id="validate">This profile doesn't exists.</div>
			<?php }
		}
else {
	echo "OK";
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
