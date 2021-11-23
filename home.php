<?php
	require_once("use_session.php");
	//require_once("classes/Test.class.php");
	//$test_object = new Test(27);
	//echo $test_object->secret_number;
	//echo "Avalik number on: " .$test_object->public_number;
	//$test_object->reveal();
	//unset($test_object);'
	
	//cookie näide
	setcookie("vp_visitor",$_SESSION["first_name"]." ".$_SESSION["last_name"],time()+(86400*9), "/~marluk/vp2021","greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
	$last_visitor = null;
	if(isset($_COOKIE["vp_visitor"])){
		$last_visitor= "<p>Viimati külastas lehte selles arvutis ".$_COOKIE["vp_visitor"]."</p> \n";
	} else {
		$last_visitor= "<p>Küpsiseid pole, viimane külastaja teadmata</p> \n";
	}
	
	//var_dump($_COOKIE);
	//cookie muutmine on lihtsalt uue väärtusega ümberkirjutamine
	//Kustutamiseks kirjutatakse teda ümber aegumis tähtajaga mis on minevikus
	//näiteks time()-3600
	
	require_once("page_header.php");

	
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>,, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<p>Oled sees.</p>
	<hr><?php echo $last_visitor ?>
	<hr>
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