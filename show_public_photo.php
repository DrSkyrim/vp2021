<?php
session_start();
   $id=null;
   $type="image/png";
   $output="Pics/wrong.png";
   $privacy=3;
   if(isset($_GET["photo"]) and !empty($_GET["photo"])){
	$id = filter_var($_GET["photo"], FILTER_VALIDATE_INT);
   }
    if(!empty($id)){
		require_once("../../config.php");
		$database = "if21_martin_lu";
		$conn = new mysqli($server_host,$sever_user_name,$server_password,$database);
		$conn->set_charset("utf8");
		$stmt=$conn->prepare("SELECT filename FROM vpr_photos WHERE id = ? AND privacy=? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("ii",$id,$privacy);
		$stmt->bind_result($filename_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$output = $photo_normal_upload_dir .$filename_from_db;
			$check= getimagesize($output);
			$type= $check["mime"];
		}
		$stmt->close();
		$conn->close();
	}
	//echo $output;
	header("Content-type: ".$type);
	readfile($output);
    
	