<?php
	
	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$form_id = mysql_real_escape_string(trim($_REQUEST['form_id']));
	

	
	if ($form_id == 'submit_register_new_opp') {
		session_start();
		
		include_once '../securimage/securimage.php';
		$securimage = new Securimage();
		
		if ($securimage->check($_REQUEST['captcha_code']) == false) {
			// the code was incorrect
			// you should handle the error so that the form processor doesn't continue
			// or you can use the following code if there is no validation or you do not know how
			/*echo "The security code entered was incorrect.<br><br>";
			echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";*/
			header('Location: ../opportunity/captcha_error.html');
			exit();
		}
	}
	
	
	try {
		$agencyID = mysql_real_escape_string(trim($_REQUEST['agencyID']));
		$dateOfRequest = date_reformat(mysql_real_escape_string(trim($_REQUEST['dateOfRequest'])));
		$opportunity_title = mysql_real_escape_string(trim($_REQUEST['opportunity_title']));
		$opportunity_descr = mysql_real_escape_string(trim($_REQUEST['opportunity_descr']));
		$startDate = date_reformat(mysql_real_escape_string(trim($_REQUEST['startDate'])));
		$endDate = date_reformat(mysql_real_escape_string(trim($_REQUEST['endDate'])));
		$startTime = date('H:i', strtotime(mysql_real_escape_string(trim($_REQUEST['startTime']))));
		$endTime = date('H:i', strtotime(mysql_real_escape_string(trim($_REQUEST['endTime']))));
		$street_address1 = mysql_real_escape_string(trim($_REQUEST['street_address1']));
		$street_address2 = mysql_real_escape_string(trim($_REQUEST['street_address2']));
		$city = mysql_real_escape_string(trim($_REQUEST['city']));
		$state = mysql_real_escape_string(trim($_REQUEST['state']));
		$zip_code = mysql_real_escape_string(trim($_REQUEST['zip_code']));
		$directions = mysql_real_escape_string(trim($_REQUEST['directions']));
		$admin_review = 0;
		$open = 0;
				
		foreach($_REQUEST['checkbox'] as $cb) {
			if ($cb > 0) {
				$skill[] = $cb;
			}
		}
							 
		$insert_sql = sprintf("INSERT INTO opportunity (agy_id, opp_requestdate, opp_name, " .
											   		   "opp_description, opp_startdate, opp_enddate, " .
											   		   "opp_starttime, opp_endtime, opp_streetaddress1, " .
											   		   "opp_streetaddress2, opp_city, opp_state, " .
											   		   "opp_zipcode, opp_directions, admin_review, " .
											   		   "open) " .
							"VALUES ('%s', '%s', '%s', " .
									"'%s', '%s', '%s', " .
									"'%s', '%s', '%s', " .
									"'%s', '%s', '%s', " .
									"'%s', '%s', '%s', " .
									"'%s');",
							$agencyID, $dateOfRequest, $opportunity_title, 
							$opportunity_descr, $startDate, $endDate, 
							$startTime, $endTime, $street_address1, 
							$street_address2, $city, $state, 
							$zip_code, $directions, $admin_review,
							$open);
				  
		mysql_query($insert_sql)
			or handle_error("an error occurred while adding agency opportunity", mysql_error());

		$opp_id = mysql_insert_id();
		
		foreach ($skill as $sk) {
			$insert_sql = "INSERT INTO opp_skill (opp_id, skill_id) " .
						  "VALUES ('{$opp_id}', '{$sk}')";
			mysql_query($insert_sql)
				or handle_error("an error occurred while saving skills", mysql_error());
		}
		
	} catch (Exception $exc) {
		handle_error("something went wrong while attempting to save agency opportunity.",
					 "Error saving volunteer: " . $exc->getMessage());
	}
	
	if ($form_id == 'submit_agency_opp') {
			// Redirect to view opportunity info
			$msg = "The opportunity has been successfully added.";
			header("Location: ../opportunity/thankyou.html");
		}
		if ($form_id == 'submit_register_new_opp') {
			// Redirect to thank you page
			header("Location: ../opportunity/thankyou.html");
		}
	
	
	exit();
?>
