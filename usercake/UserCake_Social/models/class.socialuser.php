<?php
	/*
		UserCake Social Version: 1.0
		For UserCake Version: 1.4
		http://ahaugas.com
		
		Developed by: Aleksander Haugas
	*/

class socialUser {
	
	//Dont showing errors
	public function socialUser()
	{	
		//For debugg change '0' to 'E_ALL'
		return error_reporting(0);
	}
	
	//Simple function to showing friend list
	public function socialUserFriends($user_id)
	{
		global $db,$db_table_prefix;
		  
		$sql = "SELECT Friends 
				FROM ".$db_table_prefix."Users 
				WHERE User_ID = '".$db->sql_escape($user_id)."'
				";
		
		$result = $db->sql_query($sql);	
		
		while($row = $db->sql_fetchrow($result)) {
		$friends = unserialize($row["Friends"]);
		 
			if(isset($friends[0])) {
			
				foreach($friends as $friend) {
				
				$sql = "SELECT Username, User_ID
						FROM ".$db_table_prefix."Users 
						WHERE User_ID = '".$db->sql_escape($friend)."'
						";
						
				$result = $db->sql_query($sql);

				$row = $db->sql_fetchrow($result);
				
				echo "<a href=\"profile.php?user=".$row["User_ID"]."\">".$row["Username"]."</a></br>";
				
				}
			} else { echo "<div id=\"errors\"><ul><li>Sorry but currently you not have friends</ul></li></div>"; }
		}
	}
	
	//Simple function to show members and add freinds
	public function socialUserShowFriends($user_id)
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT * 
				FROM ".$db_table_prefix."Users 
				WHERE User_ID != '".$db->sql_escape($user_id)."'
				";
				
		$result = $db->sql_query($sql);
		
