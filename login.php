<?php
session_start();
include('config/access.php');

$log = $bdd->query("SELECT `*` FROM users WHERE `login` LIKE '".$_POST['ilogin']."';");
$result = $log->fetch();
if ($_POST['ilogin'] && $_POST['ipass']) {
	if ($result['login'] === $_POST['ilogin'])
	{
		if (hash(whirlpool, $_POST['ipass']) === $result['passwd']) {
			$_SESSION['login'] = $_POST['ilogin'];
			?>
			<meta http-equiv="refresh" content='0;URL=index.php'/>
			<?php
		}
		else {
			$_SESSION['error'] = "Your password doesn't match with your login.";
			?>
			<meta http-equiv="refresh" content='0;URL=index.php'/>
			<?php
		}
	}
	else {
		$_SESSION['error'] = "This account doesn't exists.";
		?>
		<meta http-equiv="refresh" content='0;URL=index.php'/>
		<?php
	}
}
else {
	$_SESSION['error'] = "A field is empty.";
	?>
	<meta http-equiv="refresh" content='0;URL=index.php'/>
	<?php
}
?>
