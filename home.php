<?php
	/*
		UserCake Version: 1.4
		http://usercake.com
		
		Developed by: Adam Davis
	*/
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is not logged in
	if(!isUserLoggedIn()) { header("Location: index.php"); die(); }
?>
<html>
<head>
	<title>Star Fox PC</title>
	<link rel="stylesheet" type="text/css" href="style/main.css" />
	<link rel='shortcut icon' href='images/favicon.ico' />
	<script type="text/javascript" src="js/jquery.js"> </script>
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"> </script>

	<script src="js/three.min.js"></script>
	<script src="js/Detector.js"></script>
	<script src="js/OBJLoader.js"></script>
	<!-- <script src="js/MTLLoader.js"></script> -->
</head>
<body>
		<div id="content" class="content">

			<div id="about" class="popups" style="font-size:35px;" onclick="hidePopup('about');">
				<span style="position:absolute; right:25px; cursor:hand; font-size:15px;">Click here to close</span>
				Star Fox PC is a fan reboot of the Star Fox series, drawing a little bit more towards modern day shooters, and a little bit less arcade style. Star Fox PC is based off of Cryengine 3, and will be exclusively for Widnows at first, but might make its way on to Android. We are not affiliated with Nintendo, Argonaut Software, Namco, Q-Games, or any other Star Fox-y people or businesses. 
			</div>

			<div id="contact" class="popups" style="font-size:35px;" onclick="hidePopup('contact');">
				<span style="position:absolute; right:25px; cursor:hand; font-size:15px;">Click here to close</span>
				<a href="mailto:louis@orleans.pl">Louis Orleans - louis@orleans.pl</a><br />
				<a href="mailto:josh@gibbs.tk">Josh Gibbs - josh@gibbs.tk</a>
			</div>

			<div class="navLoggedIn">
				<?php include("layout_inc/left-nav.php"); ?>
			</div>

			<div id="arwing" class="arwing">
				<script type="text/javascript" src="js/javascript.js"> </script>
			</div>
			<div id="title" class="title">
				Star Fox PC
			</div>
			<div class="menu">
				<div style="font-size:80px;">Coming Soon!</div>
				<span class="links">
					<a href="#" style="cursor:hand;" onclick="showPopup('about');">About</a>&nbsp;&bull;
					<a href="#" style="cursor:hand;" onclick="showPopup('contact');">Contact Us</a><br />
				</span>
				<br />
				<a href="http://www.w3.org/html/logo/">
					<img src="http://www.w3.org/html/logo/badge/html5-badge-h-css3-graphics-performance-semantics.png" width="229" height="64" alt="HTML5 Powered with CSS3 / Styling, Graphics, 3D &amp; Effects, Performance &amp; Integration, and Semantics" title="HTML5 Powered with CSS3 / Styling, Graphics, 3D &amp; Effects, Performance &amp; Integration, and Semantics">
				</a>
				<!--<h1>Login</h1>

				<?php
				//if(!empty($_POST))
				//{
				//?>
				<?php
				//if(count($errors) > 0)
				//{
				?>
				<div id="errors">
				<?//php errorBlock($errors); ?>
				</div>     
				<?php
				//} }
				?> 

				<div id="regbox">
				    <form name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				    <p>
				        <label>Username:</label>
				        <input type="text" name="username" />
				    </p>
				    
				    <p>
				         <label>Password:</label>
				         <input type="password" name="password" />
				    </p>
				    
				    <p>
				        <label>&nbsp;</label>
				        <input type="submit" value="Login" class="submit" />
				    </p>

				    </form>

				    <a href="register.php">Don't have an account yet?<br />Sign up here</a>
				</div>-->
				<div class="usercake">&copy;<a href="http://orleans.pl">Louis Orleans</a> &amp; <a href="http://gibbs.tk">Josh Gibbs</a><!-- <a href="http://usercake.com" style="color:#777;">We use Usercake</a>-->&nbsp;</div>
			</div>

		</div>
</body>
</html>