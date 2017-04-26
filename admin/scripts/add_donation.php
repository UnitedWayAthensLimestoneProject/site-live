<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	
	$form_id = mysql_real_escape_string(trim($_REQUEST['form_id']));
	
	
	
	
if ($form_id == 'submit_disaster_relief') {
		session_start();
		
		require_once($_SERVER['DOCUMENT_ROOT']."/inc/securimage/securimage.php");
		$securimage = new Securimage();
		
		if ($securimage->check($_REQUEST['captcha_code']) == false) {
			// the code was incorrect
			// you should handle the error so that the form processor doesn't continue
			// or you can use the following code if there is no validation or you do not know how
			/*echo "The security code entered was incorrect.<br><br>";
			echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";*/
			header('Location: /captcha_error.html');
			exit();
		}
		
		$admin_review = 1;
		$active = 1;
	}
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
		

 
		$insert_sql = sprintf("INSERT INTO donation " .
							  			 "(first_name, middle_initial, last_name, " .
							  			  "date_of_birth, email, home_phone, " .
							  			  "cell_phone, household_items," .
							  			  "baby_items, misc_items," .
							  			  "bulk_items, item_desc, " .
							  			  "item_condition, used_item_condition, can_deliver, " .
							  			  "address_stored_items_st1, address_stored_items_st2, " .
							  			  "address_stored_items_city, address_stored_items_state, address_stored_items_zip, ip_address) " .
							  "VALUES ('%s', '%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', '%s', '%s');",
                                    $first_name, $middle_initial, $last_name,
                                    $date_of_birth, $email, $home_phone,
                                    $cell_phone, $household_items,
                                    $baby_items, $misc_items,
                                    $bulk_items, $item_desc,
                                    $item_condition, $used_item_condition, $can_deliver,
                                    $address_stored_items_st1, $address_stored_items_st2,
                                    $address_stored_items_city, $address_stored_items_state, $address_stored_items_zip, $_SERVER['REMOTE_ADDR']);

        mysql_query($insert_sql)
			or handle_error("An error occurred while reporting disaster", mysql_error());

		$disaster_id = mysql_insert_id();

		foreach ($members as $member) {
			$insert_sql = "INSERT INTO disaster_member_names (disaster_id, first_name, last_name, gender, date_of_birth, relationship) " .
						  "VALUES ('{$disaster_id}', '{$member[0]}', '{$member[1]}', '{$member[2]}', '{$member[3]}', '{$member[4]}')";
			mysql_query($insert_sql)
				or handle_error("An error occurred saving household member details", mysql_error());
		}

	} catch (Exception $exc) {
		handle_error("Something went wrong while attempting to save disaster.",
					 "Error saving disaster: " . $exc->getMessage());
	}

    // redirect on success
	header("Location: /admin/admin_donation.php");

	exit();
