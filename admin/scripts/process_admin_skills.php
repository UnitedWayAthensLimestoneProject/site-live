<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$form_id = $_REQUEST['form_id'];
	
	if ($form_id == 'submit_form_admin_skills_add') {
			
		$add_skill_name = mysql_real_escape_string(trim($_REQUEST['add_skill_name']));
		$add_skill_group = mysql_real_escape_string(trim($_REQUEST['add_skill_group']));
		$add_skill_comments = mysql_real_escape_string(trim($_REQUEST['add_skill_comments']));
			
		try {
			$insert_sql = sprintf("INSERT INTO skill " .
 					  			  "(skill_name, skill_group, skill_comments) " .
 					  			  "VALUES ('%s', '%s', '%s');",
 					  			  $add_skill_name, $add_skill_group, $add_skill_comments);
				  
 			mysql_query($insert_sql)
				or handle_error("an error occurred while adding skill", mysql_error());
				
			// Redirect to view volunteer info
			$msg = "The skill has been successfully added.";
			header("Location: ../admin_skills.php?success_message=" . $msg);
			
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to save skill.",
						 "Error saving skill: " . $exc->getMessage());
		}
		
	}
	
	if ($form_id == 'submit_form_admin_skills_edit_selection') {
		
		$edit_skill_id = $_REQUEST['edit_skill_id'];
		$edit_skill_name = mysql_real_escape_string(trim($_REQUEST['edit_skill_name']));
		$edit_skill_group = mysql_real_escape_string(trim($_REQUEST['edit_skill_group']));
		$edit_skill_comments = mysql_real_escape_string(trim($_REQUEST['edit_skill_comments']));
		$edit_skill_enabled = $_REQUEST['edit_skill_enabled'];
		
		try {
			$update_query = sprintf("UPDATE skill" .
									"   SET skill_name = '%s', ".
									"		skill_group = '%s', " .
									"		skill_comments = '%s', " .
									"		enabled = '%s' " .
									" WHERE skill_id = '%s';",
									$edit_skill_name, $edit_skill_group, $edit_skill_comments,
									$edit_skill_enabled, $edit_skill_id);
		
			mysql_query($update_query)
				or handle_error("an error occurred while updating skill", mysql_error());
				
			// Redirect to view volunteer info
			$msg = "The skill has been successfully updated.";
			header("Location: ../admin_skills.php?success_message=" . $msg);
			exit();
			
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to update skill.",
						 "Error updating skill: " . $exc->getMessage());
		}
		
	}
		
?>