<?php
session_start();

if(!isset($_SESSION["user_id"])){
header("Location: page.php");}
	$author_name = "Martin Lukas";
	require_once ("fnc_user.php");
if(isset($_GET["logout"])){
	session_destroy();
	header("Location: page.php");
}
	require_once("page_header.php");

	
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>,, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<p>Oled sees.</p>
	<p><a href="listmovies.php">Filmide nimekiri</a></p>
	<p><a href="addfilms.php">Filmide lisamine</a></p>
	<p><a href="user_profile.php">Kasutaja Profiil</a></p>
	<p><a href="movie_relations.php">Filmi info seoste loomine</a></p>
	<p><a href="gallery_photo_upload.php">Fotode üleslaadimine</a></p>
	<p><a href="gallery_public.php">Sisseloginud kasutajatele avalik galerii</a></p>
	<p><a href="gallery_own.php">Minu omade fotode galerii</a></p>
	<p><a href="?logout=1">Logi välja</a></p>

</body>
</html>