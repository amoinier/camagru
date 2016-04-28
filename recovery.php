<?php
session_start();
include('header.php');
include('config/access.php');

$if = 0;
$log = $bdd->query("SELECT * FROM `users`;");
$result = $log->fetchAll();
foreach ($result as $key => $val) {
	if (hash(whirlpool, htmlspecialchars($val['mail'])) === htmlspecialchars($_GET['recovery'])) {
		$if = 1;
		$log = $bdd->query("SELECT * FROM `users` WHERE `mail` LIKE '".$val['mail']."'");
		$ok = $log->fetch(); ?>
		<div id='login'>
		<form action="recovery.php" method="post">
			<label for="login"><?= htmlspecialchars($ok['login']); ?></label>
			<label for="password"><br />Password</label>
			<input type="password" id='ipass' name="ipass" value="">
			<label for="password">Retape password</label>
			<input type="password" id='ipass2' name="ipass2" value="">
			<input type="hidden" id='imail' name='imail' value=<?php echo htmlspecialchars($val['mail']);?>>
			<input type="submit" name="submit" value="Change">
		</form></div>
		<?php
	}
}
if ($if == 0) {
?>
<div id="validate">The link is dead ...</div>
<meta http-equiv="refresh" content='5;URL=index.php'/>
<?php }
include('footer.php');?>
