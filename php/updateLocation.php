<?php 
//Get login information 
require('database_connect.php');
//Get the id of the note to be displayed returned
$currentUserNetId = $_GET["currentUserNetId"];
$lat = $_GET["lat"];
$lng = $_GET["lng"];
//Protect against SQL injection
if(get_magic_quotes_gpc()){
	$currentUserNetId = mysql_real_escape_string($currentUserNetId);
	$currentUserNetId = stripslashes($currentUserNetId);
	$lat = mysql_real_escape_string($lat);
	$lat = stripslashes($lat);
	$lng = mysql_real_escape_string($lng);
	$lng = stripslashes($lng);
}

updateLocation($currentUserNetId, $lat, $lng);

mysql_close($connection);

function updateLocation($currentUserNetId, $lat, $lng)
{
	//Build a query
	$update = ' UPDATE ';   
	$tables = ' Users ';
	$where = ' WHERE netId = "' . $currentUserNetId . '"';
	$set = ' SET location = GeomFromText("POINT('.$lat.' '.$lng.')")';
	$query = $update . $tables . $set . $where; 
	
	//Execute the query
	$query_result = mysql_query($query);
	if(!$query_result){
		die("Could not query the database. " . mysql_error());
	}
}
?>