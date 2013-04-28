<?php
error_reporting(0);
	// these details are used or called on for user profile
	$user = $_REQUEST['user'];
	$userdetails = fetchUserDetails($user);
	$username = $userdetails["Username"];
	$user_id = $userdetails["User_ID"];
	$hash_pw = $userdetails["Password"];
	
	//Return the timestamp when the user registered
	function profileSignupTimeStamp()
	{
		global $db,$db_table_prefix,$user_id;
		
		$sql = "SELECT
				SignUpDate
				FROM
				".$db_table_prefix."Users
				WHERE
				User_ID = '".$db->sql_escape($user_id)."'";
		
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);
		
		return ($row['SignUpDate']);
	}

	//Return the timestamp when the user last signed in
	function profileLastSignIn()
	{
		global $db,$db_table_prefix,$user_id;
		
		$sql = "SELECT
				LastSignIn
				FROM
				".$db_table_prefix."Users
				WHERE
				User_ID = '".$db->sql_escape($user_id)."'";
		
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);
		
		return ($row['LastSignIn']);
	}
	
	//Fetch all user group information
	function profileGroupID()
	{
		global $db,$db_table_prefix,$user_id;
		
		$sql = "SELECT ".$db_table_prefix."Users.Group_ID, 
			   ".$db_table_prefix."Groups.* 
			   FROM ".$db_table_prefix."Users
			   INNER JOIN ".$db_table_prefix."Groups ON ".$db_table_prefix."Users.Group_ID = ".$db_table_prefix."Groups.Group_ID 
			   WHERE
			   User_ID  = '".$db->sql_escape($user_id)."'";
		
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);

		return($row);
	}
	
	//determine whether user is online or not
	function onlineStatus()
	{
		global $db,$db_table_prefix,$username;
		
		$sql = "SELECT
				Username
				FROM
				".$db_table_prefix."Users_Online
				WHERE
				Username = '".$db->sql_escape($username)."'";
		
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);
		
		return ($row['Username']);
	}

?>
