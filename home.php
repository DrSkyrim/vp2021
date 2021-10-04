<?php
session_start();
	if(isset($_GET["logout"])){
	session_destroy();
	header("Location: page.php");
}
if(!isset($_SESSION["user_id"])){
header("Location: page.php");}
	$author_name = "Martin Lukas";
	require_once ("fnc_user.php");
	
	

	
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?>, veebiprogrammeerimine</title>
</head>
<body>
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<p>Oled sees.</p>
	<p><a href="?logout=1">Logi välja</a></p>

</body>
</html>