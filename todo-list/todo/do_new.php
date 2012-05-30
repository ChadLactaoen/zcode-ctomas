<?php

session_start();

require_once('php/functions.php');

connect();

$name = mysql_real_escape_string($_POST['name']);

// Get the id
$result = mysql_query("SELECT * FROM list WHERE name='$name'") or die("Error during query: " . mysql_error());
$count = mysql_num_rows($result);
if($count == 1) {
	close();
	header("location: index.php?error=3");
	exit();	
} else {
	// Insert new list into table
	$result = mysql_query("INSERT INTO list (name) VALUES ('$name')") or die ("Error creating new list: " . mysql_error());
	// Get the id
	$result = mysql_query("SELECT * FROM list WHERE name='$name'") or die("Error during query: " . mysql_error());
	
	session_regenerate_id();
	$member=mysql_fetch_assoc($result);									
	$_SESSION['SESS_ID']=$member['list_id'];
	$_SESSION['SESS_NAME']=$member['name'];
	//Write session to disc
	session_write_close();
	close();	// Close connections
	header("location: index.php");
	exit();
}
?>