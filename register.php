<?php  include('header.php');
if (!$_SESSION['login']) {?>
<div id='register'>
	<form action="create.php" method="post">
		<label for="login">Login</label>
		<input type="text" id='ilogin' name="ilogin">
		<label for="password">Password</label>
		<input type="password" id='ipass' name="ipass">
		<label for="password2">Retape your password</label>
		<input type="password" id='ipass2' name="ipass2">
		<label for="fname">Email</label>
		<input type="email" id='imail' name="imail">
		<input type="submit" name="submit" value="Submit">
	</form>
	<div class="err"><?php echo $_SESSION['error'];
	$_SESSION['error'] = "";?></div>
</div>
<?php } include('footer.php');
?>
