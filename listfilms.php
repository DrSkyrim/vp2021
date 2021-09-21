<?php
	require_once("../../config.php");
	
	$author_name = "Martin Lukas";
	
	$database = "if21_martin_lu";
	//Loome andmebaasi yhenduse mysqli server,kasytaja,parool, andmebaas
	$conn = new mysqli($server_host,$sever_user_name,$server_password,$database);
	//maarame oige kodeeringu
	$conn->set_charset("utf8");
	//valmistan ette sql paring: Select * FROm film
	$stmt = $conn->prepare("SELECT * FROM film");
	echo $conn->error;
	//seon tulemused muutujaga
	$stmt->bind_result($Title_from_db, $year_from_db, $length_from_db, $genre_from_db, $studio_from_db, $producer_from_db);
	//taidan kasu
	$film_html = null ;
	$stmt->execute();
	//votttan kirjeid kuni jatkub
	while($stmt->fetch()){
	
		//<h3>Filmi nimi</h3>
		//<ul>
		//<li> Valmimisaasta
		//<li>
		//</ul>
		$film_html .= "<h3>" .$Title_from_db ."</h3>";
		$film_html .= "<ul>";
		$film_html .= "<li>Valmimisaasta ". $year_from_db."</li>";
		$film_html .= "<li>Kestus " .$length_from_db ."</li>";
		$film_html .= "<li>Zanr ". $genre_from_db."</li>";
		$film_html .= "<li>Stuudio ". $studio_from_db."</li>";
		$film_html .= "<li>Lavastaja ". $producer_from_db."</li>";
		$film_html .= "</ul> \n";
	}
	//sulgen kask
	$stmt->close();
	//sulgen ab yhenduse
	$conn->close();
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
	<?php echo $film_html ?>
		
</body>
</html>