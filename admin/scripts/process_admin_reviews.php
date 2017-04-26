<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['submitProcessVol']);
	
	if ($processType == 'Approve') {
	
		try {
			$vol_id = mysql_real_escape_string($_REQUEST['submit_vol_id']);
			$first_name = mysql_real_escape_string(trim($_REQUEST['first_name']));
			$middle_initial = mysql_real_escape_string(trim($_REQUEST['middle_initial']));
			$last_name = mysql_real_escape_string(trim($_REQUEST['last_name']));
			$dob = date_reformat(mysql_real_escape_string(trim($_REQUEST['dob'])));
			$email = mysql_real_escape_string(trim($_REQUEST['email']));
			$home_phone = mysql_real_escape_string(trim($_REQUEST['home_phone']));
			$cell_phone = mysql_real_escape_string(trim($_REQUEST['cell_phone']));
			$street_address1 = mysql_real_escape_string(trim($_REQUEST['street_address1']));
			$street_address2 = mysql_real_escape_string(trim($_REQUEST['street_address2']));
			$city = mysql_real_escape_string(trim($_REQUEST['city']));
			$state = mysql_real_escape_string(trim($_REQUEST['state']));
			$zip_code = mysql_real_escape_string(trim($_REQUEST['zip_code']));
			$occupation = mysql_real_escape_string(trim($_REQUEST['occupation']));
			$employer = mysql_real_escape_string(trim($_REQUEST['employer']));
			$health_limits = mysql_real_escape_string($_REQUEST['health_limits']);
			$health_limits_comment = mysql_real_escape_string(trim($_REQUEST['health_limits_comment']));
			$affiliated = mysql_real_escape_string($_REQUEST['affiliated']);
			$affiliated_comment = mysql_real_escape_string(trim($_REQUEST['affiliated_comment']));
			$limestone = mysql_real_escape_string($_REQUEST['limestone']);
			$neighbor = mysql_real_escape_string($_REQUEST['neighbor']);
			$anywhere = mysql_real_escape_string($_REQUEST['anywhere']);
			$emer_first_name = mysql_real_escape_string(trim($_REQUEST['emer_first_name']));
			$emer_last_name = mysql_real_escape_string(trim($_REQUEST['emer_last_name']));
			$emer_relationship = mysql_real_escape_string(trim($_REQUEST['emer_relationship']));
			$emer_phone = mysql_real_escape_string(trim($_REQUEST['emer_phone']));
			$special_skills = mysql_real_escape_string($_REQUEST['special_skills']);
			$special_skills_comment = mysql_real_escape_string(trim($_REQUEST['special_skills_comment']));
		/*	**ASU2016**  Added database fields for (disaster, community, and ssn) that were missing in updates		6/19/2016		*/
			$disaster = mysql_real_escape_string(trim($_REQUEST['disaster']));
			$community = mysql_real_escape_string(trim($_REQUEST['community']));
			$ssn = mysql_real_escape_string(trim($_REQUEST['ssn']));
		/* **ASU2016**  End added code 6/19/2016   */

			$admin_review = 1;
			$active = mysql_real_escape_string(trim($_REQUEST['active_inactive']));
			
			foreach($_REQUEST['checkbox'] as $cb) {
				if ($cb > 0) {
					$skill[] = $cb;
				}
			}
	
			$update_sql = sprintf("UPDATE volunteers " .
								  "   SET first_name = '%s', " .
								  "		  middle_initial = '%s', " .
								  "		  last_name = '%s', " .
								  "		  date_of_birth = '%s', " .
								  "		  email_address = '%s', " .
								  "		  home_phone = '%s', " .
								  "		  cell_phone = '%s', " .
								  "		  street_address1 = '%s', " .
								  "		  street_address2 = '%s', " .
								  "		  city = '%s', " .
								  "		  state = '%s', " .
								  "		  zip_code = '%s', " .
								  "		  occupation = '%s', " .
								  "		  employer = '%s', " .
								  "		  health_limits = '%s', " .
								  "		  health_limits_comment = '%s', " .
								  "		  affiliated = '%s', " .
								  "		  affiliated_comment = '%s', " .
								  "		  location_limestone_county = '%s', " .
								  "		  location_neighbor_county = '%s', " .
								  "		  location_anywhere = '%s', " .
								  "		  emer_con_first_name = '%s', " .
								  "		  emer_con_last_name = '%s', " .
								  "		  emer_con_relationship = '%s', " .
								  "		  emer_con_phone = '%s', " .
								  "		  special_skills = '%s', " .
								  "		  special_skills_comment = '%s', " .
			/*	**ASU2016**  Added database fields for (disaster, community, ans ssn) that were missing in updates		6/19/2016		*/
								  "		  disaster = '%s', " .
								  "		  community = '%s', " .
								  "		  ssn = '%s', " .		
			/* **ASU2016**  End added code 6/19/2016   */
								  "		  admin_review = '%s', " .
								  "		  active = '%s' " .
								  " WHERE vol_id = '%s'",
								  $first_name, $middle_initial, $last_name,
								  $dob, $email, $home_phone, 
								  $cell_phone, $street_address1, $street_address2,
								  $city, $state, $zip_code, 
								  $occupation, $employer, $health_limits,
								  $health_limits_comment, $affiliated, $affiliated_comment,
								  $limestone, $neighbor, $anywhere,
								  $emer_first_name, $emer_last_name, $emer_relationship,
								  $emer_phone, $special_skills, $special_skills_comment,
			/*	**ASU2016**  Added database fields for (disaster, community, ans ssn) that were missing in updates		6/19/2016	*/						  
								  $disaster, $community, $ssn, 
			/* **ASU2016**  End added code 6/19/2016   */							  
								  $admin_review, $active, $vol_id);
					  
			mysql_query($update_sql)
				or handle_error("an error occurred while updating volunteer", mysql_error());
	
			$delete_query = "DELETE FROM vol_skill " .
							"	   WHERE vol_id = {$vol_id}";
			
			mysql_query($delete_query)
				or handle_error("an error occurred while deleting skills associated with the volunteer", mysql_error());
	
			
			foreach ($skill as $sk) {
				$insert_sql = "INSERT INTO vol_skill (vol_id, skill_id) " .
							  "VALUES ('{$vol_id}', '{$sk}')";
				mysql_query($insert_sql)
					or handle_error("an error occurred while updating skills", mysql_error());
			}
	
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to update volunteer.",
						 "Error saving volunteer: " . $exc->getMessage());
		}
		
		// Redirect to view volunteer info
		$msg = "The volunteer has been successfully approved and updated.";
		header("Location: ../admin_reviews.php?success_message=" . $msg);
		
	} else if ($processType == 'Delete') {
		
		try {
			$vol_id = mysql_real_escape_string($_REQUEST['submit_vol_id']);
			
			$delete_skills_query = "DELETE FROM vol_skill " .
								   "	  WHERE vol_id = {$vol_id}";
			
			mysql_query($delete_skills_query)
				or handle_error("an error occurred while deleting skills associated with the volunteer", mysql_error());
				
			$delete_vol_query = "DELETE FROM volunteers " .
								"	   WHERE vol_id = {$vol_id}";
			
			mysql_query($delete_vol_query)
				or handle_error("an error occurred while deleting the volunteer", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete volunteer.",
						 "Error deleting volunteer: " . $exc->getMessage());
		}
		
		// Redirect to view volunteer info
		$msg = "The volunteer has been successfully deleted.";
		header("Location: ../admin_reviews.php?success_message=" . $msg);
	}
	
	exit();
?>
