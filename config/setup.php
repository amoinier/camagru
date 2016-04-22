<?php
include('database.php');
$createbdd = new PDO('mysql:host=localhost;charset=utf8', 'root', 'root');
$createbdd->exec('CREATE DATABASE `db_snap`;');
try
{
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
}
catch (PDOException $e)
{
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
$bdd->query('CREATE TABLE users (`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT, `login` VARCHAR(45) NOT NULL, `passwd` VARCHAR(129) NOT NULL, `mail` VARCHAR(45) NOT NULL, `validate` INT NOT NULL);');
$bdd->query('CREATE TABLE snap (`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT, `login` VARCHAR(45) NOT NULL, `date` DATETIME NOT NULL, `post` INT NOT NULL DEFAULT 0, `img` LONGTEXT NOT NULL);');
$bdd->query('INSERT INTO users (`login`, `passwd`, `mail`, `validate`) VALUES ("root", "06948d93cd1e0855ea37e75ad516a250d2d0772890b073808d831c438509190162c0d890b17001361820cffc30d50f010c387e9df943065aa8f4e92e63ff060c", "amoinier@outlook.fr", "1");');
?>
