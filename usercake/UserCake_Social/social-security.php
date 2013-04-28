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
//Forms posted
if(!empty($_POST))
{		
	$security = $_POST['security'];	
	
		// Save everything in MySQL
		if($userCakeSocial->socialUserSecurityMySQL($security) === false){
			
			//Display error message if found errors
			$errors[] = "An error occurred, please try again";
			
		} else {
		
			//Display success message if inserted correctly
			$errors[] = "The data is correctly recorded and stored";
		}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Profile Security Configuration</title>
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

            <h1>Update your Security Configuration</h1>	
			
			<p>Please select the security settings so that users can view their profile</p>
			
			<?php if(!empty($_POST)) { if(count($errors) > 0) { ?>	
				<div id="errors">
					<?php errorBlock($errors); ?>
				</div>
			<?php } } ?> 	
				
            <div id="regbox">
                <form name="updateSecurity" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            
                <p>
                    <label>Public:</label>
                    <input type="radio" id="security" name="security" value="0"<?php echo ($userCakeSocial->socialUserGetSecurity() == '0') ? 'checked="checked"' : '';?> />
                </p>
				
                <p>
                    <label>Private:</label>
					<input type="radio" id="security" name="security" value="1" <?php echo ($userCakeSocial->socialUserGetSecurity() == '1') ? 'checked="checked"' : '';?> />
                </p>
				
                <p>
                    <label>Friends:</label>
					<input type="radio" id="security" name="security" value="2" <?php echo ($userCakeSocial->socialUserGetSecurity() == '2') ? 'checked="checked"' : '';?> />
                </p>
        
                <p>
                    <label>&nbsp;</label>
                    <input type="submit" value="Update" class="submit" />
                </p>
                
                </form>
            </div>
            <div class="clear"></div>
        </div>
	</div>
</div>
</body>
</html>				