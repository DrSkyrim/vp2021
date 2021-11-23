<?php
require_once("classes/SessionManager.class.php");
SessionManager::sessionStart("vp",0,"/~marluk/vp2021","greeny.cs.tlu.ee");

if(!isset($_SESSION["user_id"])){
header("Location: page.php");}
	$author_name = "Martin Lukas";
	require_once ("fnc_user.php");
if(isset($_GET["logout"])){
	session_destroy();
	header("Location: page.php");
}