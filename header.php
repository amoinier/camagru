<?php session_start();?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/font.css" charset="utf-8">
		<link rel="stylesheet" href="css/header.css" charset="utf-8">
		<link rel="stylesheet" href="css/index.css" charset="utf-8">
		<title><?= $title?></title>
	</head>
	<body>
		<div class="bandeau">
			<a href="index.php"><span id='title'>InstaSnap</span></a>
			<div class="linebutton">
				<?php if ($_SESSION['login']) {?>
				<span class="button"><a href="logout.php">Logout</a></span>
				<span class="button"><a href="#">Take a snap!</a></span>
				<span class="button"><a href="#">Home</a></span>
				<?php }?>
			</div>
		</div>
<?php include('footer.php');?>
