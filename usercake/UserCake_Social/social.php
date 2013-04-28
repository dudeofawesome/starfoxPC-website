<?php
	/*
		UserCake Social Version: 1.0
		For UserCake Version: 1.4
		http://ahaugas.com
		
		Developed by: Aleksander Haugas
	*/
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is not logged in
	if(!isUserLoggedIn()) { header("Location: login.php"); die(); }
	
	//Call UserCake Social Class
	$userCakeSocial = new socialUser();
?>
<?php
//START OF ACCEPT FRIEND
	if(isset($_GET["accept"])) {
		$accept_user = htmlentities($_GET["accept"]);  
		if(is_numeric($accept_user)){ 
			$userCakeSocial->socialUserAcceptFriend($loggedInUser->user_id,$accept_user);
		} else { 
			echo "An error has occurred at the accept your request"; 
		}
	}
//END OF ACCEPT FRIEND
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome <?php echo $loggedInUser->display_username; ?></title>
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
        	<h1>UserCake Social</h1>
        
			<p><?php echo $userCakeSocial->socialUserFriendRequest($loggedInUser->user_id); ?></p>
			<p>Do you want to see all members? clic <a href="members.php" title="members">here</a></p>
        	<p>Your Friend List <strong><?php echo $loggedInUser->display_username; ?></strong></p>
            <p><?php echo $userCakeSocial->socialUserFriends($loggedInUser->user_id); ?></p>
  		</div>
  
	</div>
</div>
</body>
</html>