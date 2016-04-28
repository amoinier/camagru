<?php
session_start();
include('config/access.php');
if (htmlspecialchars($_POST['submit']) === 'Change') {
	$if = 1;
	if (htmlspecialchars($_POST['ipass']) === htmlspecialchars($_POST['ipass2']) && htmlspecialchars($_POST['ipass'])) {
		$log = $bdd->query("SELECT * FROM `users` WHERE `mail` LIKE '".htmlspecialchars($_POST['imail'])."'");
		$ok = $log->fetch();
		$passs = hash(whirlpool, htmlspecialchars($_POST['ipass']));
		$log = $bdd->query("UPDATE `users` SET `passwd` = '".$passs."' WHERE `users`.`id` = ".htmlspecialchars($ok['id']));
		?>
		<div id="validate">Your password is updated</div>
		<meta http-equiv="refresh" content='5;URL=index.php'/>
		<?php
	}
	else {
		$_GET['ok'] = "test";
		$_SESSION['error'] = "A field is empty of fields don't match";
		if ($_SESSION['error']) { ?>
		<div id="errorbox"><div class="err"><?php echo $_SESSION['error'];
		$_SESSION['error'] = "";?></div></div>
		<?php }
	}
}?>
