<?php
require_once("use_session.php");
	require_once("../../config.php");
	require_once("fnc_user.php");
	require_once("fnc_general.php");
	$notice = null;
	$description=read_user_description();//tulevikus loetakse andmetabelist olemasolev kirjeldus
	$bgcolor=null;
	$color=null;
	if(isset($_POST["profile_submit"])){
	$notice=profile_save($_POST["description_input"],$_POST["bg_color_input"],$_POST["text_color_input"]);
	}
	require_once("page_header.php");
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingit tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<p>Õppetöö toimus 2021 sügisel.</p>
	<hr>
	<h2>Kasutaja Profiil</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">>
		<label for="description_input">Minu lyhikirjeldus</label>
		<br>
		<textarea name="description_input" id="description_input" rows="10" cols="80" placeholder="Minu lyhikirjeldus..."><?php echo $description;?></textarea>
		<br>
		<label for="bg_color_input">Taustavarv</label>
		<input type="color" name="bg_color_input" id="bg_color_input" value="<?php echo $_SESSION["bg_color"];?>">
		<br>
		<label for="text_color_input">Tesktivarv</label>
		<input type="color" name="text_color_input" id="text_color_input" value="<?php echo $_SESSION["text_color"];?>">
		<br>
		<input type="submit" name="profile_submit" value="Salvesta!">
	</form>
	<br>
	<span><?php echo $notice; ?> </span>
	<p><a href="home.php">Avalehele</a></p>
	<p><a href="?logout=1">Logi välja</a></p>
		
</body>
</html>