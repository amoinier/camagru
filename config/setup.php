<?php
include('database.php');
try
{
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
try {
	$bdd->exec('CREATE DATABASE IF NOT EXISTS `db_snap`;');
}
catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
try {
	$bdd->exec('USE db_snap;');
}
catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
try {
	$bdd->query("CREATE TABLE IF NOT EXISTS users (`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT, `login` VARCHAR(45) NOT NULL, `passwd` VARCHAR(129) NOT NULL, `mail` VARCHAR(45) NOT NULL, `validate` INT NOT NULL, `pdp` LONGTEXT, `facebook` VARCHAR(255));");
}
catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
try {
	$bdd->query('CREATE TABLE IF NOT EXISTS snap (`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT, `login` VARCHAR(45) NOT NULL, `date` DATETIME NOT NULL, `post` INT NOT NULL DEFAULT 0, `img` LONGTEXT NOT NULL);');
}
catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
try {
	$bdd->query('CREATE TABLE IF NOT EXISTS comment (`idphoto` INT NOT NULL, `login` VARCHAR(45) NOT NULL, `date` DATETIME NOT NULL, `text` LONGTEXT);');
}
catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
try {
	$bdd->query('CREATE TABLE IF NOT EXISTS `love` (`idphoto` INT NOT NULL, `login` VARCHAR(45) NOT NULL, `date` DATETIME NOT NULL, `like` INT);');
}
catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}

function sqlapo($str) {
	return (str_replace("'", "\'", $str));
}
?>
