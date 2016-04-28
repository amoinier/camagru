<?php
header('Location: editacc.php');
session_start();
include('config/access.php');
$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".$_SESSION['login']."';");
$result = $log->fetch();
if (htmlspecialchars($_POST['pdpch']) === 'pdpch' && is_numeric($_POST['pid'])) {
	$snap = $bdd->query("SELECT * FROM snap WHERE `id` LIKE ".$_POST['pid'].";");
	$snapres = $snap->fetch();
	$bdd->query("UPDATE users SET `pdp` = '".$snapres['img']."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
}
else if (htmlspecialchars($_POST['Change']) === 'Change Facebook') {
		$bdd->query("UPDATE users SET `facebook` = '".htmlspecialchars($_POST['facebook'])."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
}
else if ($_POST['Change'] === 'Change Mail') {
	if ($_POST['mail1'] === htmlspecialchars($_POST['mail2']) && htmlspecialchars($_POST['mail1'])) {
		$bdd->query("UPDATE users SET `mail` = '".htmlspecialchars($_POST['mail1'])."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
	}
	else {
		$_SESSION['error'] = "A field is empty or fields don't match.";
		?>
		<meta http-equiv="refresh" content='0;URL=editacc.php'/>
		<?php
	}
}
else if (htmlspecialchars($_POST['Change']) === 'Change Password') {
	if (hash(whirlpool, htmlspecialchars($_POST['oldpwd'])) === $result['passwd']) {
		if (htmlspecialchars($_POST['newpwd1']) === htmlspecialchars($_POST['newpwd2']) && $_POST['newpwd1']) {
			$bdd->query("UPDATE users SET `passwd` = '".hash(whirlpool, htmlspecialchars($_POST['newpwd1']))."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
		}
		else {
			$_SESSION['error'] = "A field is empty or fields don't match.";
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
