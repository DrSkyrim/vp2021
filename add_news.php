<?php
require_once("use_session.php");
	
	require_once("../../config.php");
	require_once("fnc_photo_upload.php");
    require_once("fnc_general.php");
	require_once("classes/Photo_upload.class.php");
    
    $news_notice = null;
	$expire= new DateTime("now");
	$expire->add(new DateInterval("P7D"));
	$expire_date=date_format($expire,"Y-m-d");
    $normal_photo_max_width = 600;
    $normal_photo_max_height = 400;
	$allowed_photo_types = ["image/jpeg", "image/png", "image/gif"];
    $photo_filename_prefix = "vpnews_";
    $photo_upload_size_limit = 1024 * 1024;
    $thumbnail_width = $thumbnail_height = 100;
	
    if(isset($_POST["news_submit"])){
		//Uudisele v]ib aga ei pea lisama pilti
		//kui pilt on valitud tasub seda esimesena serverisse ja ABsse salvestada
		//just lisatud kirje id saab k2tte $added_id = $conn->insert id;
		//siis saate uudise enda koos tema foro idega salvestada
		//uudise sisu kontrollimiseks kindlasti kasutada test_input funktsiooni(fnc_general)
		//seal on htmlspecialchars(uudis), mis kodeerib ymber htmlm2rgid ringi
		//Uudiste n2itamisel htmlspecialchars_decode(uudis_andmebaasist) selleks et neid tagasi saada
		//uudise n2itamisel v6rdlen "t2nase p2evaga"
		//$today = date("Y-m-d")
		// SQL lauses WHERE expire >= ?
    }
    //$to_head = '<script src="javascript/checkfilesize.js" defer></script>'."\n";
	$to_head ='<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>'."\n";
    require("page_header.php");
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
    <ul>
        <li><a href="?logout=1">Logi välja</a></li>
		<li><a href="home.php">Avaleht</a></li>
    </ul>
	<hr>
    <h2>Uudise lisamine</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        
        <!--vaja oleks ka text tyypi sisendit pealkirjaks-->
		<label for="news_input">Uudise sisu</label>
		<br>
		<textarea id="news_input" name="news_input"></textarea>
		<script> CKEDITOR.replace( 'news_input' );</script>
		<br>
		<input type="date" id="expire_input" name="expire_input" value="<?php echo $expire_date?>">
		<label for="photo_input"> Vali pildifail! </label>
        <input type="file" name="photo_input" id="photo_input">
        <br>
		<input type="submit" name="news_submit" id="news_submit" value="Salvesta uudis">
    </form>
    <span><?php echo $news_notice; ?></span>
</body>
</html>