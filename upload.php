<?php
header('Location: snap.php');
session_start();
if (!file_exists("upload"))
	mkdir("upload");
$fichier = basename($_FILES['upload-photo']['name']);
print_r($fichier);
$extensions = array('.png', '.jpg', '.jpeg', '.JPG');
$extension = strrchr($_FILES['upload-photo']['name'], '.');
if(in_array($extension, $extensions)) {
	if(filesize($_FILES['upload-photo']['tmp_name']) < 1000000){
		$fichier = strtr($fichier,
			'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
			'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
		$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
		$name = "upload/".time().$fichier;
		if(move_uploaded_file($_FILES['upload-photo']['tmp_name'], $name))
			$_SESSION['upload'] = $name;
		else
			$_SESSION['upload'] = -1;
	}
	else
		$_SESSION['upload'] = -1;
}
else
	$_SESSION['upload'] = -1;
?>
