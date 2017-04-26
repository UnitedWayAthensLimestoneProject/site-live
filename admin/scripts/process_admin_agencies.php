<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$form_id = $_REQUEST['form_id'];
	
	if ($form_id == 'submit_form_admin_agencies_add') {
		
		$add_agency_name = mysql_real_escape_string(trim($_REQUEST['add_agency_name']));
		$add_agency_address = mysql_real_escape_string(trim($_REQUEST['add_agency_address']));
		$add_agency_city = mysql_real_escape_string(trim($_REQUEST['add_agency_city']));
		$add_agency_state = mysql_real_escape_string(trim($_REQUEST['add_agency_state']));
		$add_agency_zipcode = mysql_real_escape_string(trim($_REQUEST['add_agency_zipcode']));
		$add_agency_phone = mysql_real_escape_string(trim($_REQUEST['add_agency_phone']));
		$add_active = 1;
			
		try {
			$insert_sql = sprintf("INSERT INTO agency " .
 					  			  "			  (agy_name, " .
 					  			  "			   agy_street_address, " .
 					  			  "			   agy_city, " .
 					  			  "			   agy_state, " .
 					  			  "			   agy_zip_code, " .
 					  			  "			   agy_phone, " .
 					  			  "			   active) " .
 					  			  "	   VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s');",
 					  			  $add_agency_name, $add_agency_address, $add_agency_city, $add_agency_state, $add_agency_zipcode, $add_agency_phone, $add_active);
				  
			mysql_query($insert_sql)
				or handle_error("an error occurred while adding the new partner agency", mysql_error());
				
			// Redirect to user admin page
			$msg = "The new partner agency has been successfully added.";
			header("Location: ../admin_agencies.php?success_message=" . $msg);
			
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to save new partner agency.",
						 "Error saving new partner agency: " . $exc->getMessage());
		}
		
	}
	
	if ($form_id == 'submit_form_admin_agencies_edit') {
		
		$processType = $_REQUEST['submitEditAgency'];
		
		if ($processType == 'Save Agency') {
		
		$edit_agency_name = mysql_real_escape_string(trim($_REQUEST['edit_agency_name']));
		$edit_agency_address = mysql_real_escape_string(trim($_REQUEST['edit_agency_address']));
		$edit_agency_city = mysql_real_escape_string(trim($_REQUEST['edit_agency_city']));
		$edit_agency_state = mysql_real_escape_string(trim($_REQUEST['edit_agency_state']));
		$edit_agency_zipcode = mysql_real_escape_string(trim($_REQUEST['edit_agency_zipcode']));
		$edit_agency_phone = mysql_real_escape_string(trim($_REQUEST['edit_agency_phone']));
		$edit_agency_active = $_REQUEST['edit_agency_active'];
		
		try {
			$update_query = sprintf("UPDATE agency" .
									"   SET agy_name = '%s', ".
									"		agy_street_address = '%s', " .
									"		agy_city = '%s', " .
									"		agy_state = '%s', " .
									"		agy_zip_code = '%s', " .
									"		agy_phone = '%s', " .
									"		active = '%s' " .
									" WHERE agy_id = '%s';",
									$edit_agency_name, $edit_agency_address, $edit_agency_city, $edit_agency_state,
									$edit_agency_zipcode, $edit_agency_phone, $edit_agency_active, $edit_agency_id);
		
			mysql_query($update_query)
				or handle_error("an error occurred while updating the partner agency", mysql_error());
				
			// Redirect to view volunteer info
			$msg = "The partner agency has been successfully updated.";
			header("Location: ../admin_agencies.php?success_message=" . $msg);
			
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to update the partner agency.",
						 "Error updating the partner agency: " . $exc->getMessage());
		}
		}
		else if ($processType == 'Delete') {
		
		try {
			$agy_id = mysql_real_escape_string($_REQUEST['submit_agy_id']);
			
			
				
			$delete_agy_query = "DELETE FROM agency " .
								"	   WHERE agy_id = {$agy_id}";
			
			mysql_query($delete_agy_query)
				or handle_error("an error occurred while deleting the agency", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("Something went wrong while attempting to delete the agency.",
						 "Error deleting agency: " . $exc->getMessage());
		}
		
		// Redirect to view agency info
		$msg = "The agency has been successfully deleted.";
		header("Location: ../admin_agencies.php?success_message=" . $msg);
	}
	}
	exit();
?>