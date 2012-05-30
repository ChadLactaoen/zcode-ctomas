<?php
session_start();

require_once('php/functions.php');

connect();

$name = mysql_real_escape_string($_POST['task']);
$priority = $_POST['priority'];
$id = $_POST['task_id'];
$list_id = $_SESSION['SESS_ID'];

// Check to make sure user is logged on to a list
if(empty($_SESSION['SESS_ID'])) {
	header("location: index.php?error=5");
	close();
}

mysql_query("UPDATE task SET description = '$name', priority = $priority WHERE task_id = $id") or die(mysql_error());

close();

header("location: index.php");
exit();

?>