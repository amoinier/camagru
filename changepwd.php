<?php
header('Location: recovery.php?recovery='.$_POST['recovery'].'&ok=ok');
session_start();
include('config/setup.php');
if (htmlspecialchars($_POST['submit']) === 'Change') {
	if (htmlspecialchars($_POST['ipass']) === htmlspecialchars($_POST['ipass2']) && htmlspecialchars($_POST['ipass'])) {
		$log = $bdd->query("SELECT * FROM `users` WHERE `mail` LIKE '".htmlspecialchars($_POST['imail'])."'");
		$ok = $log->fetch();
		$passs = hash(whirlpool, htmlspecialchars($_POST['ipass']));
		$log = $bdd->query("UPDATE `users` SET `passwd` = '".$passs."' WHERE `users`.`id` = ".htmlspecialchars($ok['id']));
	}
	else {
		$_SESSION['error'] = "A field is empty of fields don't match";
	}
}?>
