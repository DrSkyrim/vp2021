<?php
 //alustame sessiooni
    session_start();
    //kas on sisselogitud
    if(!isset($_SESSION["user_id"])){
        header("Location: page.php");
    }
    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
    }
	require_once("../../config.php");
	require_once("fnc_film.php");
	$author_name = "Martin Lukas";
	$film_html = null;
	$film_html = read_all_films();
	
	require_once("page_header.php");
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p><a href="addfilms.php">Filmide lisamine</a></p>
	<p><a href="home.php">Avalehele</a></p>
	<p><a href="?logout=1">Logi välja</a></p>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<p>Õppetöö toimus 2021 sügisel.</p>
	<hr>
	<h2>Eesti filmid</h2>
	<?php echo $film_html ?>
	
		
</body>
</html>