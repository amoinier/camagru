<?php
session_start();
include('config/access.php');

$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".$_POST['ilogin']."';");
$result = $log->fetch();
if ($_POST['submit'] === 'Connect' && $_POST['ilogin'] && $_POST['ipass']) {
	if ($result['login'] === $_POST['ilogin'])
	{
		if (hash(whirlpool, $_POST['ipass']) === $result['passwd']) {
			if ($result['validate'] == 1) {
				$_SESSION['login'] = $_POST['ilogin'];
				?>
				<meta http-equiv="refresh" content='0;URL=index.php'/>
				<?php
			}
			else {
				$_SESSION['error'] = "Your account isn't validate.";
				?>
				<meta http-equiv="refresh" content='0;URL=index.php'/>
				<?php
			}
		}
		else {
			$_SESSION['error'] = "Your password doesn't match with your login. <a id='forget' href='reinit.php'>Forget password ?</a>";
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
