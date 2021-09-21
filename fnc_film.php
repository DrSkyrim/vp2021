<?php
       $database = "if21_martin_lu";
	
    function read_all_films(){
		//var_dump($GLOBALS);
		//Loome andmebaasi yhenduse mysqli server,kasytaja,parool, andmebaas
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
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
		return $film_html;
    }
	
	function store_film($title_input,$year_input,$duration_input,$genre_input,$studio_input,$director_input){
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$conn->set_charset("utf8");
		//SQL: INSERT INTO film (pealkiri,aasta,kestus,zanr,tootja,lavastaja) VALUE("Suvi", 1976, 83, "Tallinnfilm", "Arvo Kruusement")
		$stmt = $conn->prepare("INSERT INTO film (pealkiri,aasta,kestus,zanr,tootja,lavastaja) VALUES (?,?,?,?,?,?)");
		echo $conn->error;
		//seome SQL käsuga pärisandmed
		//i-integer
		//d-decimal
		//s-string
		$stmt->bind_param("siisss", $title_input,$year_input,$duration_input,$genre_input,$studio_input,$director_input );
		//läsu täitmine
		$success = null;
			if($stmt->execute()){
				$success = "Salvestamine õnnestus";
			} else{
				$success = "Salvestamisel tekkis viga: " .$conn->error;
			}
		
		
		
		$stmt->close();
		//sulgen ab yhenduse
		$conn->close();
		return $success;
	}