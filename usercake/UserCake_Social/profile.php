<?php
	/*
		UserCake Social Version: 1.0
		For UserCake Version: 1.4
		http://ahaugas.com
		
		Developed by: Aleksander Haugas
	*/
	require_once("models/config.php");
	
	//Call UserCake Social Class
	$userCakeSocial = new socialUser();
	
	//Check user and user's permissions to view the profile
	if(empty($_GET['user'])) { $id = "0"; } else { $id = $_GET['user']; }
	
	//check if the user is logged in
	if(!isUserLoggedIn()) { 
	
			//For unregistred user (default "0")
			$userCakeSocial->privateProfile('0',$id);
			
		} else {
	
			//For registred user (default User ID)
			$userCakeSocial->privateProfile($loggedInUser->user_id,$id);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome</title>
<link href="cakestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">

	<div id="content">
    
        <div id="left-nav">
        <?php include("layout_inc/left-nav.php"); ?>
            <div class="clear"></div>
        </div>
        
        
        <div id="main">
        	<h1>Profile</h1>
			<p>Welcome to the account page of <strong><?php echo $userCakeSocial->socialUserGetUsername($id); ?></strong></h1>
			<p>They are a <strong><?php  $group = $userCakeSocial->socialUserGetGroupID($id); echo $group['Group_Name']; ?></strong>
			   and joined on <?php echo date("l \\t\h\e jS \o\\f F Y",$userCakeSocial->socialUserGetSignupTimeStamp($id)); ?></p>
			<p>Their email address is: <strong><?php echo $userCakeSocial->socialUserGetEmail($id); ?></strong></p>
		</div>
  
	</div>
</div>
</body>
</html>