<?php
header('Location: editacc.php');
session_start();
include('config/setup.php');
$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".$_SESSION['login']."';");
$result = $log->fetch();
if (htmlspecialchars($_POST['pdpch']) === 'pdpch' && is_numeric($_POST['pid'])) {
	$snap = $bdd->query("SELECT * FROM snap WHERE `id` LIKE ".htmlspecialchars($_POST['pid']).";");
	$snapres = $snap->fetch();
	$bdd->query("UPDATE users SET `pdp` = '".$snapres['img']."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
}
else if (htmlspecialchars($_POST['Change']) === 'Change Facebook' && !strchr($_POST['facebook'], "'")) {
		$bdd->query("UPDATE users SET `facebook` = '".sqlapo(htmlspecialchars($_POST['facebook']))."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
}
else if (htmlspecialchars($_POST['Change']) === 'Change Mail') {
	if (htmlspecialchars($_POST['mail1']) === htmlspecialchars($_POST['mail2']) && htmlspecialchars($_POST['mail1']) && !strchr($_POST['mail1'], "'") && preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', htmlspecialchars($_POST['mail1']))) {
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
		if (htmlspecialchars($_POST['newpwd1']) === htmlspecialchars($_POST['newpwd2']) && $_POST['newpwd1'] && !strchr($_POST['newpwd1'], "'") && strlen(htmlspecialchars($_POST['newpwd1'])) >= 6) {
			$bdd->query("UPDATE users SET `passwd` = '".hash(whirlpool, htmlspecialchars($_POST['newpwd1']))."' WHERE `users`.`login` LIKE '".$_SESSION['login']."';");
		}
		else {
			$_SESSION['error'] = "A field is empty, fields don't match or password too small (min. 6 chars).";
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
