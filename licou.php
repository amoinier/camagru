<?php
header('Location: users.php?page='.htmlspecialchars($_POST['nbrpage']).'&login='.htmlspecialchars($_POST['log']));
session_start();
include('config/setup.php');
date_default_timezone_set('Europe/Paris');
$pid = htmlspecialchars($_POST['pid']);
$plike = htmlspecialchars($_POST['plike']);
$ispost = $bdd->query("SELECT * FROM `snap` WHERE `id` = ".$pid);
$postres = $ispost->fetch();
if (isset($postres['post']) && $postres['post'] == 1) {
	if (htmlspecialchars($_POST['like']) === 'like' && is_numeric($pid)) {
		if ($plike == 1) {
			$bdd->query("UPDATE love SET `like` = 0 WHERE `love`.`idphoto` = ".$pid." AND `love`.`login` LIKE '".$_SESSION['login']."';");
			$bdd->query("UPDATE love SET `date` = '".date("Y-m-d H:i:s")."' WHERE `love`.`idphoto` = ".$pid.";");
		}
		else if (is_numeric($plike) && $plike == 0) {
			$bdd->query("UPDATE love SET `like` = 1 WHERE `love`.`idphoto` = ".$pid." AND `love`.`login` LIKE '".$_SESSION['login']."';");
			$bdd->query("UPDATE love SET `date` = '".date('Y-m-d H:i:s')."' WHERE `love`.`idphoto` = ".$pid.";");
		}
		else {
			$bdd->query('INSERT INTO love (`idphoto`, `login`, `date`, `like`) VALUES ('.$pid.', "'.$_SESSION['login'].'", "'.date("Y-m-d H:i:s").'", 1);');
		}
	}
	else if (htmlspecialchars($_POST['comment']) === 'comment' && htmlspecialchars($_POST['sendcom'])) {
		$bdd->query('INSERT INTO comment (`idphoto`, `login`, `date`, `text`) VALUES ('.$pid.', "'.$_SESSION['login'].'", "'.date("Y-m-d H:i:s").'", "'.htmlspecialchars($_POST['sendcom']).'");');
		$findmail = $bdd->query('SELECT * FROM `users` WHERE `login` LIKE "'.htmlspecialchars($_POST['log']).'";');
		$findmailre = $findmail->fetch();
		$headers = 'From: InstaSnap'."\r\n";
		$headers.= "MIME-version: 1.0\n";
		$headers.= "Content-type: text/html; charset= iso-8859-1\n";
		$message = "Hi ".htmlspecialchars($_POST['log']).", <html><body>You receive a new commentary, click <a href='http://localhost:8080".substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['PHP_SELF']) - strlen(strrchr($_SERVER['PHP_SELF'], "/")))."/photo.php?login=".$_POST['log']."&idphoto=".$pid."'>here</a> to see it!</html></body>";
		mail($findmailre['mail'], "You receive a new commentary", $message, $headers);
	}
}?>
