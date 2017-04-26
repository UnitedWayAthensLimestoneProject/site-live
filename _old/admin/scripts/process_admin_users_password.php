<?php

	require_once 'authorize.php';
	require_once 'database_connection.php';
	require_once 'functions.php';
	
	session_start();
		
	$change_pw_user_id = $_REQUEST['change_pw_user_id'];
	$change_pw_user_name = mysql_real_escape_string(trim($_REQUEST['change_pw_username']));
	$change_pw_user_password = mysql_real_escape_string(trim($_REQUEST['change_user_pw']));
	
	try {
		$update_query = sprintf("UPDATE users" .
								"   SET password = '%s' " .
								" WHERE user_id = '%s';",
								crypt($change_pw_user_password, $change_pw_user_name), $change_pw_user_id);
	
		mysql_query($update_query)
			or handle_error("an error occurred while updating user's password", mysql_error());
			
			
		// Redirect to view volunteer info
		$msg = "Password has been successfully updated.";
		header("Location: ../admin_users.php?success_message=" . $msg);
		
	} catch (Exception $exc) {
		handle_error("something went wrong while attempting to update user's password.",
					 "Error updating user's password: " . $exc->getMessage());
	}
	
	exit();
?>