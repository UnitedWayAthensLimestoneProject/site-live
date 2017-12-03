<?php

	require_once 'scripts/database_connection.php';
	require_once 'scripts/functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['submitAdminVol']);
	$event_id = mysql_real_escape_string($_REQUEST['submit_event_id']);

	if ($processType == 'Update') 
	{

		try 
		{
			$event_date = mysql_real_escape_string(trim($_REQUEST['event_date']));
			$event_event = mysql_real_escape_string(trim($_REQUEST['event_event']));
			$event_location = mysql_real_escape_string(trim($_REQUEST['event_location']));
			
			$update_sql = sprintf("UPDATE event_forms " .
								  "   SET event_date = '%s', " .
								  "		  event_event = '%s', " .
								  "		  event_location = '%s' " .
								  " WHERE event_id = '%s'",
								  $event_date, $event_event,
								  $event_location, $event_id);
				  
			mysql_query($update_sql)
				or handle_error("an error occurred while updating event", mysql_error());

		} 
		catch (Exception $exc) 
		{
			handle_error("something went wrong while attempting to update event.",
						 "Error updating event: " . $exc->getMessage());
		}
		
		$msg = "The event has been successfully updated.";
		header("Location: /admin/admin_events.php?success_message=" . $msg);
		
	} 
	else if ($processType == 'Delete') 
	{
		try 
		{
		$delete_event_query = "DELETE FROM event_forms " .
								"	   WHERE event_id = {$event_id}";
			
			mysql_query($delete_evenet_query)
				or handle_error("an error occurred while deleting the event", mysql_error());
				
		} 
		catch (Exception $exc) 
		{
			handle_error("something went wrong while attempting to delete event.",
						 "Error deleting event: " . $exc->getMessage());
		}
		
		// Redirect to view event info
		$msg = "The event has been successfully deleted.";
		header("Location: /admin/admin_events.php?success_message=" . $msg);
	}
	exit();
?>
