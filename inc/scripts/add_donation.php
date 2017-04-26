<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	
	$form_id = mysql_real_escape_string(trim($_REQUEST['form_id']));
	
	
	
	
if ($form_id == 'submit_donation_relief') {
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
		
		$admin_review = 0;
		$active = 0;
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
			or handle_error("An error occurred while reporting donation", mysql_error());


	} catch (Exception $exc) {
		handle_error("Something went wrong while attempting to save donation.",
					 "Error saving donation: " . $exc->getMessage());
	}
	
	try {
	
		$sql = "SELECT DISTINCT email_id, " .
			   "email_display_name, " .
			   "email_address, " .
			   "email_action, " .
			   "email_action_description " .
			   "FROM email_forms a, email_action b " .
			   "WHERE (a.email_action_id=b.email_action_id) AND (b.email_action='new_donation') ";
			   "ORDER BY email_display_name";

		$result =  mysql_query($sql)
			or handle_error("An error occurred while reporting donation", mysql_error());

		$num_of_rows = mysql_num_rows($result);
				
	} catch (Exception $exc) {
		handle_error("Something went wrong while attempting to save donation.",
					 "Error saving donation: " . $exc->getMessage());
	}

	if($num_of_rows > 0)
	{
		$to = "";
		while ($row = mysql_fetch_array($result))
		{
			$to .= $row['email_display_name']."<".$row['email_address'].">, ";
		}
		$to = substr($to,0,-2);
	
		$from_name = EMAIL_SENDER_NAME;
		$from_address = EMAIL_SENDER_ADDRESS;
		$from = $from_name."<".$from_address.">";
		$headers = 'From: '. $from . "\r\n" .
					'Reply-To: '. $from . "\r\n" .
					'X-Mailer: PHP/' . phpversion(). "\r\n" .
					"Content-Type: text/html; charset=iso-8859-1". "\r\n" .
					"Content-Transfer-Encoding: 8bit". "\r\n". "\r\n";

		$subject = "A Donation Form has been submitted by ".$first_name." ".$last_name;
		$message = "<table border=1 cellpadding=10><tr><td>DESCRIPTION:</td><td>".$item_desc."</td></tr><tr><td>"."CONDITION:</td><td>".$item_condition." - ".$used_item_condition."</td></tr></table>";
		
		if(!mail($to,$subject,$message,$headers,"-f".$from_address))
		{
			handle_error("Failed to send email.<br>".$to."<br>".$headers."<br>".$subject."<br>".$message."<br><br>");
		};

	}

    // redirect on success
	header("Location: /forms/donation_thankyou.php");

	exit();
