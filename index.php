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
			<span class='nbrlike'><?php echo count($nbrlikef);?> people(s) like this photo.</span>
			<input type="hidden" name="pid" value="<?php echo $val['id'];?>">
			<input type="hidden" name="plike" value="<?php echo $likef['like'];?>">
		</form>
		<?php
	}?>
</div>
<?php }?>
<div id="page">
<form action="index.php" method="get">
	 <input class="pagef" type="image" src="resources/pagef.png" name="page" value="<?php if ($page / 5 - 1 >= 0) {echo $page / 5 - 1;} else {$page = 0;} ?>">
	 <span class="page-nbr"><?php echo $page / 5 + 1; ?></span>
	 <input class="pagel" type="image" src="resources/pagel.png" name="page" value="<?php echo $page / 5 + 2; ?>">
</form>
</div>
<?php
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
