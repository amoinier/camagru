<?php
session_start();
include('config/setup.php');

$login = sqlapo(htmlspecialchars($_POST['ilogin']));
$pass = sqlapo(htmlspecialchars($_POST['ipass']));

$log = $bdd->query("SELECT * FROM users WHERE `login` LIKE '".$login."';");
$result = $log->fetch();
if (htmlspecialchars($_POST['submit']) === 'Connect' && $login && $pass) {
	if (htmlspecialchars($result['login']) === $login)
	{
		if (hash(whirlpool, $pass) === htmlspecialchars($result['passwd'])) {
			if ($result['validate'] == 1) {
				$_SESSION['login'] = $login;
				?>
				<meta http-equiv="refresh" content='0;URL=index.php'/>
				<?php
			}
			else {
				$_SESSION['error'] = "Your account isn't validate.";
				?>
				<meta http-equiv="refresh" content='0;URL=connect.php'/>
				<?php
			}
		}
		else {
			$_SESSION['error'] = "Your password doesn't match with your login. <a id='forget' href='reinit.php'>Forget password ?</a>";
			?>
			<meta http-equiv="refresh" content='0;URL=connect.php'/>
			<?php
		}
	}
	else {
		$_SESSION['error'] = "This account doesn't exists.";
		?>
		<meta http-equiv="refresh" content='0;URL=connect.php'/>
		<?php
	}
}
else {
	$_SESSION['error'] = "A field is empty.";
	?>
	<meta http-equiv="refresh" content='0;URL=connect.php'/>
	<?php
}
?>
