<?php

	require_once 'database_connection.php';
	require_once 'functions.php';	
	
	$form_id = mysql_real_escape_string(trim($_REQUEST['form_id']));
	
	if ($form_id == 'submit_register_group') {
			$admin_review = 1;
			$active = 1;
	}
	
	if ($form_id == 'submit_register_new_group') {
		session_start();
		include_once '../securimage/securimage.php';
		$securimage = new Securimage();
		
		if ($securimage->check($_REQUEST['captcha_code']) == false) {
			// the code was incorrect
			// you should handle the error so that the form processor doesn't continue
			// or you can use the following code if there is no validation or you do not know how
			//echo "The security code entered was incorrect.<br><br>";
			//echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
			header('Location: ../captcha_error.html');
			exit();

				}
		
		$admin_review = 0;
		$active = 0;
	}
	
	try {
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
		
		foreach($_REQUEST['checkbox'] as $cb) {
			if ($cb > 0) {
				$skill[] = $cb;
			}
		}
	
		$insert_sql = sprintf("INSERT INTO grp_t " .
							  			 "(group_name, contact, " .
							  			  "date_of_birth, email_address, phone_num, " .
							  			  "cell_phone, street_address, " .
							  			  "city, state, zip_code, " .
							  			  "health_limits, " .
							  			  "health_limits_comment, affiliated, affiliated_comment, " .
							  			  "location_limestone_county, location_neighbor_county, location_anywhere, " .
							  			  "emer_con_first_name, emer_con_last_name, emer_con_email, " .
							  			  "emer_con_phone, special_skills, special_skills_comment, " .
							  			  "admin_review, active) " .
							  "VALUES ('%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', " .
							  		  "'%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s');",
							  $group_name, $contact,
							  $dob, $email, $phone_num, 
							  $cell_phone, $street_address, 
							  $city, $state, $zip_code, 
							  $health_limits,
							  $health_limits_comment, $affiliated, $affiliated_comment,
							  $limestone, $neighbor, $anywhere,
							  $emer_first_name, $emer_last_name, $emer_email,
							  $emer_phone, $special_skills, $special_skills_comment,
							  $admin_review, $active);
				  
		mysql_query($insert_sql)
			or handle_error("an error occurred while adding group", mysql_error());

		$grp_id = mysql_insert_id();
		
		foreach ($skill as $sk) {
			$insert_sql = "INSERT INTO group_skill (grp_id, skill_id) " .
						  "VALUES ('{$grp_id}', '{$sk}')";
			mysql_query($insert_sql)
				or handle_error("an error occurred while saving skills", mysql_error());
		}

	} catch (Exception $exc) {
		handle_error("something went wrong while attempting to save group.",
					 "Error saving group: " . $exc->getMessage());
	}
	
	if ($form_id == 'submit_register_group') {
			// Redirect to view group info
			$msg = "The group has been successfully added.";
			header("Location: ../register_group.php?success_message=" . $msg);
		}
		if ($form_id == 'submit_register_new_group') {
			// Redirect to thank you page
			
		$from = "thankyou@unitedwayathenslimestone.com"; //the email address you want it from (the address does not have to exist to work)
		$headers = "From: $from \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8 \r\n";
		$subject = "United Way of Athens-Limestone Thanks You!";
		$message = '<div align="center"><a href="http://www.unitedwayathenslimestone.com"><img src="http://www.unitedwayathenslimestone.com/images/uwbanner.jpg" 
		alt="www.unitedwayathelimestone.com" width="600" height="180" style="border: none;" class="img" /></a></div>';		
		$message .= "<br><hr><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$first_name $last_name,<br><br>";
		$message .= '<br><div align="center">Thank you for your interest in registering you group with United Way of Athens-Limestone County.</div>';
 		$message .= '<div align="center"><p>Once your application is processed, we will contact you to set up a meeting.</div>';
		$message .= '<div align="center"><br>However, if you have any questions or concerns feel free to contact 
		             <br><b>Anna Beth Thomason at 256-233-2323</b>. Thank you!</p><br><br><br></div><hr>';
		$message .= '<div align="center"><small>This is a transactional email and is sent from an automated address - please do not reply to this message.</small></div><br>';	    
		$message .= '<div align="center"><a href="https://www.facebook.com/pages/United-Way-Athens-Limestone/131401963542374?ref=ts" 
		             target="_blank"><img src="http://www.unitedwayathenslimestone.com/images/facebook.jpg" alt="Facebook" width="50" style="border: none;" class="img" /></a>	
			     <a href="https://twitter.com/UWlimestone" target="_blank"><img src="http://www.unitedwayathenslimestone.com/images/twitter.gif"
			      alt="Twitter" width="50" style="border: none;" class="img" /></a></div>';
     
		mail($email, $subject, $message, $headers);

			header("Location: ../thankyou.html");
		}
	
	exit();
?>
