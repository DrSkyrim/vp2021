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
	//require_once("fnc_foto_upload.php");
	require_once("fnc_general.php");



	
	
	
	$photo_submit_notice=null;
	$photo_upload_orig_dir = "upload_photos_orig/";
	$photo_upload_normal_dir = "upload_photos_normal/";
	$photo_upload_thumb_dir = "upload_photos_thumb/";
	$file_name_prefix = "vp_";
	$alt_text=null;
	$privacy=1;
	$file_type=null;
	$file_name=null;
	if(isset($_POST["photo_submit"])){
		//var_dump($_POST);
		//var_dump($_FILES);
		if(isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])){
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
						$file_name= $file_name_prefix .$timestamp .".".$file_type;
						if(move_uploaded_file($_FILES["photo_input"]["tmp_name"], $photo_upload_orig_dir .$file_name)){
							//$photo_submit_notice= store_person_photo($file_name,$_POST["person_select_for_photo"]);
						}
						else{
							$photo_submit_notice="foto yleslaadimine ei onnestunud";
						}
				}
				else{
					$photo_submit_notice="Valitud fail ei ole pilt";
				}
			
		}
		else{
			$photo_submit_notice="Fotofail on valimata!";
		}
	}
	//kui klikitti submiti
	require_once("page_header.php");
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<p>Õppetöö toimus 2021 sügisel.</p>
	<hr>

		<h3>Fotode üleslaadimine </h3>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<label for="photo_input"> Vali foto fail</label>
		<input type="file" name="photo_input" id="photo_input">
		<br>
		<label for="alt_input">Alternatiiv text(alt)</label>
		<input type="text" name="alt_input" id="alt_input" placeholder="Pildi alternatiiv text" value="<?php echo $alt_text; ?>">
		<br>
		<input type="radio" name="privacy_input" id="privacy_input_1" value="1" <?php if($privacy==1){echo " checked";}?>>
		<label for="privacy_input_1">Privaatne(Ainult mina näen)</label>
		<br>
		<input type="radio" name="privacy_input" id="privacy_input_2" value="2" <?php if($privacy==2){echo " checked";}?>>
		<label for="privacy_input_2">Sisseloginud kasutajad näevad</label>
		<br>
		<input type="radio" name="privacy_input" id="privacy_input_3" value="3" <?php if($privacy==3){echo " checked";}?>>
		<label for="privacy_input_3">Avalik</label>
		<br>
		<input type="submit" name="photo_submit" value="Lae pilt yles">
		</form>
		<p><?php echo $photo_submit_notice; ?></p>

	<br>
	
	<p><a href="home.php">Avalehele</a></p>
	<p><a href="?logout=1">Logi välja</a></p>
		
</body>
</html>