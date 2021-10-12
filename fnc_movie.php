<?php
       $database = "if21_martin_lu";
	   function read_all_person_for_option($selected){
		   $option_html=null;
		   $conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		   $conn->set_charset("utf8");
		   $stmt = $conn->prepare("SELECT * FROM person");
		   echo $conn->error;
		   $stmt->bind_result($id_from_db,$firstname_from_db,$lastname_from_db,$birthdate_from_db);
		   $stmt->execute();
		    //<option value="x" selected>Eesnimi Perekonnanimi(Synniaeg)</option>
		   while($stmt->fetch()){
			  $option_html .='<option value="'.$id_from_db.'"';
			  if($id_from_db == $selected){
				  $option_html .=" selected";
			  }
			  $option_html .= ">" .$firstname_from_db. " ". $lastname_from_db. " (". $birthdate_from_db .")</option> \n";
		   }
		 $stmt->close();
		//sulgen ab yhenduse
		$conn->close();
		return $option_html;
	   }
	   	  function read_all_movie_for_option($movie_selected){
		  $movie_option_html=null;
		  $conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		  $conn->set_charset("utf8");
		  $stmt = $conn->prepare("SELECT id,title,production_year FROM movie");
		  echo $conn->error;
		  $stmt->bind_result($movieid_from_db,$title_from_db,$prodyear_from_db);
		  $stmt->execute();
		    //<option value="x" selected>Eesnimi Perekonnanimi(Synniaeg)</option>
		   while($stmt->fetch()){
			  $movie_option_html .='<option value="'.$movieid_from_db.'"';
			  if($movieid_from_db == $movie_selected){
				  $movie_option_html .=" selected";
			  }
			  $movie_option_html .= ">" .$title_from_db. " (". $prodyear_from_db .")</option> \n";
		   }
		$stmt->close();
		//sulgen ab yhenduse
		$conn->close();
		return $movie_option_html;
	   }
	   	  function read_all_positions_for_option($position_selected){
		  $position_option_html=null;
		  $conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		  $conn->set_charset("utf8");
		  $stmt = $conn->prepare("SELECT id,position_name FROM position");
		  echo $conn->error;
		  $stmt->bind_result($id_from_db,$position_from_db);
		  $stmt->execute();
		    //<option value="x" selected>Eesnimi Perekonnanimi(Synniaeg)</option>
		   while($stmt->fetch()){
			  $position_option_html .='<option value="'.$id_from_db.'"';
			  if($id_from_db == $position_selected){
				  $position_option_html .=" selected";
			  }
			  $position_option_html .= ">" .$position_from_db. "</option> \n";
		   }
		$stmt->close();
		//sulgen ab yhenduse
		$conn->close();
		return $position_option_html;
	   }
	   	function store_person_photo($file_name, $person_id){
		$photo_submit_notice=null;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("INSERT INTO picture (picture_file_name,person_id) VALUES (?, ?)");
		$stmt->bind_param("si",$file_name,$person_id);
		if($stmt->execute()){
			$photo_submit_notice="Uus foto edukalt laetud";
		}
		else{
			$photo_submit_notice="Foto laadimisel tekkis viga".$stmt->error;
		}
	}
	//vana osa
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
	    function store_person_in_movie($selected_person, $selected_movie, $selected_position, $role){
        $notice = null;
       $conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
        $conn->set_charset("utf8");
        //<option value="x" selected>Film</option>
        $stmt = $conn->prepare("SELECT id FROM person_in_movie WHERE person_id = ? AND movie_id = ? AND position_id = ? AND role = ?");
        $stmt->bind_param("iiis", $selected_person, $selected_movie, $selected_position, $role);
        $stmt->bind_result($id_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            //selline on olemas
            $notice = "Selline seos on juba olemas!";
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO person_in_movie (person_id, movie_id, position_id, role) VALUES (?, ?, ?, ?)"); 
            $stmt->bind_param("iiis", $selected_person, $selected_movie, $selected_position, $role);
            if($stmt->execute()){
                $notice = "Uus seos edukalt salvestatud!";
            } else {
                $notice = "Uue seose salvestamisle tekkis viga: " .$stmt->error;
            }
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }
