<?php
	/*
		UserCake Version: 1.4
		http://usercake.com
		
		Developed by: Adam Davis
	*/
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is already logged in
	if(isUserLoggedIn()) { header("Location: account.php"); die(); }
?>

<?php
	/* 
		Below is a very simple example of how to process a new user.
		 Some simple validation (ideally more is needed).
		
		The first goal is to check for empty / null data, to reduce workload here
		we let the user class perform it's own internal checks, just in case they are missed.
	*/

//Forms posted
if(!empty($_POST))
{
		$errors = array();
		$email = trim($_POST["email"]);
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$confirm_pass = trim($_POST["passwordc"]);
	
		//Perform some validation
		//Feel free to edit / change as required
		
		if(minMaxRange(5,25,$username))
		{
			$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
		}
		if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
		{
			$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
		}
		else if($password != $confirm_pass)
		{
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		if(!isValidEmail($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}
		//End data validation
		if(count($errors) == 0)
		{	
				//Construct a user object
				$user = new User($username,$password,$email);
				
				//Checking this flag tells us whether there were any errors such as possible data duplication occured
				if(!$user->status)
				{
					if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
					if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
				}
				else
				{
					//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
					if(!$user->userCakeAddUser())
					{
						if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
						if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
					}
				}
		}
	}
?>
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

			<div class="navLoggedOut">
				<?php include("layout_inc/left-nav.php"); ?>
			</div>

			<div id="arwing" class="arwing">
				<script type="text/javascript" src="js/javascript.js"> </script>
			</div>
			<div id="title" class="title">
				Star Fox PC
			</div>
			<div class="menu">

				<h1>Registration</h1>

				<?php
					if(!empty($_POST))
					{
						if(count($errors) > 0)
						{
						?>
							<div id="errors">
							<?php errorBlock($errors); ?>
							</div>
						<?php
						}
						else{
			  
							$message = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE1");
					
							if($emailActivation){
								$message = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE2");
							}
						?>
							<div id="success">
						
							<p><?php echo $message ?></p>
						
							</div>
						<?php
						}
					}
					?>

				<div id="regbox">
					<form name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
					
						<label>Username:</label>
						<input type="text" name="username" />
						<label>Email:</label>
						<input type="email" name="email" /><br />
						<label>Password:</label>
						<input type="password" name="password" /><br />
						&nbsp;&nbsp;&nbsp;&nbsp;<label>Confirm:</label>
						<input type="password" name="passwordc" /><br />
						<input type="submit" value="Register"/>
					
					</form>
				</div>

				<?php
				if(!empty($_POST))
				{
				?>
				<?php
				if(count($errors) > 0)
				{
				?>
				<div id="errors">
				<?php errorBlock($errors); ?>
				</div>     
				<?php
				} }
				?> 
				<div class="usercake">&copy;<a href="http://orleans.pl">Louis Orleans</a> &amp; <a href="http://gibbs.tk">Josh Gibbs</a><!-- <a href="http://usercake.com" style="color:#777;">We use Usercake</a>-->&nbsp;</div>
			</div>

		</div>
</body>
</html>