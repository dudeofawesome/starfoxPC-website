<?php require_once("../models/config.php");?>

<div class="onlineUsers">
	Online Users:<br />
	<?php $names = $loggedInUser->displayOnlineUsers(); echo $names; ?>
</div>
<div class="allUsers">
	All Users:<br />
	<?php $names = $loggedInUser->displayAllUsers(); echo $names; ?>
</div>