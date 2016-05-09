<?php
session_start();
include('header.php');
include('config/setup.php');

$log = $bdd->query("SELECT * FROM `users`;");
$result = $log->fetchAll();
$i = 0;
foreach ($result as $key => $val) {
	if (hash(whirlpool, htmlspecialchars($val['mail'])) === htmlspecialchars($_GET['validate']) && !$val['validate']) {
		$i = 1;
		$log = $bdd->query("SELECT * FROM `users` WHERE `mail` LIKE '".htmlspecialchars($val['mail'])."'");
		$ok = $log->fetch();
		$log = $bdd->query("UPDATE `users` SET `validate` = '1' WHERE `users`.`id` = ".$ok['id']);
		$_SESSION['login'] = htmlspecialchars($ok['login']);
		?>
		<div id="validate">Your account is realised. You will be redirected in 5 secondes ...</div>
		<meta http-equiv="refresh" content='5;URL=index.php'/>
		<?php
	}
}
if (!$i) {
?>
<div id="validate">The link is dead or this account is already activate ...</div>
<meta http-equiv="refresh" content='5;URL=index.php'/>
<?php
}
?>
<div class="footerind">
	<div id="copyr"> InstaSnap &copy; amoinier, 2016</div>
</div>
</body>
</html>
