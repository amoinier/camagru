<?php
header('Location: snap.php');
session_start();
date_default_timezone_set('Europe/Paris');
include('config/setup.php');
$bd = $bdd->query('SELECT * FROM `snap` WHERE `id` LIKE "'.$_POST['id'].'" AND `login` LIKE "'.$_SESSION['login'].'";');
$res = $bd->fetch();
if ($_POST['deleteimg'] === 'delete' && is_numeric($_POST['id']) && $res) {
	$bdd->query('DELETE FROM `snap` WHERE `id` LIKE "'.$_POST['id'].'" AND `login` LIKE "'.$_SESSION['login'].'";');
	$bdd->query('DELETE FROM `love` WHERE `idphoto` LIKE "'.$_POST['id'].'";');
	$bdd->query('DELETE FROM `comment` WHERE `idphoto` LIKE "'.$_POST['id'].'";');
}
else if ($_POST['sendimg'] === 'send' && is_numeric($_POST['id'])) {
	$bdd->query("UPDATE `snap` SET `post` = 1 WHERE `snap`.`id` = ".$_POST['id']." AND `login` LIKE '".$_SESSION['login']."';");
	$bdd->query("UPDATE `snap` SET `date` = '".date('Y-m-d H:i:s')."' WHERE `snap`.`id` = ".$_POST['id']." AND `login` LIKE '".$_SESSION['login']."';");
}
?>
