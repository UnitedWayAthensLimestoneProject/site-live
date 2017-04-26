<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	
	$form_id = mysql_real_escape_string(trim($_REQUEST['form_id']));
	
	
	
	
if ($form_id == 'submit_email_form') {
		session_start();
		
	
	try {
		$email_display_name = mysql_real_escape_string(trim($_REQUEST['email_display_name']));
		$email_address = mysql_real_escape_string(trim($_REQUEST['email_address']));
		$email_action_id = mysql_real_escape_string(trim($_REQUEST['email_action_id']));
		

 
		$insert_sql = sprintf("INSERT INTO email_forms " .
							  			 "(email_display_name, email_address, email_action_id) " .
							  "VALUES ('%s', '%s', '%s');",
                                    $email_display_name, $email_address, $email_action_id);

        mysql_query($insert_sql)
			or handle_error("An error occurred while reporting email", mysql_error());


	} catch (Exception $exc) {
		handle_error("Something went wrong while attempting to save email.",
					 "Error saving email: " . $exc->getMessage());
	}

    // redirect on success
	header("Location: /admin/admin_emails.php");

	exit();
}