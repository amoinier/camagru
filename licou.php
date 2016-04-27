<?php
header('Location: users.php?page='.$_POST['nbrpage'].'&login='.$_POST['log']);
session_start();
include('config/access.php');
date_default_timezone_set('Europe/Paris');
if ($_POST['like'] === 'like' && is_numeric($_POST['pid'])) {
	if ($_POST['plike'] == 1) {
		$bdd->query("UPDATE love SET `like` = 0 WHERE `love`.`idphoto` = ".$_POST['pid']." AND `love`.`login` LIKE '".$_SESSION['login']."';");
		$bdd->query("UPDATE love SET `date` = '".date("Y-m-d H:i:s")."' WHERE `love`.`idphoto` = ".$_POST['pid'].";");
	}
	else if (is_numeric($_POST['plike']) && $_POST['plike'] == 0) {
		$bdd->query("UPDATE love SET `like` = 1 WHERE `love`.`idphoto` = ".$_POST['pid']." AND `love`.`login` LIKE '".$_SESSION['login']."';");
		$bdd->query("UPDATE love SET `date` = '".date('Y-m-d H:i:s')."' WHERE `love`.`idphoto` = ".$_POST['pid'].";");
	}
	else {
		$bdd->query('INSERT INTO love (`idphoto`, `login`, `date`, `like`) VALUES ('.$_POST['pid'].', "'.$_SESSION['login'].'", "'.date("Y-m-d H:i:s").'", 1);');
	}
}
else if ($_POST['comment'] === 'comment' && $_POST['sendcom']) {
	$bdd->query('INSERT INTO comment (`idphoto`, `login`, `date`, `text`) VALUES ('.$_POST['pid'].', "'.$_SESSION['login'].'", "'.date("Y-m-d H:i:s").'", "'.$_POST['sendcom'].'");');
	$findmail = $bdd->query('SELECT * FROM `users` WHERE `login` LIKE "'.$_POST['log'].'";');
	$findmailre = $findmail->fetch();
	$headers = 'From: InstaSnap'."\r\n";
	$headers.= "MIME-version: 1.0\n";
	$headers.= "Content-type: text/html; charset= iso-8859-1\n";
	$message = "Hi ".$_POST['log'].", One of your photo received a new commentary! Let's go to see it!";
	mail($findmailre['mail'], "You receive a new commentary", $message, $headers);
}?>
