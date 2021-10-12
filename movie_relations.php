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
	require_once("fnc_movie.php");
	require_once("fnc_general.php");
	$notice = null;
	
	$person_in_movie_notice=null;
	$selected_person_for_relation=null;
	$movie_in_movie_notice=null;
	$selected_movie_for_relation=null;
	$position_in_movie_notice=null;
	$selected_position_for_relation=null;
	$photo_submit_notice=null;
	 $role = null;
	if(isset($_POST["person_in_movie_submit"])){
		if(isset($_POST["person_select"]) and !empty($_POST["person_select"])){
			$selected_person_for_relation = filter_var($_POST["person_select"], FILTER_VALIDATE_INT);
		}
		if(empty($selected_person_for_relation)){
			$person_in_movie_notice .= "Isik on valimata! ";
		}
	}
		if(isset($_POST["person_in_movie_submit"])){
		if(isset($_POST["movie_select"]) and !empty($_POST["movie_select"])){
			$selected_movie_for_relation = filter_var($_POST["movie_select"], FILTER_VALIDATE_INT);
		}
		if(empty($selected_movie_for_relation)){
			$movie_in_movie_notice .= "Film on valimata! ";
		}
	}
	if(isset($_POST["person_in_movie_submit"])){
		if(isset($_POST["position_select"]) and !empty($_POST["position_select"])){
			$selected_position_for_relation = filter_var($_POST["position_select"], FILTER_VALIDATE_INT);
		}
	}
		if(empty($selected_position_for_relation)){
			$position_in_movie_notice .= "Positioon on valimata! ";
		}
		if($selected_position_for_relation == 1){
            if(isset($_POST["role_input"]) and !empty($_POST["role_input"])){
                $role = test_input(filter_var($_POST["role_input"], FILTER_SANITIZE_STRING));
            }
            if(empty($role)){
                $person_in_movie_notice .= "Roll on kirja panemata! ";
            }
        }
        
        if(empty($person_in_movie_notice)){
            $person_in_movie_notice = store_person_in_movie($selected_person_for_relation, $selected_movie_for_relation, $selected_position_for_relation, $role);
        }
	$person_photo_dir = "person_photos/";
	$file_type=null;
	$file_name=null;
	if(isset($_POST["person_photo_submit"])){
		//var_dump($_POST);
		//var_dump($_FILES);
		$imgcheck = getimagesize($_FILES["photo_input"]["tmp_name"]);
			if($imgcheck !== false){
				if($imgcheck["mime"] == "image/jpeg"){
					$file_type = "jpg";
				}
				if($imgcheck["mime"] == "image/png"){
					$file_type = "png";
					}
				if($imgcheck["mime"] == "image/gif"){
					$file_type = "gif";
					}
					//teen ajatempli
					$timestamp = microtime(1)*10000;
					//moodustan failinime
					$file_name= "person_" .$_POST["person_select_for_photo"]."_".$timestamp .".".$file_type;
					if(move_uploaded_file($_FILES["photo_input"]["tmp_name"], $person_photo_dir .$file_name)){
						$photo_submit_notice= store_person_photo($file_name,$_POST["person_select_for_photo"]);
					}
					else{
						$photo_submit_notice="foto yleslaadimine ei onnestunud";
					}
			}
		
	}
	require_once("page_header.php");
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<p>Õppetöö toimus 2021 sügisel.</p>
	<hr>
	<h2>Filmi info seostamine</h2>
	<h3>Film,Inimene ja tema roll </h3>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="person_select">Isik</label>
		<select name="person_select" id="person_select">
			<option value="" selected disabled>Vali isik</option>
			<?php echo read_all_person_for_option($selected_person_for_relation);?>
		</select>
		<label for="movie_select">Film</label>
		<select name="movie_select" id="movie_select">
			<option value="" selected disabled>Vali film</option>
			<?php echo read_all_movie_for_option($selected_movie_for_relation);?>
		</select>
		<label for="position_select">Positsioon</label>
		<select name="movie_select" id="movie_select">
			<option value="" selected disabled>Vali positsioon</option>
			<?php echo read_all_positions_for_option($selected_position_for_relation);?>
		</select>
		 <label for="role_input">
        <input type="text" name="role_input" id="role_input" placeholder="tegelase nimi" value="<?php echo $role; ?>">
        
        <input type="submit" name="person_in_movie_submit" value="Salvesta">
	</form>
		<span><?php echo $person_in_movie_notice;?> </span>
		<span><?php echo $movie_in_movie_notice;?> </span>
		<span><?php echo $position_in_movie_notice;?> </span>
		<h3>Tegelase foto </h3>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
			<label for="person_select_for_photo">Isik</label>
			<select name="person_select_for_photo" id="person_select_for_photo">
				<option value="" selected disabled>Vali isik</option>
				<?php echo read_all_person_for_option($selected_person_for_photo);?>
		</select>
		<label for="photo_input"> Vali foto fail</label>
		<input type="file" name="photo_input" id="photo_input">
			<input type="submit" name="person_photo_submit" value="Lae pilt yles">
		</form>
		<p><?php echo $photo_submit_notice; ?></p>
	<br>
	
	<p><a href="home.php">Avalehele</a></p>
	<p><a href="?logout=1">Logi välja</a></p>
		
</body>
</html>