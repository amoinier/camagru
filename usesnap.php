<?php
header('Location: snap.php');
session_start();
include('config/access.php');
if ($_POST['deleteimg'] === 'delete' && is_numeric($_POST['id'])) {
	$bdd->query('DELETE FROM `snap` WHERE `id` LIKE "'.$_POST['id'].'";');
}
else if ($_POST['sendimg'] === 'send' && is_numeric($_POST['id'])) {
	$bdd->query("UPDATE `snap` SET `post` = 1 WHERE `snap`.`id` = ".$_POST['id'].";");
}
?>
