<?php
//header('Location: recovery.php?recovery='.htmlspecialchars($_POST['recovery']).'&ok=ok');
session_start();
include('config/setup.php');
if (htmlspecialchars($_POST['submit']) === 'Change') {
	if (htmlspecialchars($_POST['ipass']) === htmlspecialchars($_POST['ipass2']) && strlen(htmlspecialchars($_POST['ipass'])) >= 6) {
		$log = $bdd->query("SELECT * FROM `users` WHERE `mail` LIKE '".htmlspecialchars($_POST['imail'])."'");
		$ok = $log->fetch();
		$passs = hash(whirlpool, htmlspecialchars($_POST['ipass']));
		$log = $bdd->query("UPDATE `users` SET `passwd` = '".$passs."' WHERE `users`.`id` = ".htmlspecialchars($ok['id']));
		?>
		<meta http-equiv="refresh" content='0;URL=recovery.php?recovery=<?php echo htmlspecialchars($_POST['recovery']); echo "&ok=ok";?>'/>
		<?php
	}
	else {
		$_SESSION['error'] = "A field is empty, fields don't match or password have less than 6 characters.";
		?>
		<meta http-equiv="refresh" content='0;URL=recovery.php?recovery=<?php echo htmlspecialchars($_POST['recovery']);?>'/>
		<?php
	}
}?>
