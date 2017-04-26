<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['submitAdminVol']);
	$damage_id = mysql_real_escape_string($_REQUEST['submit_damage_id']);

	if ($processType == 'Update') {

		try {
		
		$first_name = mysql_real_escape_string(trim($_REQUEST['first_name']));
		$middle_initial = mysql_real_escape_string(trim($_REQUEST['middle_initial']));
		$last_name = mysql_real_escape_string(trim($_REQUEST['last_name']));
		$date_of_birth = date_reformat(mysql_real_escape_string(trim($_REQUEST['dob'])));
		$email = mysql_real_escape_string(trim($_REQUEST['email']));
		$home_phone = mysql_real_escape_string(trim($_REQUEST['home_phone']));
		$cell_phone = mysql_real_escape_string(trim($_REQUEST['cell_phone']));
		$add_st1 = mysql_real_escape_string(trim($_REQUEST['pre_add_st1']));
		$add_st2 = mysql_real_escape_string(trim($_REQUEST['pre_add_st2']));
		$add_city = mysql_real_escape_string(trim($_REQUEST['pre_add_city']));
		$add_state = mysql_real_escape_string(trim($_REQUEST['pre_add_state']));
		$add_zip = mysql_real_escape_string(trim($_REQUEST['pre_add_zip']));
		$health_limitation = (int)mysql_real_escape_string(trim($_REQUEST['health_limits']));
		$health_limit_desc = mysql_real_escape_string(trim($_REQUEST['health_limits_comment']));
		$dwelling = mysql_real_escape_string(trim($_REQUEST['dwelling']));
		$owner_renter_info = mysql_real_escape_string(trim($_REQUEST['owner_renter_info']));
		$dwelling_use = mysql_real_escape_string($_REQUEST['dwelling_use']);
		$leveL_of_damage = mysql_real_escape_string($_REQUEST['levofdamage']);
			
			$update_sql = sprintf("UPDATE damage " .
								  "   SET first_name = '%s', " .
								  "		  middle_initial = '%s', " .
								  "		  last_name = '%s', " .
								  "		  date_of_birth = '%s', " .
								  "		  email = '%s', " .
								  "		  home_phone = '%s', " .
								  "		  cell_phone = '%s', " .
								  "		  add_st1 = '%s', " .
								  "		  add_st2 = '%s', " .
								  "		  add_city = '%s', " .
								  "		  add_state = '%s', " .
								  "		  add_zip = '%s', " .
								  "		  health_limitation = '%s', " .
								  "		  health_limit_desc = '%s', " .
								  "		  dwelling = '%s', " .
								  "		  owner_renter_info = '%s', " .
								  "		  level_of_damage = '%s', " .
								  "		  ip_address = '%s' " .
								  " WHERE damage_id = '%s'",
                                    $first_name, $middle_initial, $last_name,
                                    $date_of_birth, $email, $home_phone,
                                    $cell_phone,
                                    $add_st1, $add_st2,
                                    $add_city, $add_state, $add_zip,
                                    $health_limitation, $health_limit_desc,
                                    $dwelling, $owner_renter_info,
                                    $leveL_of_damage, $_SERVER['REMOTE_ADDR'],$damage_id);
				  
			mysql_query($update_sql)
				or handle_error("an error occurred while updating damage", mysql_error());


		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to update damage.",
						 "Error saving damage: " . $exc->getMessage());
		}
	
		// Redirect to view damage info
		$msg = "The damage has been successfully updated.";
		header("Location: ../admin_damage.php?success_message=" . $msg);
		exit();
		
	} else if ($processType == 'Delete') {
		
		try {
		
		$delete_opp_query = "DELETE FROM damage WHERE damage_id = {$damage_id}";
			
		mysql_query($delete_opp_query)
				or handle_error("an error occurred while deleting the damage", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete damage.",
						 "Error deleting damage: " . $exc->getMessage());
		}
		
		// Redirect to view damage info
		$msg = "The damage has been successfully deleted.";
		header("Location: /admin/admin_damage.php?success_message=" . $msg);
		exit();
	}
		
	$msg = "Unable to Process.";
	header("Location: /admin/admin_damage.php?success_message=" . $msg);
		
	exit();
?>
