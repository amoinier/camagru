<?php
session_start();
include('config/setup.php');

$mail = sqlapo(htmlspecialchars($_POST['imail']));

$log = $bdd->query("SELECT * FROM users WHERE `mail` LIKE '".$mail."';");
$result = $log->fetch();
if (htmlspecialchars($result['mail']) === $mail) {
	$headers = 'From: InstaSnap' . "\r\n";
	$headers.= "MIME-version: 1.0\n";
	$headers.= "Content-type: text/html; charset= iso-8859-1\n";
	$pass = hash(whirlpool, $mail);
	$message = "<html><body><a href='http://localhost:8080".substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['PHP_SELF']) - strlen(strrchr($_SERVER['PHP_SELF'], "/")))."/recovery.php?recovery=".$pass."'>Recovery</a></html></body>";
	mail($mail, "Change your password", $message, $headers);
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
