<?php
/* 	Functions.php maintains all functions used for To-Do List
*	Intended for Zappos.Code();
* 	Author: Chad Tomas
*	Version: May 29, 2012
*/

global $link;
global $list_id;
global $list_name;
global $sort_order;

/**
*	Establishes connection to MySQL DB
*/
function connect() {
	global $link;
	$user = 'ctomas3';
	$pass = '123rct123';
	$db = 'test';
	
	$link = mysql_connect('localhost', $user, $pass) or die('Could not connect: ' . mysql_error());
	$db_selected = mysql_select_db($db) or die('Could no select db: ' . mysql_error());
}

/**
*	Closes any connection to MySQL DB
*/
function close() {
	global $link;
	// close connection 
	mysql_close($link) or die("WORLD"); 
}

/**
*	Checks if the user is logged on to a list.
*	If he isn't, a message to start or load a list is printed.
*	Otherwise, makes a call to set_list_name()
*/
function has_list() {
	if(empty($_SESSION['SESS_ID'])) {
		echo "<h1>To-Do List</h1>";
		echo "<p id=\"nolisterror\"><em>A list has not been loaded yet.";
		echo "<br>Please click \"New\" to start a new list or \"Load\" to load a saved list.</em></p>";
	} else {
		set_list_name();
	}
}

/**
*	Gets the name of the list to use as the header, then makes a 
*	call to show the sorting options for the list and get the list itself.
*/
function set_list_name() {
	global $list_id;
	global $list_name;
	
	$list_id = $_SESSION['SESS_ID'];
	$list_name = $_SESSION['SESS_NAME'];
	
	echo "<h1>".$list_name."</h1>";
	
	show_list_order();
	get_list();
}

/**
*	Print the different options for sorting the list
*/
function show_list_order() {
	global $sort_order;
		if(isset($_GET['order']))
	$sort_order = $_GET['order'];
	$current = '';
	
	switch ($sort_order) {
		case 2:
			$current = "Z-A";
			break;
		case 3:
			$current = "Oldest";
			break;
		case 4:
			$current = "Newest";
			break;
		case 5:
			$current = "Lowest Priority";
			break;
		case 6:
			$current = "Highest Priority";
			break;
		default:
			$current = "A-Z";
	}
	
	echo "<p>";
	echo "<strong>Sort by:</strong> ";
	echo "<a href=\"index.php?order=1\">A-Z</a> | ";
	echo "<a href=\"index.php?order=2\">Z-A</a> | ";
	echo "<a href=\"index.php?order=3\">Oldest</a> | ";
	echo "<a href=\"index.php?order=4\">Newest</a> | ";
	echo "<a href=\"index.php?order=5\">Lowest Priority</a> | ";
	echo "<a href=\"index.php?order=6\">Highest Priority</a>";
	echo "</p>";
	
	echo "<p>Currently sorted by: " . $current . "</p>";
}

/**
*	Gets each task in the list and displays them
*/
function get_list() {
	global $list_id;
	
	$order = get_order();
	
	connect();
	$result = mysql_query("SELECT *, DATE_FORMAT(date,'%a, %M %e, %Y %h:%i%p') as fdate FROM task WHERE list_id=$list_id ORDER BY $order") or die(mysql_error());
	
	// Checks if there are any tasks in the lists
	if(mysql_num_rows($result) > 0){
		while($task = mysql_fetch_assoc($result)) {
			echo "<div class=\"task\">";
			echo "<h2 class=\"task-desc\">" . $task['description'] . "</h2>";
			echo "<p><strong>Priority: " . $task['priority'] . "</strong><br>";
			echo "Created on " . $task['fdate'] . "<br>";
			echo "<a href=\"do_edit.php?task=". $task['task_id'] . "\">Edit</a> | ";
			echo "<a href=\"do_delete.php?task=". $task['task_id'] . "\">Delete</a>";
			echo "</div>";
		}
	} else {
		echo "<p><em>You do not have any tasks in your list.<br>";
		echo "Click \"Add Task\" to add some!</em></p>";
	}
	
	close();
}

/**
*	A helper method that gets the sorting option the user has chosen to sort the list by
*/
function get_order() {
	$order = "description ASC";
	if(isset($_GET['order'])) {
		switch($_GET['order']) {
			case 2:
				$order = "description DESC";
				break;
			case 3:
				$order = "date ASC";
				break;
			case 4:
				$order = "date DESC";
				break;
			case 5:
				$order = "priority ASC";
				break;
			case 6:
				$order = "priority DESC";
		}
	}
	return $order;
}

/**
*	Checks to see if there was an error with a request and notifies the user
*/
function check_errors() {
	if(isset($_GET['error'])) {
		$error = $_GET['error'];
		
		echo "<div id=\"error\"><img src=\"images/warning.png\"> ";
		if($error == 1)
			echo "Oops...you must load a list before adding tasks.";
		elseif($error == 2)
			echo "Well that's just embarassing, the list doesn't exist.";
		elseif($error == 3)
			echo "Ouch, that list name is already taken.";
		elseif($error == 4)
			echo "There was some kind of problem with your request.";
		elseif($error == 5)
			echo "You must be logged in to do that!";
		
		echo "</div>";
	}	
}

/**
*	Creates and fills in the edit task form 
*/
function create_edit_form() {
	connect();
	$task_id = $_GET['task'];
	$list = $_SESSION['SESS_ID'];
	$result = mysql_query("SELECT * FROM task WHERE task_id = $task_id AND list_id = $list LIMIT 1") or die(mysql_error());
	
	// If task was not found, meaning they probably got here accidentally 
	if(mysql_num_rows($result) == 0) {
		echo "<p>There was an error processing your request.</p>";
	} else {
		$task = mysql_fetch_assoc($result);
		echo "<form action=\"do_update.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"task_id\" value=\"". $task_id . "\">";
		echo "Task: <input type=\"text\" name=\"task\" maxlength=\"180\" value=\"" . $task['description'] . "\" required><br>";
		echo "Priority: ";
		echo "<select name=\"priority\">";
		$selected = $task['priority'];
		for($i = 1; $i <= 5; $i++) {
			if($i == $selected)
				echo "<option value=\"" . $i . "\" selected>" . $i . "</option>";
			else
				echo "<option value=\"" . $i . "\">" . $i . "</option>";
		}
		echo "</select><br>";
		echo "<input type=\"submit\" value=\"Update\"></form>";
	}
	
	close();
	
}

?>