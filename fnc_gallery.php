<?php
	$database = "if21_martin_lu";
	function show_latest_public_photo(){
		$photo_html=null;
		$privacy=3;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT filename,alttext FROM vpr_photos WHERE id=(SELECT MAX(id) FROM vpr_photos WHERE privacy = ? AND deleted IS NULL)");
		echo $conn->error;
		$stmt->bind_param("i",$privacy);
		$stmt->bind_result($filename_from_db,$alttext_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			//<img src="kataloog/filename" alt="alttext">
			$photo_html .= '<img src="'.$GLOBALS["photo_normal_upload_dir"].$filename_from_db .'" alt="';
			if(empty($alttext_from_db)){
				$photo_html .= "Üleslaetud foto";
			} else{
				$photo_html .= $alttext_from_db;
			}
			$photo_html.='">' ."\n";
		} else{
			$photo_html = "<p>Kahjuks avalike fotosid üleslaetud ei ole</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $photo_html;
	}
	function read_public_photo_thumbs($privacy, $page, $limit){
		$photo_html=null;
		$skip = ($page-1) * $limit;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT filename,alttext FROM vpr_photos WHERE privacy>=? AND deleted IS NULL ORDER BY id DESC LIMIT ?, ?");
		//$stmt = $conn->prepare("SELECT filename,alttext FROM vpr_photos WHERE privacy>=? AND deleted IS NULL");
		//$stmt = $conn->prepare("SELECT filename,alttext FROM vpr_photos WHERE privacy>=? AND deleted IS NULL ORDER BY id DESC");
		echo $conn->error;
		$stmt->bind_param("iii",$privacy,$skip,$limit);
		$stmt->bind_result($filename_from_db,$alttext_from_db);
		$stmt->execute();
		while($stmt->fetch()){
			//<div>
			//<img src="kataloog/filename" alt="alttext">
			//....
			//</div>
			$photo_html .= '<div class="thumbgallery">'."\n";
			$photo_html .= '<img src="'.$GLOBALS["photo_thumbnail_upload_dir"].$filename_from_db .'" alt="';
			if(empty($alttext_from_db)){
				$photo_html .= "Üleslaetud foto";
			} else{
				$photo_html .= $alttext_from_db;
			}
			$photo_html.='"class="thumbs">' ."\n";
			$photo_html .= '</div>'."\n";
		}
		if(empty($photo_html)){
			$photo_html = "<p>Kahjuks avalike fotosid üleslaetud ei ole</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $photo_html;
			
	}
	function count_public_photos($privacy){
		$photo_count=0;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT COUNT(id) FROM vpr_photos WHERE privacy >=? AND deleted is NULL");
		echo $conn->error;
		$stmt->bind_param("i",$privacy);
		$stmt->bind_result($count_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$photo_count=$count_from_db;
		}
		$stmt->close();
		$conn->close();
		return $photo_count;
	}
		function count_own_photos(){
		$photo_count=0;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT COUNT(id) FROM vpr_photos WHERE userid = ? AND deleted is NULL");
		echo $conn->error;
		$stmt->bind_param("i",$_SESSION["user_id"]);
		$stmt->bind_result($count_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$photo_count=$count_from_db;
		}
		$stmt->close();
		$conn->close();
		return $photo_count;
	}
		function read_own_photo_thumbs( $page, $limit){
		$photo_html=null;
		$skip = ($page-1) * $limit;
		$conn = new mysqli($GLOBALS["server_host"],$GLOBALS["sever_user_name"],$GLOBALS["server_password"],$GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id,filename,alttext FROM vpr_photos WHERE userid=? AND deleted IS NULL ORDER BY id DESC LIMIT ?, ?");
		//$stmt = $conn->prepare("SELECT filename,alttext FROM vpr_photos WHERE privacy>=? AND deleted IS NULL");
		//$stmt = $conn->prepare("SELECT filename,alttext FROM vpr_photos WHERE privacy>=? AND deleted IS NULL ORDER BY id DESC");
		echo $conn->error;
		$stmt->bind_param("iii",$_SESSION["user_id"],$skip,$limit);
		$stmt->bind_result($id_from_db,$filename_from_db,$alttext_from_db);
		$stmt->execute();
		while($stmt->fetch()){
			//<div>
			//<img src="kataloog/filename" alt="alttext">
			//....
			//</div>
			$photo_html .= '<div class="thumbgallery">'."\n";
			$photo_html .= '<a href="edit_own_photo.php?page=' . $id_from_db . '">';
			$photo_html .= '<img src="'.$GLOBALS["photo_thumbnail_upload_dir"].$filename_from_db .'" alt="';
			if(empty($alttext_from_db)){
				$photo_html .= "Üleslaetud foto";
			} else{
				$photo_html .= $alttext_from_db;
			}
			$photo_html.='"class="thumbs">' ."\n";
			$photo_html.= "</a>";
			$photo_html .= '</div>'."\n";
		}
		if(empty($photo_html)){
			$photo_html = "<p>Kahjuks avalike fotosid üleslaetud ei ole</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $photo_html;
		}