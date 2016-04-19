<?php  include('header.php');
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
<?php } include('footer.php');
?>
