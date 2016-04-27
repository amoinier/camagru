<?php  include('header.php');
include('config/access.php');
if (!$_SESSION['login']) {?>
<div id='login'>
	<form action="login.php" method="post">
		<label for="login">Login</label>
		<input type="text" id='ilogin' name="ilogin" value="">
		<label for="password">Password</label>
		<input type="password" id='ipass' name="ipass" value="">
		<input type="submit" name="submit" value="Connect">
	</form>
	<div class="err"><?php echo $_SESSION['error'];
	$_SESSION['error'] = "";?></div>
</div>
<div id="reg"><a id="regtext" href="register.php">Register</a></div>
<div class="footer">
</div>
	</body>
</html>
<?php }
else {
	$page = 0;
	if ($_GET['page'] && $_GET['page'] > 0) {
		$page = ($_GET['page'] - 1) * 5;
	}
	$log = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 ORDER BY `date` DESC LIMIT 5 OFFSET ".$page.";");
	$result = $log->fetchAll();
	if ($result) {
	?><div id='allphoto'><?php
	foreach ($result as $key => $val) {
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
			<span class="postlogin">By <a class="linklog" href="users.php?login=<?php echo $val['login'];?>"><?php echo $val['login'];?></a></span>
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
}?>
</div>
<?php }
$snap = $bdd->query('SELECT * FROM `snap` WHERE `post` = 1;');
$snapnbr = $snap->fetchall();
$photo = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 ORDER BY `date` DESC;");
$photonbr = $photo->fetchAll();
if (count($photonbr) / 5 + 1 >= $_GET['page'] && count($photonbr) != 0) { ?>
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
	<div class="footer">
	</div>
</body>
</html><?php
}
else {?>
	<div class="footersnap">
	</div>
</body>
</html>
<?php }
}
?>
