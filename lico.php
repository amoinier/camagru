<?php
//header('Location: index.php');
session_start();
echo "OK";
if ($_POST['like'] === 'like' && is_numeric($_POST['photoid'])) {
	echo "OK";
	if ($_POST['photoid'] == 1) {
		$bdd->query("UPDATE `like` SET `like` = 1 WHERE `like`.`photoid` = ".$_POST['photoid'].";");
	}
	else if ($_POST['photoid'] == 0) {
		$bdd->query("UPDATE `like` SET `like` = 0 WHERE `like`.`photoid` = ".$_POST['photoid'].";");
	}
	else {
		$bdd->query('INSERT INTO `like` (`photoid`, `login`, `date`, `like`) VALUES ("'.$_SESSION['login'].'", "'.date("Y-m-d H:i:s").'", 1);');
	}
}?>
