<?php
session_start();
include('config/setup.php');

$log = $bdd->query("SELECT * FROM users WHERE `mail` LIKE '".$_POST['imail']."';");
$result = $log->fetch();
if (htmlspecialchars($result['mail']) === htmlspecialchars($_POST['imail'])) {
	$headers = 'From: InstaSnap' . "\r\n";
	$headers.= "MIME-version: 1.0\n";
	$headers.= "Content-type: text/html; charset= iso-8859-1\n";
	$pass = hash(whirlpool, htmlspecialchars($_POST['imail']));
	$message = "<html><body><a href='http://localhost:8080/camagru/recovery.php?recovery=".$pass."'>Recovery</a></html></body>";
	mail(htmlspecialchars($_POST['imail']), "Change your password", $message, $headers);
	$_SESSION['error'] = "An email will sent you to change your password.";
	?>
	<meta http-equiv="refresh" content='0;URL=reinit.php'/>
	<?php
}
else {
	$_SESSION['error'] = "This account doesn't exists.";
	?>
	<meta http-equiv="refresh" content='0;URL=reinit.php'/>
	<?php
}
?>
