Here is my go at a profile picture addon.

1.add the 2 functions to class.user.php
2 copy the upload-picture.php into your main folder
3 Create a folder called "images" in your main directory
4 make sure /images has write permissions for ALL USERS

to display the users picture use this:

<?php $loggedInUser->displayPicture();?>


Enjoy!