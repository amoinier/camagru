<?php
session_start();
include('config/setup.php');

$pass1 = sqlapo(htmlspecialchars($_POST['ipass']));
$pass2 = sqlapo(htmlspecialchars($_POST['ipass2']));
$login = sqlapo(htmlspecialchars($_POST['ilogin']));
$mail = sqlapo(htmlspecialchars($_POST['imail']));

$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".$login."';");
$result = $log->fetch();

if (htmlspecialchars($_POST['submit']) === 'Register' && $pass1 && $pass2 && $login && $mail) {
	if ($result['login'] !== $login) {
		$log = $bdd->query("SELECT * FROM users WHERE `mail` LIKE '".$mail."';");
		$result = $log->fetch();
		if ($pass1 === $pass2 && strlen($pass1) >= 6) {
			if ($result['mail'] !== $mail && preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $mail)) {
				$passs = hash(whirlpool, $pass1);
				$defpdp = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAEUlEQVR42mP4TyRgGFVIX4UAI/uOgGWVNeQAAAAASUVORK5CYII=";
				$bdd->query('INSERT INTO users (`login`, `passwd`, `mail`, `validate`, `pdp`) VALUES ("'.$login.'", "'.$passs.'", "'.$mail.'", "0", "'.$defpdp.'");');
				$headers = 'From: InstaSnap' . "\r\n";
				$headers.= "MIME-version: 1.0\n";
				$headers.= "Content-type: text/html; charset= iso-8859-1\n";
				$pass = hash(whirlpool, $mail);
				$message = "<html><body><a href='http://localhost:8080".substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['PHP_SELF']) - strlen(strrchr($_SERVER['PHP_SELF'], "/")))."/validate.php?validate=".$pass."'>Activation</a></html></body>";
				mail($mail, "Activate your account", $message, $headers);
				$_SESSION['error'] = "An email will sent you.";
				?>
				<meta http-equiv="refresh" content='0;URL=connect.php'/>
				<?php
			}
			else {
				$_SESSION['error'] = "This email is already uses or it didn't work.";
				?>
				<meta http-equiv="refresh" content='0;URL=register.php'/>
				<?php
			}
		}
		else {
			$_SESSION['error'] = "Passwords don't match or too short (min. 6 characters).";
			?>
			<meta http-equiv="refresh" content='0;URL=register.php'/>
			<?php
		}
	}
	else {
		$_SESSION['error'] = "This account already exists.";
		?>
		<meta http-equiv="refresh" content='0;URL=register.php'/>
		<?php
	}
}
else {
	$_SESSION['error'] = "A field is empty.";
	?>
	<meta http-equiv="refresh" content='0;URL=register.php'/>
	<?php
}
?>
