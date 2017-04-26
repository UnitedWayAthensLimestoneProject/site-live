<?php
	
	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['submitAdminOpp']);
	
	if ($processType == 'Update') {
	try {
		$opp_id = mysql_real_escape_string($_REQUEST['submit_opp_id']);
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
		$admin_review = 1;
		$open = $_REQUEST['opp_isopen'];
				
		foreach($_REQUEST['checkbox'] as $cb) {
			if ($cb > 0) {
				$skill[] = $cb;
			}
		}
							 
		$update_query = sprintf("UPDATE opportunity" .
								"   SET agy_id = '%s', " .
								"		opp_requestdate = '%s', " .
								"		opp_name = '%s', " .
								"		opp_description = '%s', " .
								"		opp_startdate = '%s', " .
								"		opp_enddate = '%s', " .
								"		opp_starttime = '%s', " .
								"		opp_endtime = '%s', " .
								"		opp_streetaddress1 = '%s', " .
								"		opp_streetaddress2 = '%s', " .
								"		opp_city = '%s', " .
								"		opp_state = '%s', " .
								"		opp_zipcode = '%s', " .
								"		opp_directions = '%s', " .
								"		open = '%s' " .
								" WHERE opp_id = '%s'",
								$agencyID, $dateOfRequest, $opportunity_title,
								$opportunity_descr, $startDate, $endDate,
								$startTime, $endTime, $street_address1,
								$street_address2, $city, $state,
								$zip_code, $directions, $open, $opp_id);
				  
		mysql_query($update_query)
			or handle_error("an error occurred while updating agency opportunity", mysql_error());
		
		$delete_query = "DELETE FROM opp_skill " .
						"	   WHERE opp_id = {$opp_id}";
		
		mysql_query($delete_query)
			or handle_error("an error occurred while deleting skills associated with the agency opportunity", mysql_error());
		
		foreach ($skill as $sk) {
			$insert_sql = "INSERT INTO opp_skill (opp_id, skill_id) " .
						  "VALUES ('{$opp_id}', '{$sk}')";
			mysql_query($insert_sql)
				or handle_error("an error occurred while saving skills", mysql_error());
		}
		
	} catch (Exception $exc) {
		handle_error("something went wrong while attempting to save agency opportunity.",
					 "Error saving opportunity: " . $exc->getMessage());
	}
	// Redirect to admin_opportunities.php
	$msg = "The Agency Opportunity has been successfully updated.";
	header("Location: ../admin_opportunities.php?success_message=" . $msg);
	} else if ($processType == 'Delete') {
		
		try {
			$opp_id = mysql_real_escape_string($_REQUEST['submit_opp_id']);
			
			$delete_skills_query = "DELETE FROM opp_skill " .
								   "	  WHERE opp_id = {$opp_id}";
			
			mysql_query($delete_skills_query)
				or handle_error("an error occurred while deleting skills associated with the opportunity", mysql_error());
				
			$delete_vol_query = "DELETE FROM opportunity " .
								"	   WHERE opp_id = {$opp_id}";
			
			mysql_query($delete_vol_query)
				or handle_error("an error occurred while deleting the opportunity", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete opportunity.",
						 "Error deleting opportunity: " . $exc->getMessage());
		}
		
		// Redirect to view opportunity info
		$msg = "The opportunity has been successfully deleted.";
		header("Location: ../admin_opportunities.php?success_message=" . $msg);
	}
	
	exit();
?>