		while($row = $db->sql_fetchrow($result)) {
			$alreadyFriend = false;
			$friends = unserialize($row["Friends"]);
			$add_username = $row["Username"];
			$add_user_id = $row["User_ID"];
		
			if(isset($friends[0])) {
			
			  foreach($friends as $friend) {
			  
				if($friend == $user_id) $alreadyFriend = true;
				
				}
			}
			
		$sql = "SELECT * 
				FROM ".$db_table_prefix."Users_Friends 
				WHERE Sender = '".$db->sql_escape($user_id)."' 
				AND Recipient = '".$db->sql_escape($add_user_id)."'
				";
				
			if(returns_result($sql) > 0) {
				
				//Display membership requested
				echo $add_username." - Friendship requested."."</br>";
				
			} elseif($alreadyFriend == false) {
				
				//Display link to add friend
				echo $add_username." - <a href=\"".htmlentities($_SERVER["PHP_SELF"])."?add=".htmlentities($add_user_id)."\">Add as friend</a>"."</br>";	
				
			} else {
				
				//Display if the member is your friend
				echo $add_username." - Already friends."."</br>";
				
			}
		}	
	}
	
	//Simple function to show friend requests
	public function socialUserFriendRequest($user_id)
	{
		global $db,$db_table_prefix;
	
			$sql = "SELECT * 
					FROM ".$db_table_prefix."Users_Friends 
					WHERE Recipient = '".$db->sql_escape($user_id)."'
					";
					
			$result = $db->sql_query($sql);
			
		if(returns_result($sql) > 0) {
		
			while($row = $db->sql_fetchrow($result)) { 
			$request_sender = $row["Sender"];
			
			$sql = "SELECT * 
					FROM ".$db_table_prefix."Users 
					WHERE User_ID = '".$db->sql_escape($request_sender)."'
					";
					
			$result = $db->sql_query($sql);	
			
				while($row = $db->sql_fetchrow($result)) {
				$request_username = $row["Username"];
				$request_user_id = $row["User_ID"];
				
				echo "<div id=\"success\"><ul><li>".$request_username." wants to be your friend. <a href=\"".htmlentities($_SERVER["PHP_SELF"])."?accept=".htmlentities($request_user_id)."\">Accept?</a></ul></li></div>";
				
				}
			}
		}
	}
	
	//Simple function to accept friends
	public function socialUserAcceptFriend($user_id,$result_user)
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT * 
				FROM ".$db_table_prefix."Users_Friends 
				WHERE Sender = '".$db->sql_escape($result_user)."' 
				AND Recipient = '".$db->sql_escape($user_id)."'
				";
				
		if(returns_result($sql) > 0) {

			$sql = "SELECT * 
					FROM ".$db_table_prefix."Users 
					WHERE User_ID = '".$db->sql_escape($result_user)."'
					";
					
			$result = $db->sql_query($sql);
			
			$row = $db->sql_fetchrow($result);			
			
			//Update accepted user friends
			$friends = unserialize($row["Friends"]);
			$friends[] = $user_id;      
			
			$sql = "UPDATE ".$db_table_prefix."Users 
					SET Friends = '".$db->sql_escape(serialize($friends))."' 
					WHERE User_ID = '".$db->sql_escape($result_user)."'
					";
					
			$db->sql_query($sql);
			
			$sql = "SELECT * 
					FROM ".$db_table_prefix."Users 
					WHERE User_ID = '".$db->sql_escape($user_id)."'
					";
					
			$result = $db->sql_query($sql);
			
			$row = $db->sql_fetchrow($result);
			
			//Update requested user friends
			$friends = unserialize($row["Friends"]);
			$friends[] = $result_user;      

			$sql = "UPDATE ".$db_table_prefix."Users 
					SET Friends = '".serialize($friends)."' 
					WHERE User_ID = '".$db->sql_escape($user_id)."'
					";
			
			$db->sql_query($sql);
		}
		
		//Delete user request for a friend
		$sql = "DELETE FROM ".$db_table_prefix."Users_Friends 
				WHERE Sender = '".$db->sql_escape($result_user)."' 
				AND Recipient = '".$db->sql_escape($user_id)."'
				";
				
		return $db->sql_query($sql);
	}
	
	//Simple function to add friends
	public function socialUserAddFriends($user_id,$result_user)
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT User_ID 
				FROM ".$db_table_prefix."Users 
				WHERE User_ID = '".$db->sql_escape($result_user)."'
				";
				
		if(returns_result($sql) > 0) {
			
			$sql = "SELECT * 
					FROM ".$db_table_prefix."Users_Friends 
					WHERE Sender = '".$db->sql_escape($user_id)."' 
					AND Recipient = '".$db->sql_escape($result_user)."'
					";
					
			if(returns_result($sql) == 0) {
				
				$sql = "INSERT INTO ".$db_table_prefix."Users_Friends 
						SET Sender = '".$db->sql_escape($user_id)."', 
						Recipient = '".$db->sql_escape($result_user)."'
						";
				
			}
		}
		return $db->sql_query($sql);
	}
	
	//Simple test function to make private profile
	public function privateProfile($profile_view_user,$user_id)
	{
		global $db,$db_table_prefix,$loggedInUser;

		if($user_id == NULL) {
		
			return false;
			
		} else {	
		
			$sql = "SELECT * 
					FROM ".$db_table_prefix."Users 
					WHERE User_ID = '".$db->sql_escape($user_id)."'
					";
					
			//Query the database to ensure they haven't been removed or not friend
			if(returns_result($sql) > 0)
			{		
					
					$result = $db->sql_query($sql);
			
					$row = $db->sql_fetchrow($result);
					
					$i = $row["Profile"];
					
					switch ($i) {
					
						case 0: //Show users profile for all
						
							//Nothing to do
							break;
							
						case 1: //Show users profile only for registred users
						
							//Prevent the user visiting the logged in page if he/she is not logged in
							if(!isUserLoggedIn()) { header("Location: login.php"); die(); }
							break;
							
						case 2: //Show users profile only for friends
						
							$friends = array_values(unserialize($row["Friends"])); 	// Users friends named
							$find = $profile_view_user; 							// Define actual user for view profile
							$key = array_search($find,$friends ); 					// Find users friend to access profile
							 
							if ($key !== false) { 									// For PHP v 4.2.x if(!is_null($key) {
								
								//If the user is a friend show data
								
							} else {
								
								//Redirect the user if not friend
								header("Location: login.php");
								
							}
							break;
					}
					
			} else {
			
				//No result returned redirect the user?
				header("Location: login.php");
			
				return false;
			}
		}	
	}
	
	//Save the users avatar inside the database
	public function socialUserSecurityMySQL($security) 
	{
		global $loggedInUser,$db,$db_table_prefix;
		
		$sql = "UPDATE ".$db_table_prefix."Users 
				SET  Profile = '".$db->sql_escape($security)."' 
				WHERE User_ID = '".$db->sql_escape($loggedInUser->user_id)."'
				";
			
		return $db->sql_query($sql);
	}
	
	//Get security of user requested
	public function socialUserGetSecurity() 
	{
		global $db,$db_table_prefix,$loggedInUser;
		
			$sql = "SELECT Profile 
					FROM ".$db_table_prefix."Users 
					WHERE User_ID = '".$db->sql_escape($loggedInUser->user_id)."' 
					LIMIT 1
					";
				
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);	
		
		return ($row['Profile']);
	}
	
	//Here start all the user information for request (public, private and friend) in resumed (for all users)
	//In this section you not need make any functions for restrict information 
	//Why you dont need restirct? if you install correctly this plugin, this add auto-security.
	//you can see the implementation in the profile.php.
	//=======================================================================================================//
	
	//Get username of user requested
	public function socialUserGetUsername($username) 
	{
		global $db,$db_table_prefix;
		
			$sql = "SELECT * 
					FROM ".$db_table_prefix."Users 
					WHERE User_ID = '".$db->sql_escape($username)."' 
					LIMIT 1
					";
				
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);	
		
		return ($row['Username']);
	}
	
	//Get user group information requested
	public function socialUserGetGroupID($user_id)
	{
		global $db,$db_table_prefix;
		
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
	
	//Return the timestamp when the user registered
	function socialUserGetSignupTimeStamp($user_id)
	{
		global $db,$db_table_prefix;
		
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
	
	//Return the email of the user requested
	function socialUserGetEmail($user_id)
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT
				Email
				FROM
				".$db_table_prefix."Users
				WHERE
				User_ID = '".$db->sql_escape($user_id)."'";
		
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);
		
		return ($row['Email']);
	}
}
?>