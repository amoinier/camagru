<?php
header('Location: editacc.php');
session_start();
include('config/access.php');
if ($_POST['pdpch'] === 'pdpch' && is_numeric($_POST['pid'])) {
	$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".$_SESSION['login']."';");
	$result = $log->fetch();
	$snap = $bdd->query("SELECT * FROM snap WHERE `id` LIKE ".$_POST['pid'].";");
	$snapres = $snap->fetch();
	$bdd->query("UPDATE users SET `pdp` = '".$snapres['img']."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
}
else if ($_POST['Change'] === 'Change Facebook') {
	if ($_POST['facebook']) {
		$bdd->query("UPDATE users SET `facebook` = '".$_POST['facebook']."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
	}
	else {
		$_SESSION['error'] = "The field is enpty.";
		?>
		<meta http-equiv="refresh" content='0;URL=editacc.php'/>
		<?php
	}
}
else if ($_POST['Change'] === 'Change Mail') {
	if ($_POST['mail1'] === $_POST['mail2'] && $_POST['mail1']) {
		$bdd->query("UPDATE users SET `mail` = '".$_POST['mail1']."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
	}
	else {
		$_SESSION['error'] = "A field is empty or fields doesn't match.";
		?>
		<meta http-equiv="refresh" content='0;URL=editacc.php'/>
		<?php
	}
}
else if ($_POST['Change'] === 'Change Password') {
	if (hash(whirlpool, $_POST['oldpwd']) === $result['passwd']) {
		if ($_POST['newpwd1'] === $_POST['newpwd1'] && $_POST['newpwd1']) {
			$bdd->query("UPDATE users SET `mail` = '".$_POST['mail1']."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
		}
		else {
			$_SESSION['error'] = "A field is empty or fields doesn't match.";
			?>
			<meta http-equiv="refresh" content='0;URL=editacc.php'/>
			<?php
		}
	}
	else {
		$_SESSION['error'] = "Your old password isn't correct.";
		?>
		<meta http-equiv="refresh" content='0;URL=editacc.php'/>
		<?php
	}
}
else {
	?>
	<meta http-equiv="refresh" content='0;URL=editacc.php'/>
	<?php
}
?>
