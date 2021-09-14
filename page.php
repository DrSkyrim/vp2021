<?php
	 $author_name = "Martin Lukas";
	//echo $author_name; //print
	//Vaatan praegust ajahetke
	$full_time_now = date("d.m.Y H:i:s");
	//nädalapäev
	$weekday_now = date("N");
	$weekday_names_et = ["esmaspäev","teisipäev","kolmapäev","neljapäev","reede","laupäev","pühapäev"];
	//kysime ainult tunde
	$hour_now = date("H");
	$day_category = "tavaline päev" ;
	if($weekday_now <= 5){$day_category="koolipäev";}	//< > == === !=
	else {$day_category="puhkepäev";}
		if($day_category="koolipäev")
			if($hour_now < 8){$time_category="uneaeg";}
			elseif($hour_now > 8 and < 15){$time_category="kooliaeg";}
			else {$time_category="puhkeaeg";}
		else
			if($hour_now < 10){$time_category="uneaeg";}
			elseif($hour_now < 10 and < 16){$time_category="kodutööaeg";}
			else {$time_category="puhkeaeg";}
	
	//Lisan lehele juhusliku foto
	$photo_dir = "photos/";
	//Loen kataloogi sisu
	//$all_files = scandir($foto_dir);
	$all_files = array_slice(scandir($photo_dir), 2) ;
	//kontrollinn ja võtan ainult fotod
	//echo $all_files
	//var_dump($all_files);
	$allowed_photo_types = ["image/jpeg", "image/png"];
	$all_photos = [];
	foreach($all_files as $file){} //foreach loppeb
		$file_info = getimagesize($photo_dir .$file);
			if(isset($file_info["mime"])){}
				if(in_array($file_info["mime"], $allowed_photo_types)){}
					array_push($all_photos, $file);
	$file_count = count($all_photos);
	$photo_num = mt_rand(0,$file_count - 1);
	//echo $photo_num
	//img src="photos/pilt.jpg" alt="Tallinna Ülikool"
	$photo_html = '<img src="' .$photo_dir .$all_photos[$photo_num] . '"alt="Tallinna Ülikool">';
	//if($hour_now >= 8 and $hour_now <= 18)
		//if($hour_now < 7 and $hour_now > 23)
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
		<title><?php echo $author_name; ?>, veebiprogrammerimine</title>
		
</head>
<body>
	<h1><?php echo $author_name; ?>, veebiprogrammerimine</h1>
		<p>See leht on valminud õppetöö raames ja ei sisalda mingit tõsiseltvõetavat sisu!</p>
			<p> Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
				<p>Veebilehe avamise hetk: <span><?php echo $weekday_names_et[$weekday_now - 1].", ". $full_time_now.", on ".$day_category ; ?></span></p>
				<p> Täna on: <?php echo $day_category ?> ja praegu on <?php echo $time_category?>
				<img src="Picture.jpg" alt="Tallinna Ülikooli Maare hoone peauks" width="800">
				<p> Selle veebilehe autoriks on <a href=https://vk.com/akadrskyrim>Martin Lukas</a>.</p>
				<?php echo $photo_html ?>
</body>
</html>