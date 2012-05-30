<?php
//Start session
session_start();
//Unset the variable SESS_MEMBER_ID stored in session
unset($_SESSION['SESS_ID']);
unset($_SESSION['SESS_NAME']);
header("location: index.php");
exit();
?>