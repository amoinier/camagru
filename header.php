<?php session_start();?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/font.css" charset="utf-8">
		<link rel="stylesheet" href="css/header.css" charset="utf-8">
		<link rel="stylesheet" media="(max-width: 1100px)" href="css/header-small.css" charset="utf-8">
		<link rel="stylesheet" href="css/index.css" charset="utf-8">
		<link rel="stylesheet" href="css/snap.css" charset="utf-8">
		<link rel="stylesheet" href="css/users.css" charset="utf-8">
		<link rel="stylesheet" media="(max-width: 2070px)" href="css/smallu.css" charset="utf-8">
		<link rel="stylesheet" href="css/editacc.css" charset="utf-8">
		<link rel="stylesheet" href="css/regfor.css" charset="utf-8">
		<title><?= $title?></title>
	</head>
	<body>
		<div class="bandeau">
			<a href="index.php"><span id='title'>InstaSnap</span></a>
			<div class="linebutton">
				<?php if ($_SESSION['login']) {?>
				<span class="button"><a href="logout.php">Logout</a></span>
				<span class="button"><a href="users.php?login=<?php echo $_SESSION['login']?>">Profile</a></span>
				<span class="button"><a href="snap.php">Take a snap!</a></span>
				<?php }?>
				<?php if (!$_SESSION['login']) {?>
					<span class="button"><a href="connect.php">Login</a></span>
				<?php }?>
				<span class="button"><a href="index.php">Home</a></span>
			</div>
		</div>
