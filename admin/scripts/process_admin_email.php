<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['submitAdminVol']);
	$email_id = mysql_real_escape_string($_REQUEST['submit_email_id']);

	if ($processType == 'Update') {

		try {
			$email_display_name = mysql_real_escape_string(trim($_REQUEST['email_display_name']));
			$email_address = mysql_real_escape_string(trim($_REQUEST['email_address']));
			$email_action_id = mysql_real_escape_string(trim($_REQUEST['email_action_id']));
			
			$update_sql = sprintf("UPDATE email_forms " .
								  "   SET email_display_name = '%s', " .
								  "		  email_address = '%s', " .
								  "		  email_action_id = '%s' " .
								  " WHERE email_id = '%s'",
								  $email_display_name, $email_address,
								  $email_action_id, $email_id);
				  
			mysql_query($update_sql)
				or handle_error("an error occurred while updating email", mysql_error());

		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to update email.",
						 "Error updating email: " . $exc->getMessage());
		}
		
		$msg = "The email has been successfully updated.";
		header("Location: /admin/admin_emails.php?success_message=" . $msg);
		
	} else if ($processType == 'Delete') {
		
		try {

		$delete_vol_query = "DELETE FROM email_forms " .
								"	   WHERE email_id = {$email_id}";
			
			mysql_query($delete_vol_query)
				or handle_error("an error occurred while deleting the email", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete email.",
						 "Error deleting email: " . $exc->getMessage());
		}
		
		// Redirect to view email info
		$msg = "The email has been successfully deleted.";
		header("Location: /admin/admin_emails.php?success_message=" . $msg);
	}
	
	exit();
?>
