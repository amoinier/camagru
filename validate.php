<?php
session_start();
include('header.php');
include('config/access.php');

$log = $bdd->query("SELECT `*` FROM `users`;");
$result = $log->fetchAll();
foreach ($result as $key => $val) {
	if (hash(whirlpool, $val['mail']) === $_GET['validate']) {
		$log = $bdd->query("SELECT `*` FROM `users` WHERE `mail` LIKE '".$val['mail']."'");
		$ok = $log->fetch();
		$log = $bdd->query("UPDATE `users` SET `validate` = '1' WHERE `users`.`id` = ".$ok['id']);
		$_SESSION['login'] = $ok['login'];
		?>
		<div id="validate">Your account is realised. You will be redirected in 5 secondes ...</div>
		<meta http-equiv="refresh" content='5;URL=index.php'/>
		<?php
	}
}
?>
<div id="validate">The link is dead or this account is already activate ...</div>
<meta http-equiv="refresh" content='5;URL=index.php'/>
<?php
include('footer.php');?>
