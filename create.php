<?php
session_start();
include('config/access.php');

$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".$_POST['ilogin']."';");
$result = $log->fetch();
if ($_POST['submit'] === 'Register' && $_POST['ipass'] && $_POST['ipass2'] && $_POST['ilogin'] && $_POST['imail']) {
	if ($result['login'] !== $_POST['ilogin']) {
		$log = $bdd->query("SELECT * FROM users WHERE `mail` LIKE '".$_POST['imail']."';");
		$result = $log->fetch();
		if ($_POST['ipass'] === $_POST['ipass2']) {
			if ($result['mail'] !== $_POST['imail']) {
				$passs = hash(whirlpool, $_POST['ipass']);
				$bdd->query('INSERT INTO users (`login`, `passwd`, `mail`, `validate`) VALUES ("'.$_POST['ilogin'].'", "'.$passs.'", "'.$_POST['imail'].'", "0");');
				$headers = 'From: InstaSnap' . "\r\n";
				$headers.= "MIME-version: 1.0\n";
				$headers.= "Content-type: text/html; charset= iso-8859-1\n";
				$pass = hash(whirlpool, $_POST['imail']);
				$message = "<html><body><a href='http://localhost:8080/camagru/validate.php?validate=".$pass."'>Activation</a></html></body>";
				mail($_POST['imail'], "Activate your account", $message, $headers);
				$_SESSION['error'] = "An email will sent you.";
				?>
				<meta http-equiv="refresh" content='0;URL=index.php'/>
				<?php
			}
			else {
				$_SESSION['error'] = "This email is already uses.";
				?>
				<meta http-equiv="refresh" content='0;URL=register.php'/>
				<?php
			}
		}
		else {
			$_SESSION['error'] = "Password do not match.";
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
