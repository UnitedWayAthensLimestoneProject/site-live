<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['submitProcessGrp']);
	
	if ($processType == 'Approve') {
	
		try {
			$grp_id = mysql_real_escape_string($_REQUEST['submit_grp_id']);
			$group_name = mysql_real_escape_string(trim($_REQUEST['group_name']));
			$contact = mysql_real_escape_string(trim($_REQUEST['contact']));
			$dob = date_reformat(mysql_real_escape_string(trim($_REQUEST['dob'])));
			$email = mysql_real_escape_string(trim($_REQUEST['email']));
			$phone_num = mysql_real_escape_string(trim($_REQUEST['phone_num']));
			$cell_phone = mysql_real_escape_string(trim($_REQUEST['cell_phone']));
			$street_address = mysql_real_escape_string(trim($_REQUEST['street_address']));
			$city = mysql_real_escape_string(trim($_REQUEST['city']));
			$state = mysql_real_escape_string(trim($_REQUEST['state']));
			$zip_code = mysql_real_escape_string(trim($_REQUEST['zip_code']));
			$health_limits = mysql_real_escape_string($_REQUEST['health_limits']);
			$health_limits_comment = mysql_real_escape_string(trim($_REQUEST['health_limits_comment']));
			$affiliated = mysql_real_escape_string($_REQUEST['affiliated']);
			$affiliated_comment = mysql_real_escape_string(trim($_REQUEST['affiliated_comment']));
			$limestone = mysql_real_escape_string($_REQUEST['limestone']);
			$neighbor = mysql_real_escape_string($_REQUEST['neighbor']);
			$anywhere = mysql_real_escape_string($_REQUEST['anywhere']);
			$emer_first_name = mysql_real_escape_string(trim($_REQUEST['emer_first_name']));
			$emer_last_name = mysql_real_escape_string(trim($_REQUEST['emer_last_name']));
			$emer_email = mysql_real_escape_string(trim($_REQUEST['emer_email']));
			$emer_phone = mysql_real_escape_string(trim($_REQUEST['emer_phone']));
			$special_skills = mysql_real_escape_string($_REQUEST['special_skills']);
			$special_skills_comment = mysql_real_escape_string(trim($_REQUEST['special_skills_comment']));
			$admin_review = 1;
			$active = mysql_real_escape_string(trim($_REQUEST['active_inactive']));
			
			foreach($_REQUEST['checkbox'] as $cb) {
				if ($cb > 0) {
					$skill[] = $cb;
				}
			}
	
			$update_sql = sprintf("UPDATE grp_t " .
								  "   SET group_name = '%s', " .
								  "		  contact = '%s', " .
								  "		  date_of_birth = '%s', " .
								  "		  email_address = '%s', " .
								  "		  phone_num = '%s', " .
								  "		  cell_phone = '%s', " .
								  "		  street_address = '%s', " .
								  "		  city = '%s', " .
								  "		  state = '%s', " .
								  "		  zip_code = '%s', " .
								  "		  health_limits = '%s', " .
								  "		  health_limits_comment = '%s', " .
								  "		  affiliated = '%s', " .
								  "		  affiliated_comment = '%s', " .
								  "		  location_limestone_county = '%s', " .
								  "		  location_neighbor_county = '%s', " .
								  "		  location_anywhere = '%s', " .
								  "		  emer_con_first_name = '%s', " .
								  "		  emer_con_last_name = '%s', " .
								  "		  emer_con_email = '%s', " .
								  "		  emer_con_phone = '%s', " .
								  "		  special_skills = '%s', " .
								  "		  special_skills_comment = '%s', " .
								  "		  admin_review = '%s', " .
								  "		  active = '%s' " .
								  " WHERE grp_id = '%s'",
								  $group_name, $contact,
								  $dob, $email, $phone_num, 
								  $cell_phone, $street_address,
								  $city, $state, $zip_code, 
								  $health_limits,
								  $health_limits_comment, $affiliated, $affiliated_comment,
								  $limestone, $neighbor, $anywhere,
								  $emer_first_name, $emer_last_name, $emer_email,
								  $emer_phone, $special_skills, $special_skills_comment,
								  $admin_review, $active, $grp_id);
					  
			mysql_query($update_sql)
				or handle_error("an error occurred while updating group", mysql_error());
	
			$delete_query = "DELETE FROM group_skill " .
							"	   WHERE grp_id = {$grp_id}";
			
			mysql_query($delete_query)
				or handle_error("an error occurred while deleting skills associated with the group", mysql_error());
	
			
			foreach ($skill as $sk) {
				$insert_sql = "INSERT INTO group_skill (grp_id, skill_id) " .
							  "VALUES ('{$grp_id}', '{$sk}')";
				mysql_query($insert_sql)
					or handle_error("an error occurred while updating skills", mysql_error());
			}
	
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to update group.",
						 "Error saving group: " . $exc->getMessage());
		}
		
		// Redirect to view group info
		$msg = "The group has been successfully approved and updated.";
		header("Location: ../admin_reviews_groups.php?success_message=" . $msg);
		
	} else if ($processType == 'Delete') {
		
		try {
			$grp_id = mysql_real_escape_string($_REQUEST['submit_grp_id']);
			
			$delete_skills_query = "DELETE FROM group_skill " .
								   "	  WHERE grp_id = {$grp_id}";
			
			mysql_query($delete_skills_query)
				or handle_error("an error occurred while deleting skills associated with the group", mysql_error());
				
			$delete_grp_query = "DELETE FROM grp_t " .
								"	   WHERE grp_id = {$grp_id}";
			
			mysql_query($delete_grp_query)
				or handle_error("an error occurred while deleting the group", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete group.",
						 "Error deleting group: " . $exc->getMessage());
		}
		
		// Redirect to view group info
		$msg = "The group has been successfully deleted.";
		header("Location: ../admin_reviews_groups.php?success_message=" . $msg);
	}
	
	exit();
?>
