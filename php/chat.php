<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat</title>
<link type="text/css" rel="stylesheet" href="chat_style.css" />
</head>
 
 <? 
 /* connect to the database*/
require_once('database_connect.php');
?>

<?php
/* If the user is not logged in, redirect to the login page. */
if (!isUserLoggedIn()){
    header('Location: ../loginUser.php');
}
else{
?>
<div id="wrapper">
    <div id="menu">
    	<!-- welcome message + exit button!-->
        <p class="welcome">Welcome, <b><?php echo $_SESSION['user']['firstName']; ?></b></p>
        <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
        <div style="clear:both"></div>
    </div>    
    <div id="chatbox"></div>
     
    <!-- form submission for message -->
    <form name="message" action="">
        <input name="usermsg" type="text" id="usermsg" size="63" />
        <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
    </form>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
	///If user submits the form, log the message in the chat_history table using chat_logmessage.php
	$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
		$.post("chat_logmessage.php", {text: clientmsg});				
		$("#usermsg").attr("value", "");
		return false;
	});
	
	//Load the data containing the chat log by querying the chat_history table through chat_query.php
	function loadLog(){		

		$.ajax({
			type: "GET",
			url: "chat_query.php",
			dataType: "html",
			cache: false,
			success: function(response){		
				$("#chatbox").html(response); //Insert chat log into the #chatbox div				
		  	},
		});
	}
	
	//Load the data containing the chat log by querying the chat_history table through chat_query.php
	function loadLog(){		
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
		$.ajax({
			type: "GET",
			url: "chat_query.php",
			dataType: "html",
			cache: false,
			success: function(response){		
				$("#chatbox").html(response); //Insert chat log into the #chatbox div	
				
				//Auto-scroll			
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
	
	setInterval (loadLog, 2500);	//Reload file every 2500 ms or x ms if you w
});
</script>
<?php
}
?>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
	//If user wants to end session - redirect to logout.php
	$("#exit").click(function(){
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true){window.location = '../logout.php';}		
	});
});
</script>
</body>
</html>