<?php
	/*
		UserCake Version: 1.4
		http://usercake.com
		
		Developed by: Adam Davis
	*/
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is not logged in
	if(!isUserLoggedIn()) { header("Location: login.php"); die(); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome <?php echo $loggedInUser->display_username; ?></title>
<link href="public/themes/userCake/css/cakestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">

	<div id="content">
    
        <div id="left-nav">
        <?php include("layout_inc/left-nav.php"); ?>
            <div class="clear"></div>
        </div>
        
        
        <div id="main">
		
		<?php	
		if (!$userdetails) {
		?>	
        	<h1>Not Found!</h1>
        
        	<p>Sorry but the user you are trying to find does not exist.</p>
			
			<p>
                <strong>People Online</strong>: <?php echo $viewUsersOnlineView->ViewTotal(); ?>
				<strong>Registered Online</strong>: <?php echo $viewUsersOnlineView->ViewRegistred(); ?>
				<strong>Visitors Online</strong>: <?php echo $viewUsersOnlineView->ViewNoRegistred(); ?>
            </p>
		<?php
		} else {
		?>
        	<h1>Profile</h1>
        
        	<p>Welcome to the account page of <strong><?php echo $username; ?></strong></p>
			
			<p>They are a <strong><?php  $group = profileGroupID(); echo $group['Group_Name']; ?></strong>
			
			and joined on <?php echo date("l \\t\h\e jS \o\\f F Y",profileSignupTimeStamp()); ?> </p>
			
			<p><?php if (profileLastSignIn() == '0') { echo "<strong>$username</strong> has never signed in"; } else { ?> Last sign in was <?php echo date("Y\/m\/d h:i A",profileLastSignIn()); } ?> </p>
			
			<p>Status: <?php  $onlineStatus = onlineStatus(); if ($onlineStatus != $username) { echo "<strong>offline</strong>"; } else { echo "<strong>online</strong>"; } ?></p>
			
		<?php
		}
		?>
  		</div>
  
	</div>
</div>
		<div class="usersMenu">
			<?php include("layout_inc/users-nav.php"); ?>
		</div>

	</body>
</html>