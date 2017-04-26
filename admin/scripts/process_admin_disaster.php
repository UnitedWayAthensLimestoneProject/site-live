<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['submitAdminVol']);
	$disaster_id = mysql_real_escape_string($_REQUEST['submit_disaster_id']);

	if ($processType == 'Update') {

		try {
		
		$first_name = mysql_real_escape_string(trim($_REQUEST['first_name']));
		$middle_initial = mysql_real_escape_string(trim($_REQUEST['middle_initial']));
		$last_name = mysql_real_escape_string(trim($_REQUEST['last_name']));
		$date_of_birth = date_reformat(mysql_real_escape_string(trim($_REQUEST['dob'])));
		$email = mysql_real_escape_string(trim($_REQUEST['email']));
		$home_phone = mysql_real_escape_string(trim($_REQUEST['home_phone']));
		$cell_phone = mysql_real_escape_string(trim($_REQUEST['cell_phone']));
		$have_interview = mysql_real_escape_string(trim($_REQUEST['interview']));
		$pre_add_st1 = mysql_real_escape_string(trim($_REQUEST['pre_add_st1']));
		$pre_add_st2 = mysql_real_escape_string(trim($_REQUEST['pre_add_st2']));
		$pre_add_city = mysql_real_escape_string(trim($_REQUEST['pre_add_city']));
		$pre_add_state = mysql_real_escape_string(trim($_REQUEST['pre_add_state']));
		$pre_add_zip = mysql_real_escape_string(trim($_REQUEST['pre_add_zip']));
		$post_add_st1 = mysql_real_escape_string(trim($_REQUEST['post_add_st1']));
		$post_add_st2 = mysql_real_escape_string(trim($_REQUEST['post_add_st2']));
		$post_add_city = mysql_real_escape_string(trim($_REQUEST['post_add_city']));
		$post_add_state = mysql_real_escape_string(trim($_REQUEST['post_add_state']));
		$post_add_zip = mysql_real_escape_string(trim($_REQUEST['post_add_zip']));
		$health_limitation = (int)mysql_real_escape_string(trim($_REQUEST['health_limits']));
		$health_limit_desc = mysql_real_escape_string(trim($_REQUEST['health_limits_comment']));
		$annual_income = mysql_real_escape_string(trim($_REQUEST['household_income']));
        $dwelling = mysql_real_escape_string(trim($_REQUEST['dwelling']));
		$owner_renter_info = mysql_real_escape_string(trim($_REQUEST['owner_renter_info']));
		$landlord_first_name = mysql_real_escape_string(trim($_REQUEST['landlord_first_name']));
		$landlord_last_name = mysql_real_escape_string(trim($_REQUEST['landlord_last_name']));
		$monthly_rent = (float)mysql_real_escape_string($_REQUEST['monthly_rent']);
		$monthly_utilities = (float)mysql_real_escape_string(trim($_REQUEST['monthly_utilities']));
		$dwelling_use = mysql_real_escape_string($_REQUEST['dwelling_use']);
		$dwelling_insurance_contents = (int)mysql_real_escape_string($_REQUEST['dwelling_insurance_contents']);
		$dwelling_insurance_hazzard = (int)mysql_real_escape_string($_REQUEST['dwelling_insurance_hazzard']);
		$dwelling_insurance_structure = (int)mysql_real_escape_string($_REQUEST['dwelling_insurance_structure']);
		$insurance_provider_name = mysql_real_escape_string(trim($_REQUEST['insurance_provider_name']));
		$insurance_provider_phone = mysql_real_escape_string($_REQUEST['insurance_provider_phone']);
		$leveL_of_damage = mysql_real_escape_string($_REQUEST['levofdamage']);
		$electricity_on = (int)mysql_real_escape_string($_REQUEST['elec_on_off']);
		$housing_need = (int)mysql_real_escape_string(trim($_REQUEST['housing_needs']));
		$housing_need_type = mysql_real_escape_string(trim($_REQUEST['housing_need_type']));
			
			$update_sql = sprintf("UPDATE disaster " .
								  "SET first_name = '%s', " .
								  "middle_initial = '%s', " .
								  "last_name = '%s', " .
								  "date_of_birth = '%s', " .
								  "email = '%s', " .
								  "home_phone = '%s', " .
								  "cell_phone = '%s', " .
								  "have_interview = '%s', " .
								  "interview_date = '%s', " .
								  "event_date = '%s', " .
								  "pre_add_st1 = '%s', " .
								  "pre_add_st2 = '%s', " .
								  "pre_add_city = '%s', " .
								  "pre_add_state = '%s', " .
								  "pre_add_zip = '%s', " .
								  "post_add_st1 = '%s', " .
								  "post_add_st2 = '%s', " .
								  "post_add_city = '%s', " .
								  "post_add_state = '%s', " .
								  "post_add_zip = '%s', " .
								  "health_limitation = '%s', " .
								  "health_limit_desc = '%s', " .
								  "annual_income = '%s', " .
								  "dwelling = '%s', " .
								  "owner_renter_info = '%s', " .
								  "landlord_first_name = '%s', " .
								  "landlord_last_name = '%s', " .
								  "monthly_rent = '%s', " .
								  "monthly_utilities = '%s', " .
								  "dwelling_use = '%s', " .
								  "dwelling_insurance_contents = '%s', " .
								  "dwelling_insurance_hazzard = '%s', " .
								  "dwelling_insurance_structure = '%s', " .
								  "insurance_provider_name = '%s', " .
								  "insurance_provider_phone = '%s', " .
								  "level_of_damage = '%s', " .
								  "electricity_on = '%s', " .
								  "housing_need = '%s', " .
								  "housing_need_type = '%s', " .
								  "ip_address = '%s' " .
								  "WHERE disaster_id = '%s'",
                                    $first_name, $middle_initial, $last_name,
                                    $date_of_birth, $email, $home_phone,
                                    $cell_phone, $have_interview,
                                    $interview_date, $event_date,
                                    $pre_add_st1, $pre_add_st2,
                                    $pre_add_city, $pre_add_state, $pre_add_zip,
                                    $post_add_st1, $post_add_st2,
                                    $post_add_city, $post_add_state, $post_add_zip,
                                    $health_limitation, $health_limit_desc,
                                    $annual_income, $dwelling,
                                    $owner_renter_info, $landlord_first_name, $landlord_last_name,
                                    $monthly_rent, $monthly_utilities, $dwelling_use,
                                    $dwelling_insurance_contents, $dwelling_insurance_hazzard, $dwelling_insurance_structure,
                                    $insurance_provider_name, $insurance_provider_phone,
                                    $leveL_of_damage, $electricity_on, $housing_need, $housing_need_type, $_SERVER['REMOTE_ADDR'],$disaster_id);
				  
			mysql_query($update_sql)
				or handle_error("an error occurred while updating disaster", mysql_error());


		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to update disaster.",
						 "Error saving disaster: " . $exc->getMessage());
		}
		
		//echo($update_sql);
		//echo(mysql_error());
		// Redirect to view disaster info
		$msg = "The disaster has been successfully updated.";
		header("Location: ../admin_disaster.php?success_message=" . $msg);
		exit();
		
	} else if ($processType == 'Delete') {
		
		try {
		
		$delete_opp_query = "DELETE FROM disaster WHERE disaster_id = {$disaster_id}";
			
		mysql_query($delete_opp_query)
				or handle_error("an error occurred while deleting the disaster", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete disaster.",
						 "Error deleting disaster: " . $exc->getMessage());
		}
		
		// Redirect to view disaster info
		$msg = "The disaster has been successfully deleted.";
		header("Location: /admin/admin_disaster.php?success_message=" . $msg);
		exit();
	}
		
	$msg = "Unable to Process.";
	header("Location: /admin/admin_disaster.php?success_message=" . $msg);
		
	exit();
?>
