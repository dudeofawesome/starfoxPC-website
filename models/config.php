<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
	/*
		UserCake Version: 1.4
		http://usercake.com
		
		Developed by: Adam Davis
	*/

	if(is_dir("install/"))
	{
		header("Location: install/");
		die();
	}
	
	require_once("settings.php");

	//Dbal Support - Thanks phpBB ; )
	require_once("db/".$dbtype.".php");
	
	//Construct a db instance
	$db = new $sql_db();
	if(is_array($db->sql_connect(
							$db_host, 
							$db_user,
							$db_pass,
							$db_name, 
							$db_port,
							false, 
							false
	))) {
		die("Unable to connect to the database");
	}
	
	if(!isset($language)) $langauge = "en";

	require_once("lang/".$langauge.".php");
	require_once("class.user.php");
	require_once("class.mail.php");
	require_once("funcs.user.php");
	require_once("funcs.general.php");
	require_once("class.newuser.php");
	require_once("class.usersonline.php");
	require_once("funcs.profile.php");

	session_start();
	
	//Global User Object Var
	//loggedInUser can be used globally if constructed
	if(isset($_SESSION["userCakeUser"]) && is_object($_SESSION["userCakeUser"]))
	{
		$loggedInUser = $_SESSION["userCakeUser"];
	}

	//View userCake users online
	$viewUsersOnlineView = new usersOnlineView();
?>