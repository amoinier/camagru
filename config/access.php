
<?php
include('database.php');
try
{
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
}
catch (PDOException $e)
{
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}?>
