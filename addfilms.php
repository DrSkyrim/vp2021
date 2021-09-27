<?php
	require_once("../../config.php");
	require_once("fnc_film.php");
	$author_name = "Martin Lukas";
	$film_store_notice = null;
	//Kas klikiti submit nuppu
	if(isset($_POST["film_submit"])){
		if(!empty($_POST["title_input"]) and !empty($_POST["genre_input"]) and !empty($_POST["studio_input"]) and !empty($_POST["director_input"])){
			$film_store_notice = store_film($_POST["title_input"],$_POST["year_input"],$_POST["duration_input"],$_POST["genre_input"],$_POST["studio_input"],$_POST["director_input"]);
		} else{
				$film_store_notice = "Osa andmeid on puudu!";
		}
		if(empty($_POST["title_input"])){$film_store_notice="Sisetage pealkiri!";}
		if(empty($_POST["genre_input"])){$film_store_notice="Sisetage zanr";}
		if(empty($_POST["studio_input"])){$film_store_notice="Sisetage stuudio!";}
		if(empty($_POST["director_input"])){$film_store_notice="Sisetage lavastaja!";}
		$film_title=$_POST["title_input"];
		$film_genre=$_POST["genre_input"];
		$film_studio=$_POST["studio_input"];
		$film_producer=$_POST["producer_input"];
	}
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
	<p>Õppetöö toimus 2021 sügisel.</p>
	<hr>
	<h2>Eesti filmid</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">>
		<label for="title_input">Filmi pealkiri: </label>
		<input type="text" name="title_input" id="title_input" placeholder="pealkiri" value="<?php echo $film_title; ?>">
		<br>
		<label for="year_input"> Valmimisaasta: </label>
		<input type="number" name="year_input" id="year_input" value="<?php echo date("Y")?>" min="1912">
		<br>
		<label for="duration_input"> Kestus(min): </label>
		<input type="number" name="duration_input" id="duration_input" value="80" min="1">
		<br>
		<label for="genre_input">Filmi zanr: </label>
		<input type="text" name="genre_input" id="genre_input" placeholder="zanr" value="<?php echo $film_genre; ?>">
		<br>		
		<label for="studio_input">Filmi tootja: </label>
		<input type="text" name="studio_input" id="studio_input" placeholder="tootja" value="<?php echo $film_studio; ?>">
		<br>
		<label for="director_input">Filmi lavastaja: </label>
		<input type="text" name="director_input" id="director_input" placeholder="lavastaja" value="<?php echo $film_producer; ?>">
		<br>
		<input type="submit" name="film_submit" value="Salvesta!">
	</form>
	<br>
	<span><?php echo $film_store_notice ?> </span>
		
</body>
</html>