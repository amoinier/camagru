<?php  include('header.php');
if (!$_SESSION['login']) {?>
<div id='login'>
	<form action="sendreinit.php" method="post">
		<label for="login">Email</label>
		<input type="text" id='imail' name="imail" value="">
		<input type="submit" name="submit" value="Reinitialise">
	</form>
	<div class="err"><?php echo $_SESSION['error'];
	$_SESSION['error'] = "";?></div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?php } include('footer.php');
?>
