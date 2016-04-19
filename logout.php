<?php
header('Location: index.php');
session_start();
if ($_SESSION['login'])
{
	session_destroy();
}
?>
