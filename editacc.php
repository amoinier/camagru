<?php  include('header.php');
include('config/access.php');
if ($_SESSION['login']) {
	$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".$_SESSION['login']."';");
	$result = $log->fetch();
	$snap = $bdd->query("SELECT * FROM snap WHERE `login` LIKE '".$result['login']."' ORDER BY `date` DESC;");
	$snapnb = $snap->fetchAll();
	?>
	<div id="blpdp">
		<span id="prevacc">Profile Preview</span>
		<img id="pdp" src="<?php echo $result['pdp'];?>"/>
		<?php if ($result['facebook']) { ?>
			<a id="linkface" href="<?php echo $result['facebook'];?>"><div id="facebook">Facebook</div></a>
			<?php } ?>
			<img class="count" src="resources/camera.png"/>
			<span id='snapnb'><?php echo count($snapnb); ?></span>
		</div><br /><br />
		<div id="choosepdp">
			<label for="pdp">Choose your profile photo:</label></br ></br >
			<?php
			if ($snapnb) {
				foreach ($snapnb as $key => $val) { ?>
					<form class="changepp" action="edit.php" method="post">
						<input class="imgsett" type="image" src="<?php echo $val['img'];?>" name="pdpch" value="pdpch">
						<input type="hidden" name="pid" value="<?php echo $val['id'];?>">
					</form>
					<?php
				}
			}
			else { ?>
				<label for="pdp">Take photo before change it!</label></br ></br >
			<?php }
			?>
		</div>
		<?php if ($_SESSION['error']) { ?>
		<div id="errorbox"><div class="err"><?php echo $_SESSION['error'];
		$_SESSION['error'] = "";?></div></div>
		<?php } ?>
	<div id="settings">
		<form action="edit.php" method="post">
			<label for="facebook">Facebook Account (link):</label>
			<input type="text" name="facebook" value="<?php echo $result['facebook']?>"></br >
			<input type="submit" name="Change" value="Change Facebook">
		</form></br >
		</div>
		<div id="settings">
		<form action="edit.php" method="post">
			<label for="mail1">New email:</label>
			<input type="email" name="mail1" value=""></br >
			<label for="fname">Retape you email:</label>
			<input type="email" name="mail2" value="">
			<input type="submit" name="Change" value="Change Mail">
		</form></br >
		</div>
		<div id="settings">
		<form action="edit.php" method="post">
			<label for="fname">Old password:</label>
			<input type="text" name="oldpwd" value=""></br >
			<label for="fname">New password:</label>
			<input type="text" name="newpwd1" value=""></br >
			<label for="fname">Retape your new password:</label>
			<input type="text" name="newpwd2" value="">
			<input type="submit" name="Change" value="Change Password">
		</form></br >
	</div>
	<?php
		}
else {
	?>
	<meta http-equiv="refresh" content='0;URL=index.php'/>
	<?php
}
if (count($snapnb) < 2) { ?>
	<div class="footer">
	</div>
</body>
</html><?php
}
else {?>
	<br />
	<br />
	<div class="footersnap">
	</div>
</body>
</html>
<?php }
?>
