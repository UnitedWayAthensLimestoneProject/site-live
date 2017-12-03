<?php

	//Need to build a database to connect this to
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

	if (isset ($_POST['submit']))
	{
		//Convert from 12 to 24 hr time format
		$newTime = date("H:i", strtotime($_POST["time"]));

		$datedb = mysql_prep($_POST["date"]);
		$timedb = mysql_prep($newTime);
		$locationdb = mysql_prep($_POST["location"]);
		$eventdb = mysql_prep($_POST["event"]);
		$id = $eventID["id"];


		$query = "INSERT INTO calendar (date, time, event, location) VALUES (";
		$query .= " '{$datedb}', '{$timedb}', '{$eventdb}', '{$locationdb}' ";
		$query .= ")";
		$result= mysql_query($query);


		redirect_to("view_event.php");
	}



	function redirect_to($new_location)
	{
		header("Location: " . $new_location);
		exit;
	}

	function mysql_prep($string)
	{
		global $connection;

		$escaped_string = mysql_real_escape_string($string);
		return $escaped_string;
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

	page_start("United Way of Athens/Limestone County EMD Admin Page", NULL, "createEvent",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<!-- JavaScript GUI date and time pickers -->
<!-- compatible with all browsers -->
<script>
$(document).ready(function() {
    $("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
		$('#timepicker').timepicker({ 'timeFormat': 'h:i A' });
});
</script>

<div id="admin_form_container">

	<div class="form_description" align="center">
    <h2>Event Administration</h2>
    <p>Allows Administrators to create an event.</p>
	</div>

  <div id="eventTable"></div>
  <div class="adminDefaults">
  
    <form action = "create_event.php" method= "post">

		<input type="text" name = "date" id="datepicker" placeholder ="Date" required readonly>

		<input type="text" name = "time" id="timepicker" placeholder="Time" required>

 		<input type = "text" name = "event" placeholder = "Event Name"  maxlength="250" required>

		<input type = "text" name = "location" placeholder = "Event Location" maxlength="250" required><br><br>

 		<input type="submit" id="btnAdmin" name = "submit" value = "Create">
	</form>

  </div>
</div>

<body>
</body>
</html>
