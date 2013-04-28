<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
	UserCake Version: 1.4
	http://usercake.com
	
	Developed by: Adam Davis
*/

class loggedInUser {

	public $email = NULL;
	public $hash_pw = NULL;
	public $user_id = NULL;
	public $clean_username = NULL;
	public $display_username = NULL;
	public $tank_color = NULL;

	//Simple function to update the last sign in of a user
	public function updateLastSignIn()
	{
		global $db,$db_table_prefix;
		
		$sql = "UPDATE ".$db_table_prefix."Users
			    SET
				LastSignIn = '".time()."'
				WHERE
				User_ID = '".$db->sql_escape($this->user_id)."'";
		
		return ($db->sql_query($sql));
	}
	
	//Return the timestamp when the user registered
	public function signupTimeStamp()
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT
				SignUpDate
				FROM
				".$db_table_prefix."Users
				WHERE
				User_ID = '".$db->sql_escape($this->user_id)."'";
		
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);
		
		return ($row['SignUpDate']);
	}
	
	//Update a users password
	public function updatePassword($pass)
	{
		global $db,$db_table_prefix;
		
		$secure_pass = generateHash($pass);
		
		$this->hash_pw = $secure_pass;
		
		$sql = "UPDATE ".$db_table_prefix."Users
		       SET
			   Password = '".$db->sql_escape($secure_pass)."' 
			   WHERE
			   User_ID = '".$db->sql_escape($this->user_id)."'";
	
		return ($db->sql_query($sql));
	}
	
	//Update a users email
	public function updateEmail($email)
	{
		global $db,$db_table_prefix;
		
		$this->email = $email;
		
		$sql = "UPDATE ".$db_table_prefix."Users
				SET Email = '".$email."'
				WHERE
				User_ID = '".$db->sql_escape($this->user_id)."'";
		
		return ($db->sql_query($sql));
	}
	
	//Fetch all user group information
	public function groupID()
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT ".$db_table_prefix."Users.Group_ID, 
			   ".$db_table_prefix."Groups.* 
			   FROM ".$db_table_prefix."Users
			   INNER JOIN ".$db_table_prefix."Groups ON ".$db_table_prefix."Users.Group_ID = ".$db_table_prefix."Groups.Group_ID 
			   WHERE
			   User_ID  = '".$db->sql_escape($this->user_id)."'";
		
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);

		return($row);
	}
	
	//Is a user member of a group
	public function isGroupMember($id)
	{
		global $db,$db_table_prefix;
	
		$sql = "SELECT ".$db_table_prefix."Users.Group_ID, 
				".$db_table_prefix."Groups.* FROM ".$db_table_prefix."Users 
				INNER JOIN ".$db_table_prefix."Groups ON ".$db_table_prefix."Users.Group_ID = ".$db_table_prefix."Groups.Group_ID
				WHERE User_ID  = '".$db->sql_escape($this->user_id)."'
				AND
				".$db_table_prefix."Users.Group_ID = '".$db->sql_escape($db->sql_escape($id))."'
				LIMIT 1
				";
		
		if(returns_result($sql))
			return true;
		else
			return false;
		
	}
	
	//Logout
	function userLogOut()
	{
		destorySession("userCakeUser");
	}
	public function upload()
	{
		global $db,$db_table_prefix;
			//define a maxim size for the uploaded images in Kb
		 define ("MAX_SIZE","100"); 

		//This function reads the extension of the file. It is used to determine if the
		// file  is an image by checking the extension.
		 function getExtension($str) {
				 $i = strrpos($str,".");
				 if (!$i) { return ""; }
				 $l = strlen($str) - $i;
				 $ext = substr($str,$i+1,$l);
				 return $ext;
		 }

		//This variable is used as a flag. The value is initialized with 0 (meaning no 
		// error  found)  
		//and it will be changed to 1 if an errror occures.  
		//If the error occures the file will not be uploaded.
		 $errors=0;
		//checks if the form has been submitted
		 if(isset($_POST['Submit'])) 
		 {
			//reads the name of the file the user submitted for uploading
			$image=$_FILES['image']['name'];
			//if it is not empty
			if ($image) 
			{
			//get the original name of the file from the clients machine
				$filename = stripslashes($_FILES['image']['name']);
			//get the extension of the file in a lower case format
				$extension = getExtension($filename);
				$extension = strtolower($extension);
			//if it is not a known extension, we will suppose it is an error and 
				// will not  upload the file,  
			//otherwise we will do more tests
		 if (($extension != "jpg") && ($extension != "jpeg") && ($extension !=
		 "png") && ($extension != "gif")) 
				{
				//print error message
				return ("<div id=\"errors\"><p>Unknown extension!</p></div>");
					$errors=1;
				}
				else
				{
		//get the size of the image in bytes
		 //$_FILES['image']['tmp_name'] is the temporary filename of the file
		 //in which the uploaded file was stored on the server
		 $size=filesize($_FILES['image']['tmp_name']);

		//compare the size with the maxim size we defined and print error if bigger
		if ($size > MAX_SIZE*1024)
		{
		return ("<div id=\"errors\"><p>You have exceeded the size limit!</p></div>");
			$errors=1;
		}

		//we will give an unique name, for example the time in unix time format
		$image_name=$db->sql_escape($this->user_id).'.'.$extension;
		$result = glob ("./images/avatars/".$db->sql_escape($this->user_id).".*");
		foreach ($result as $name => $value) {
			unlink($result[$name]);
		}
		//the new name will be containing the full path where will be stored (images 
		//folder)
		$newname="images/avatars/".$image_name;
		//we verify if the image has been uploaded, and print error instead
		$copied = copy($_FILES['image']['tmp_name'], $newname);
		if (!$copied) 
		{
		return ("<div id=\"errors\"><p>Copy unsuccessfull!</p></div>");
			echo '<h1></h1>';
			$errors=1;
		}}}}

		//If no errors registred, print the success message
		 if(isset($_POST['Submit']) && !$errors) 
		 {
		 	return ("<div id=\"success\"><p>File Uploaded Successfully!</p></div>");
		 	//sleep(5);
		 	//header("Location: account.php");
		 }

			
	}
		
	public function displayPicture()
	{
	global $db,$db_table_prefix;
	
	$files = glob("./images/avatars/".$db->sql_escape($this->user_id).".{pjpeg,jpg,gif,png}", GLOB_BRACE);
	if (count($files)>0){
		$location = $files[0];
		echo "<img src=\"$location\" width=\"25 px\">";
	}
	else{
		$location = "./images/avatars/none.png";
		echo "<img src=\"$location\" width=\"25 px\">";
	}
	//$location = $files[0];
	//echo "<img src=\"$location\" width=\"200 px\">";
	
	}

	public function displayAllUsers()
	{
	global $db,$db_table_prefix;
		$out = "";
		$sql="SELECT COUNT(Username) FROM userCake_Users";
			$sql_result = $db->sql_query($sql);
			$row = mysql_fetch_array($sql_result);
			$totalGroups=$row[0];
			$sql = "SELECT * FROM ".$db_table_prefix."Users";
			$sql_result = $db->sql_query($sql);
				$out= $out. '<table valign="top"><tr><td>';
				while ($row = mysql_fetch_array($sql_result)) {
				$Name = $row["Username"]; 
					$out= $out. ''; 
					$out= $out. "<span>$Name</span><br/> ";}
			$out= $out. '</td></tr></table>';
		return $out;
	}

	public function displayOnlineUsers()
	{
	global $db,$db_table_prefix;
		$out = "";
		$sql="SELECT COUNT(Username) FROM ".$db_table_prefix."Users_Online";
			$sql_result = $db->sql_query($sql);
			$row = mysql_fetch_array($sql_result);
			$totalGroups=$row[0];
			$sql = "SELECT * FROM ".$db_table_prefix."Users_Online";
			$sql_result = $db->sql_query($sql);
				$out= $out. '<table valign="top"><tr><td>';
				while ($row = mysql_fetch_array($sql_result)) {
				$Name = $row["Username"]; 
					$out= $out. ''; 
					$out= $out. "<span>$Name</span><br/> ";}
			$out= $out. '</td></tr></table><br />';
		return $out;
	}


	//Update a users tank color
	public function updateTankColor($newColor)
	{
		global $db,$db_table_prefix;
		
		$this->email = $newColor;
		
		$sql = "UPDATE ".$db_table_prefix."Users
				SET tankColor = '".$newColor."'
				WHERE
				User_ID = '".$db->sql_escape($this->user_id)."'";
		
		return ($db->sql_query($sql));
	}


}
?>