<?php
session_start();

if(!isset($_SESSION['SESS_ID'])) {
	header("location: index.php?error=5");
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <title>To-Do List</title>
    <meta name="description" content="To-Do List">
    <meta name="author" content="Chad Tomas">

    <link rel="stylesheet" href="css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</head>
<body>
	<!-- Load php functions -->
	<?php require_once('php/functions.php'); ?>
	
    <div id="container">
		<div id="logo">
			<img src="images/logo.png">
		</div><!-- #logo -->
		
		<div id="main">
			<div id="content">
				<?php create_edit_form(); ?>
			</div><!-- #content -->
			<div id="sidebar">
					
			</div><!-- #sidebar -->
		</div><!-- #main -->
		
		<footer>
			<div id="copyright">
				<p>Copyright 2012 Chad Tomas. Intended for Zappos.Code();</p>
			</div><!-- #copyright -->
		</footer>
	</div><!-- #container -->
	<script src="scripts/functions.js"></script>
</body>
</html>