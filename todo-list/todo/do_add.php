<?php
session_start();

require_once('php/functions.php');

connect();

$name = mysql_real_escape_string($_POST['name']);
$priority = $_POST['priority'];
$list_id = $_SESSION['SESS_ID'];

// Check to make sure user is logged on to a list
if(empty($_SESSION['SESS_ID'])) {
	header("location: index.php?error=1");
	close();
}

mysql_query("INSERT INTO task VALUES (NULL, $list_id, '$name', CURRENT_TIMESTAMP, $priority)") or die(mysql_error());
close();

header("location: index.php");
exit();

?>