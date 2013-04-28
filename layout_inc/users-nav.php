<?php require_once("models/config.php");?>

<script type="text/javascript">
function submitSearch(){
    var query = document.getElementById('txtSearchBox').value;
    if(query != "Search" && query != "" && query != " "){
	   window.location.assign('online-users.php?user='+query);
    }
}
function keyDown(event){
    if(window.event){
        event=window.event;
        if(event.keyCode==13){
        	submitSearch();
        }
    }
    else{
        if(event.which==13){
        	submitSearch()
        }
    }
}

function updateUsers(){
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("users").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","layout_inc/users-nav-update.php",true);
    xmlhttp.send();
}

</script>

<input type="search" value="Search" class="searchBox" name="txtSearchBox" id="txtSearchBox" onkeydown="keyDown();" onclick="this.value=''" />
<input type="button" value="Go" class="submit" onclick="submitSearch();" />

<div class="users" id="users">
    <script type="text/javascript">
        updateUsers();
        var timer = setInterval(updateUsers, 15000);
    </script>
</div>