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
<?php }?>
<div class="footerind">
	<div id="copyr"> InstaSnap &copy; amoinier, 2016</div>
</div>
	</body>
</html>
