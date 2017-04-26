<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['submitAdminVol']);
	$donation_id = mysql_real_escape_string($_REQUEST['submit_donation_id']);

	if ($processType == 'Update') {

		try {
		
		$first_name = mysql_real_escape_string(trim($_REQUEST['first_name']));
		$middle_initial = mysql_real_escape_string(trim($_REQUEST['middle_initial']));
		$last_name = mysql_real_escape_string(trim($_REQUEST['last_name']));
		$date_of_birth = date_reformat(mysql_real_escape_string(trim($_REQUEST['dob'])));
		$email = mysql_real_escape_string(trim($_REQUEST['email']));
		$home_phone = mysql_real_escape_string(trim($_REQUEST['home_phone']));
		$cell_phone = mysql_real_escape_string(trim($_REQUEST['cell_phone']));
		
		$household_items = mysql_real_escape_string(trim($_REQUEST['household_items']));
		$baby_items = mysql_real_escape_string(trim($_REQUEST['baby_items']));
		$misc_items = mysql_real_escape_string(trim($_REQUEST['misc_items']));
		$bulk_items = mysql_real_escape_string(trim($_REQUEST['bulk_items']));
		
		$item_desc = mysql_real_escape_string(trim($_REQUEST['item_desc']));
		
		$item_condition = mysql_real_escape_string(trim($_REQUEST['item_condition']));
		
		$used_item_condition = mysql_real_escape_string(trim($_REQUEST['used_item_condition']));
		
		$can_deliver = mysql_real_escape_string(trim($_REQUEST['can_deliver']));
		
		$can_store = mysql_real_escape_string(trim($_REQUEST['can_store']));
		
		$address_stored_items_st1 = mysql_real_escape_string(trim($_REQUEST['address_stored_items_st1']));
		$address_stored_items_st2 = mysql_real_escape_string(trim($_REQUEST['address_stored_items_st2']));
		$address_stored_items_city = mysql_real_escape_string(trim($_REQUEST['address_stored_items_city']));
		$address_stored_items_state = mysql_real_escape_string(trim($_REQUEST['address_stored_items_state']));
		$address_stored_items_zip = mysql_real_escape_string(trim($_REQUEST['address_stored_items_zip']));
			
			$update_sql = sprintf("UPDATE donation " .
								  "SET first_name = '%s', " .
								  "middle_initial = '%s', " .
								  "last_name = '%s', " .
								  "date_of_birth = '%s', " .
								  "email = '%s', " .
								  "home_phone = '%s', " .
								  "cell_phone = '%s', " .
								  "household_items = '%s', " .
								  "baby_items = '%s', " .
								  "misc_items = '%s', " .
								  "bulk_items = '%s', " .
								  "item_desc = '%s', " .
								  "item_condition = '%s', " .
								  "used_item_condition = '%s', " .
								  "can_deliver = '%s', " .
								  "address_stored_items_st1 = '%s', " .
								  "address_stored_items_st2 = '%s', " .
								  "address_stored_items_city = '%s', " .
								  "address_stored_items_state = '%s', " .
								  "address_stored_items_zip = '%s', " .
								  "ip_address = '%s' " .
								  " WHERE donation_id = '%s'",
                                    $first_name, $middle_initial, $last_name,
                                    $date_of_birth, $email, $home_phone,
                                    $cell_phone, $household_items,
                                    $baby_items, $misc_items,
                                    $bulk_items, $item_desc,
                                    $item_condition, $used_item_condition, $can_deliver,
                                    $address_stored_items_st1, $address_stored_items_st2,
                                    $address_stored_items_city, $address_stored_items_state, $address_stored_items_zip, $_SERVER['REMOTE_ADDR'],$donation_id);
				  
			mysql_query($update_sql)
				or handle_error("an error occurred while updating donation", mysql_error());


		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to update donation.",
						 "Error saving donation: " . $exc->getMessage());
		}
	
		// Redirect to view donation info
		$msg = "The donation has been successfully updated.";
		header("Location: ../admin_donation.php?success_message=" . $msg);
		exit();
		
	} else if ($processType == 'Delete') {
		
		try {
		
		$delete_opp_query = "DELETE FROM donation WHERE donation_id = {$donation_id}";
			
		mysql_query($delete_opp_query)
				or handle_error("an error occurred while deleting the donation", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete donation.",
						 "Error deleting donation: " . $exc->getMessage());
		}
		
		// Redirect to view donation info
		$msg = "The donation has been successfully deleted.";
		header("Location: /admin/admin_donation.php?success_message=" . $msg);
		exit();
	}
		
	$msg = "Unable to Process.";
	header("Location: /admin/admin_donation.php?success_message=" . $msg);
		
	exit();
?>
