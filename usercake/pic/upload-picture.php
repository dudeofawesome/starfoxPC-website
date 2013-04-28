<?php
	include("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is not logged in
	if(!isUserLoggedIn()) { header("Location: login.php"); die(); }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload your Profile Picture </title>
<link href="cakestyle.css" rel="stylesheet" type="text/css" /><link href='http://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'></head>
<body><?php include_once("google.php") ?><h2>People Search</h2>
<div id="wrapper">

	<div id="content">
    
        <div id="left-nav">
        <?php include("layout_inc/left-nav.php"); ?>
            <div class="clear"></div>
        </div>

		<div id="main">

            <h1>Upload your Profile Picture</h1>
    
            <div id="regbox">
			
			 <form name="newad" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>">
				 <table>
					<tr><td><input type="file" name="image"></td></tr>
					<tr><td><input name="Submit" type="submit" value="Upload image">
					   </td></tr>
				 </table>	
				 </form>
				 <?php if(!empty($_POST))
					{
						$out = $loggedInUser->upload(); echo $out;
					}

?>
                 </div>
            <div class="clear"></div>
        </div>
	</div>
</div><div class="clear"></div>
<div id="footer"><p>Copyright &copy; 2012. <a href="http://gitastudents.com/~clarkb/">Bryan Clark</a>. All rights reserved. Site created by <a href="http://gitastudents.com/~clarkb/">Bryan Clark</a>.</p></div></body>
</html>

