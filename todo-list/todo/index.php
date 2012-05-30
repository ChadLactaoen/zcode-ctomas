<?php
session_start();
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
				<?php check_errors(); ?>
				<?php has_list(); ?>
			</div><!-- #content -->
			<div id="sidebar">
				<h1>You can:</h1>
				<div class="button" id="add-button">Add Task</div>
				<div class="form">
					<form action="do_add.php" method="post">
						Task: <input type="text" maxlength="180" name="name" required><br>
						Priority:
						<select name="priority">
							<option value="1" selected>1 (Low)</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5 (High)</option>
						</select><br>
						<input type="submit" value="Add">
					</form>
				</div>
				<div class="button" id="load-button">Load List</div>
				<div class="form">
					<form action="do_load.php" method="post">
						List name: <input type="text" maxlength="50" name="name" required>
						<input type="submit" value="Load">
					</form>
				</div>
				<div class="button" id="new-button">New List</div>
				<div class="form">
					<form action="do_new.php" method="post">
						List name: <input type="text" maxlength="50" name="name" required>
						<input type="submit" id="new-submit" value="Create">
					</form>				
				</div>
				<a href="do_logout.php">
					<div class="button" id="logout-button">Logout</div>
				</a>	
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