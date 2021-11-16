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
	require_once("fnc_gallery.php");
	$public_from=2;
	$page=1;
	$limit=5;
	$photo_count=count_public_photos($public_from);
	//echo $photo_count;
	if(!isset($_GET["page"]) or $_GET["page"] <1 ){
		$page=1;
	} elseif(round($_GET["page"]-1) * $limit >= $photo_count){
		$page = ceil($photo_count/$limit);
	} else {
		$page=$_GET["page"];
	}
	
	$to_head = '<link rel="stylesheet" type="text/css" href="style/gallery.css">' ."\n";
	$to_head .= '<link rel="stylesheet" type="text/css" href="style/modal.css">' ."\n";
	$to_head .= '<script src="javascript/modal.js" defer></script>'."\n";
    require("page_header.php");
?>
	<!--modaalaken galeriipildi naitamiseks-->
	<div id="modalarea" class="modalarea">
	<span id="modalclose" class="modalclose">&times;</span>
	<div class="modalhorisonatal"><div class="modalvertical"><p id="modalcaption"></p><img id="modalimg" src="/Pics/empty.png" alt="Galeriipilt">
	<br>
	<input id="rate1" name="rate" type="radio" value="1"><label for="rate1">1</label>
	<input id="rate2" name="rate" type="radio" value="2"><label for="rate1">2</label>
	<input id="rate3" name="rate" type="radio" value="3"><label for="rate1">3</label>
	<input id="rate4" name="rate" type="radio" value="4"><label for="rate1">4</label>
	<input id="rate5" name="rate" type="radio" value="5"><label for="rate1">5</label>
	<button id="storeRating" type="button">Salvesta hinne</button>
	<br>
	<p id="avgRating"></p>
	</div>
	</div>
	</div>
	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
    <ul>
        <li><a href="?logout=1">Logi välja</a></li>
		<li><a href="home.php">Avaleht</a></li>
    </ul>
	<hr>
    <h2>Avalike fotode galerii</h2>
	<div id="gallery" class="gallery">
	<p>
	<?php
	//echo "muutuja". $page. "     ";
	//echo $_GET['page'];
	//<span>Eelmine leht</span> | <span>Jargmine leht</span> 
	if ($page > 1){
		echo '<span><a href="?page='.($page-1) .'">Eelmine leht</a></span> | ';
	} else{
		echo '<span>Eelmine leht</span> | ';
		}
		if($page * $limit < $photo_count){
			echo '<span><a href="?page='.($page+1) .'">Jargmine leht</a></span>';
	} else{
		echo '<span>Jargmine leht</span>;';
	}
	?>
	</p>
	</div>
   
   <div> <?php echo read_public_photo_thumbs($public_from,$page,$limit); ?>
   </div>
</body>
</html>