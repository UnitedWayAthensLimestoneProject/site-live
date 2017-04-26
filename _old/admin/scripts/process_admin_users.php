<?php

	require_once 'authorize.php';
	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$form_id = $_REQUEST['form_id'];
	
	session_start();
	
	if ($form_id == 'submit_form_admin_user_add') {
			
		$add_user_name = mysql_real_escape_string(trim($_REQUEST['add_user_name']));
		$add_user_pw = mysql_real_escape_string(trim($_REQUEST['add_user_pw']));
		$add_name = mysql_real_escape_string(trim($_REQUEST['add_name']));
		$add_user_email = mysql_real_escape_string(trim($_REQUEST['add_user_email']));
		$add_active = 1;
		$group_id = $_REQUEST['groupID'];
		
			
		try {
			$insert_sql = sprintf("INSERT INTO users " .
 					  			  "(username, password, name, email, active) " .
 					  			  "VALUES ('%s', '%s', '%s', '%s', '%s');",
 					  			  $add_user_name, crypt($add_user_pw, $add_user_name), $add_name, $add_user_email, $add_active);
				  
 			mysql_query($insert_sql)
				or handle_error("an error occurred while adding user", mysql_error());
				
			$user_id = mysql_insert_id();
			
			$insert_sql2 = "INSERT INTO user_groups (user_id, group_id) " .
						  "VALUES ('{$user_id}', '{$group_id}')";
						  
			mysql_query($insert_sql2)
				or handle_error("an error occurred while adding user group", mysql_error());
				
			// Redirect to user admin page
			$msg = "The new user has been successfully added.";
			header("Location: ../admin_users.php?success_message=" . $msg);
			
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to save new user.",
						 "Error saving new user: " . $exc->getMessage());
		}
		
	}
	
	if ($form_id == 'submit_form_admin_users_edit_selection') {
		
		$edit_user_id = $_REQUEST['edit_user_id'];
		$edit_user_name = mysql_real_escape_string(trim($_REQUEST['edit_user_name']));
		$edit_name = mysql_real_escape_string(trim($_REQUEST['edit_name']));
		$edit_user_email = mysql_real_escape_string(trim($_REQUEST['edit_user_email']));
		$edit_user_active = $_REQUEST['edit_user_active'];
		$edit_group_id = $_REQUEST['groupID'];
		
		try {
			$update_query = sprintf("UPDATE users" .
									"   SET username = '%s', ".
									"		name = '%s', " .
									"		email = '%s', " .
									"		active = '%s' " .
									" WHERE user_id = '%s';",
									$edit_user_name, $edit_name, $edit_user_email,
									$edit_user_active, $edit_user_id);
		
			mysql_query($update_query)
				or handle_error("an error occurred while updating user", mysql_error());
				
			$update_query2 = sprintf("UPDATE user_groups" .
							 		 "   SET group_id = '%s' " .
							 		 " WHERE user_id = '%s';",
							 		 $edit_group_id, $edit_user_id);
							 		 
			mysql_query($update_query2)
				or handle_error("an error occurred while updating user's group", mysql_error());
				
			// Redirect to view volunteer info
			$msg = "The skill has been successfully updated.";
			header("Location: ../admin_users.php?success_message=" . $msg);
			
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to update user.",
						 "Error updating user: " . $exc->getMessage());
		}
		
	}
	exit();
?>