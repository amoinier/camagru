<?php
session_start();
include('header.php');
include('config/setup.php');

$if = 0;
$log = $bdd->query("SELECT * FROM `users`;");
$result = $log->fetchAll();
if (!$_GET['ok']) {
	foreach ($result as $key => $val) {
		if (hash(whirlpool, htmlspecialchars($val['mail'])) === htmlspecialchars($_GET['recovery'])) {
			$if = 1;
			$log = $bdd->query("SELECT * FROM `users` WHERE `mail` LIKE '".$val['mail']."'");
			$ok = $log->fetch(); ?>
			<div id='login'>
				<form action="changepwd.php" method="post">
					<label for="login"><?= htmlspecialchars($ok['login']); ?></label>
					<label for="password"><br />Password</label>
					<input type="password" id='ipass' name="ipass" value="">
					<label for="password">Retape password</label>
					<input type="password" id='ipass2' name="ipass2" value="">
					<input type="hidden" id='imail' name='imail' value=<?php echo htmlspecialchars($val['mail']);?>>
					<input type="hidden" id="recovery" name="recovery" value="<?php echo "string"; $_GET['recovery'];?>">
					<input type="submit" name="submit" value="Change">
				</form></div>
				<?php if ($_SESSION['error']) { ?>
					<div id="errorbox"><div class="err"><?php echo $_SESSION['error'];
					$_SESSION['error'] = "";?></div></div>
				<?php }?>
				<?php
			}
		}
	}
else {
	$if = 1;
	?>
	<div id="validate">Your password is updated</div>
	<meta http-equiv="refresh" content='5;URL=index.php'/>
	<?php
}
if ($if == 0) {
?>
<div id="validate">The link is dead ...</div>
<meta http-equiv="refresh" content='5;URL=index.php'/>
<?php }
include('footer.php');?>
