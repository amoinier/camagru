<?php  include('header.php');
include('config/setup.php');
	$page = 0;
	if (htmlspecialchars($_GET['page']) && htmlspecialchars($_GET['page']) > 0) {
		$page = (htmlspecialchars($_GET['page']) - 1) * 5;
	}
	$log = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 ORDER BY `date` DESC LIMIT 5 OFFSET ".$page.";");
	$result = $log->fetchAll();
	if ($result) {
	?><div id='allphoto'><?php
	foreach ($result as $key => $val) {
		$like = $bdd->query("SELECT * FROM love WHERE `login` LIKE '".$_SESSION['login']."' AND `idphoto` LIKE ".htmlspecialchars($val['id']).";");
		$nbrlike = $bdd->query("SELECT * FROM love WHERE `like` LIKE 1 AND `idphoto` LIKE ".htmlspecialchars($val['id']).";");
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
			<div class='imgind'><a href="photo.php?login=<?php echo $val['login'];?>&idphoto=<?php echo $val['id'];?>"><img class='max' src="<?php echo $val['img'];?>"/></a></div>
			<?php if ($_SESSION['login']) { ?>
			<input class="heartind" type="image" src="<?php echo $heart;?>" name="like" value="like">
			<?php } ?>
			<span class='nbrlike'><?php echo count($nbrlikef); if (count($nbrlikef) < 2) {$people = " people";} else {$people = " peoples";} echo $people;?> like this photo.</span>
			<span class="postlogin">By <a class="linklog" href="users.php?login=<?php echo htmlspecialchars($val['login']);?>"><?php echo htmlspecialchars($val['login']);?></a></span>
			<input type="hidden" name="pid" value="<?php echo htmlspecialchars($val['id']);?>">
			<input type="hidden" name="plike" value="<?php echo $likef['like'];?>">
			<input type="hidden" name="nbrpage" value="<?php echo htmlspecialchars($_GET['page']);?>">
		</form>
		<form action="lico.php" method="post">
			<?php if ($_SESSION['login']) { ?>
			<input class="commentind" type="image" src="resources/comment.png" name="comment" value="comment">
			<?php } ?>
			<input type="hidden" name="pid" value="<?php echo htmlspecialchars($val['id']);?>">
			<input type="hidden" name="log" value="<?php echo htmlspecialchars($val['login']);?>">
			<input type="hidden" name="nbrpage" value="<?php echo htmlspecialchars($_GET['page']);?>">
			<?php if ($_SESSION['login']) { ?>
			<input id="textcom" type="text" name="sendcom" value="">
			<?php } ?>
		</form>
		<?php $comm = $bdd->query("SELECT * FROM comment WHERE `idphoto` LIKE ".htmlspecialchars($val['id']).";");
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
}?>
</div>
<?php }
$snap = $bdd->query('SELECT * FROM `snap` WHERE `post` = 1;');
$snapnbr = $snap->fetchall();
$photo = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 ORDER BY `date` DESC;");
$photonbr = $photo->fetchAll();
if (count($photonbr) / 5 + 1 >= htmlspecialchars($_GET['page']) && count($photonbr) != 0) { ?>
<div id="page">
<form action="index.php" method="get">
	<?php if ($page / 5 - 1 >= 0) { ?>
	 <input class="pagef" type="image" src="resources/pagef.png" name="page" value="<?php if ($page / 5 - 1 >= 0) {echo $page / 5;} else {$page = 0;} ?>">
	 <?php } ?>
	 <span class="page-nbr"><?php echo $page / 5 + 1; ?></span>
	 <?php if ($page / 5 + 2 < (count($snapnbr) / 5) + 1) { ?>
	 <input class="pagel" type="image" src="resources/pagel.png" name="page" value="<?php if ($page / 5 + 2 <= (count($snapnbr) / 5) + 1) {echo $page / 5 + 2;}?>">
	 <?php } ?>
</form>
</div>
<?php
}
if (count($result) < 2) { ?>
	<div class="footerind">
		<div id="copyr"> InstaSnap &copy; amoinier 2016</div>
	</div>
</body>
</html><?php
}
else {?>
	<div class="footersnap">
		<div id="copyr"> InstaSnap &copy; amoinier, 2016</div>
	</div>
</body>
</html>
<?php }
?>
