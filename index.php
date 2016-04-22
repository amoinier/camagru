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
	foreach ($result as $key => $val) {
	?>
		<div><img class='min' src="<?php echo $val['img'];?>"/></div>
	<?php
	}
}
include('footer.php');
?>
