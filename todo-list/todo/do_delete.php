<?php
session_start();

require_once('php/functions.php');

connect();

$task = mysql_real_escape_string($_GET['task']);
$list_id = $_SESSION['SESS_ID'];

// Check to make sure user is logged on to a list
if(empty($_SESSION['SESS_ID'])) {
	header("location: index.php?error=1");
	close();
}

mysql_query("DELETE FROM task WHERE task_id = $task AND list_id = $list_id") or die(mysql_error());
close();

header("location: index.php");
exit();

?>