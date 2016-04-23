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
<?php }
else {
	$log = $bdd->query("SELECT * FROM snap WHERE `post` LIKE 1 ORDER BY `date` DESC;");
	$result = $log->fetchAll();
	?><div id='allphoto'><?php
	foreach ($result as $key => $val) {
		$like = $bdd->query("SELECT * FROM love WHERE `login` LIKE '".$_SESSION['login']."' AND `idphoto` LIKE ".$val['id'].";");
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
		<input type="hidden" name="pid" value="<?php echo $val['id'];?>">
		<input type="hidden" name="plike" value="<?php echo $likef['like'];?>">
	</form>
	<?php
	}?>
</div><?php
}
?>
<div class="footersnap">
</div>
	</body>
</html>
