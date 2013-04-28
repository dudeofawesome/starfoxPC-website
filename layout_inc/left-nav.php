<?php
	// ini_set('display_errors',1); 
	// error_reporting(E_ALL);
?>
<?php
	require_once("models/config.php");
?>
<?php if(!isUserLoggedIn()) { ?>
	<span class="arrow"></span>Login<br />
	<br />
		<div id="regbox">
			<form name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
					<label>Username:</label>
					<input type="text" name="username" />
					<label>Password:</label>
					<input type="password" name="password" /><br />
					<input type="submit" value="Login" class="submit" />
			</form>
	</div>
<!-- 	<a href="index.php" style="cursor:hand; text-decoration:none;">Home</a><br />
	<a href="#login.php" style="cursor:hand; text-decoration:none;">Login</a><br />-->
	<span style="font-size:12px;">- or -</span><br />
	<a href="register.php" style="cursor:hand; text-decoration:none;">Register</a><br />
	<a href="#resend-activation.php" style="cursor:hand; text-decoration:none;">Resend Activation Email</a>

<?php } else { ?>
	<span class="arrow"></span><a href="home.php" style="cursor:hand; text-decoration:none;">Home</a><br />
	<br />
	<a href="update-email-address.php" style="cursor:hand; text-decoration:none;">Update Email Address</a><br />
	<a href="change-tank-color.php" style="cursor:hand; text-decoration:none;">Change Tank Color</a><br />
	<a href="change-password.php" style="cursor:hand; text-decoration:none;">Change Password</a><br />
	<a href="upload-picture.php" style="cursor:hand; text-decoration:none;">Upload Avatar</a><br />
	<a href="logout.php" style="cursor:hand; text-decoration:none;">Logout</a>
<?php } ?>