<?php
header('Location: index.php');
session_start();
include('config/access.php');
if ($_POST['like'] === 'like' && is_numeric($_POST['pid'])) {
	if ($_POST['plike'] == 1) {
		$bdd->query("UPDATE love SET `like` = 0 WHERE `love`.`idphoto` = ".$_POST['pid'].";");
	}
	else if (is_numeric($_POST['plike']) && $_POST['plike'] == 0) {
		$bdd->query("UPDATE love SET `like` = 1 WHERE `love`.`idphoto` = ".$_POST['pid'].";");
	}
	else {
		$bdd->query('INSERT INTO love (`idphoto`, `login`, `date`, `like`) VALUES ('.$_POST['pid'].', "'.$_SESSION['login'].'", "'.date("Y-m-d H:i:s").'", 1);');
	}
}?>
