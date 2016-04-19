<?php  include('header.php');
if (!$_SESSION['login']) {?>
<div id='login'>
	<form action="login.php" method="post">
		<label for="login">Login</label>
		<input type="password" id='ilogin' name="ilogin" value="">
		<label for="password">Password</label>
		<input type="text" id='ipass' name="ipass" value="">
		<input type="submit" name="submit" value="Submit">
	</form>
	<div class="err"><?php echo $_SESSION['error'];
	$_SESSION['error'] = "";?></div>
</div>
<?php } include('footer.php');
?>
