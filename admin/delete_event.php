<?php
	
	require_once 'scripts/authorize.php';
	require_once 'scripts/database_connection.php';
	require_once 'scripts/view.php';
	require_once 'scripts/functions.php';



	// Start session to enable user authorization and control.
	session_start();

	// set time-out period (in seconds)
	$inactive = 600;
 
	// check to see if $_SESSION["timeout"] is set
	if (isset($_SESSION["timeout"])) 
	{
		// calculate the session's "time to live"
		$sessionTTL = time() - $_SESSION["timeout"];
		if ($sessionTTL > $inactive) 
		{
			session_destroy();
			$msg = "Your session has timed out due to inactivity. Please log in again to continue.";
			header("Location: login.php?error_message=" . $msg);
			exit();
		}
	}
 
	$_SESSION["timeout"] = time();
	
	// Authorize users to access page. Function is found in authorize.php.
	// Current user groups are Administrators, emails, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	authorize_user(array("Administrators"));

	
	//Query Database for any current entries

	$eventID = find_event_by_id($_GET["id"]);
		
		$id = $eventID["id"];

		$query = "DELETE FROM calendar ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		$result = mysql_query($query);
		
		redirect_to("view_event.php"); 
		



	function redirect_to($new_location)
	{
		header("Location: " . $new_location);
		exit;
	}

	

	function find_event_by_id($event_id)
	{
		global $connection;
		
		$safe_event_id = mysql_real_escape_string($event_id);
		
		$query = "SELECT * ";
		$query .= "FROM calendar ";
		$query .= "WHERE id = {$safe_event_id} ";
		$query .= "LIMIT 1";
		$event_set = mysql_query($query);
		if ($eventret= mysql_fetch_assoc($event_set))
		{
			return $eventret;
		}
		else
		{
			return null;
		}
	

	}





?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>



	

<body>
</body>
</html>