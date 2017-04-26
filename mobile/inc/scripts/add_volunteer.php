<?php

	require_once 'database_connection.php';
	require_once 'script_functions.php';
	
	$form_id = mysql_real_escape_string(trim($_POST['record']['form_id']));
	
	if ($form_id == 'submit_register_volunteer') {
			$admin_review = 1;
			$active = 1;
	}
	
	if ($form_id == 'submit_register_new_volunteer') {
		session_start();
		
		$admin_review = 0;
		$active = 0;
	}
	
	try {
		$first_name = mysql_real_escape_string(trim($_POST['record']['first_name']));
		$middle_initial = mysql_real_escape_string(trim($_POST['record']['middle_initial']));
		$last_name = mysql_real_escape_string(trim($_POST['record']['last_name']));
		$dob = date_reformat(mysql_real_escape_string(trim($_POST['record']['dob'])));
		$email = mysql_real_escape_string(trim($_POST['record']['email']));
		$home_phone = mysql_real_escape_string(trim($_POST['record']['home_phone']));
		$cell_phone = mysql_real_escape_string(trim($_POST['record']['cell_phone']));
		$street_address1 = mysql_real_escape_string(trim($_POST['record']['street_address1']));
		$street_address2 = mysql_real_escape_string(trim($_POST['record']['street_address2']));
		$city = mysql_real_escape_string(trim($_POST['record']['city']));
		$state = mysql_real_escape_string(trim($_POST['record']['state']));
		$zip_code = mysql_real_escape_string(trim($_POST['record']['zip_code']));
		$occupation = mysql_real_escape_string(trim($_POST['record']['occupation']));
		$employer = mysql_real_escape_string(trim($_POST['record']['employer']));
		$health_limits = mysql_real_escape_string($_POST['record']['health_limits']);
		$health_limits_comment = mysql_real_escape_string(trim($_POST['record']['health_limits_comment']));
		$affiliated = mysql_real_escape_string($_POST['record']['affiliated']);
		$affiliated_comment = mysql_real_escape_string(trim($_POST['record']['affiliated_comment']));
		$limestone = mysql_real_escape_string($_POST['record']['limestone']);
		$neighbor = mysql_real_escape_string($_POST['record']['neighbor']);
		$anywhere = mysql_real_escape_string($_POST['record']['anywhere']);
		$emer_first_name = mysql_real_escape_string(trim($_POST['record']['emer_first_name']));
		$emer_last_name = mysql_real_escape_string(trim($_POST['record']['emer_last_name']));
		$emer_relationship = mysql_real_escape_string(trim($_POST['record']['emer_relationship']));
		$emer_phone = mysql_real_escape_string(trim($_POST['record']['emer_phone']));
		$special_skills = mysql_real_escape_string($_POST['record']['special_skills']);
		$special_skills_comment = mysql_real_escape_string(trim($_POST['record']['special_skills_comment']));
				
		$query=("SELECT * " .
				"  FROM skill " .
				" WHERE enabled = 1 " .
				"   AND skill_group IS NOT NULL " .
				"ORDER BY skill_group, skill_name");
	
		$result=mysql_query($query)
			or die ("Unable to make the query: " . mysql_error());
	
		while ($row=mysql_fetch_array($result)) {
			$group = @$row["skill_group"];
			$s_id = @$row["skill_id"];
			$s_name = @$row["skill_name"];
			if ($_POST['record']['skill_'.$s_id] > 0) {
				$skill[] = $s_id;
			}
		}
		
		$insert_sql = sprintf("INSERT INTO volunteers " .
							  			 "(first_name, middle_initial, last_name, " .
							  			  "date_of_birth, email_address, home_phone, " .
							  			  "cell_phone, street_address1, street_address2, " .
							  			  "city, state, zip_code, " .
							  			  "occupation, employer, health_limits, " .
							  			  "health_limits_comment, affiliated, affiliated_comment, " .
							  			  "location_limestone_county, location_neighbor_county, location_anywhere, " .
							  			  "emer_con_first_name, emer_con_last_name, emer_con_relationship, " .
							  			  "emer_con_phone, special_skills, special_skills_comment, " .
							  			  "admin_review, active) " .
							  "VALUES ('%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s', '%s', " .
							  		  "'%s', '%s');",
							  $first_name, $middle_initial, $last_name,
							  $dob, $email, $home_phone, 
							  $cell_phone, $street_address1, $street_address2,
							  $city, $state, $zip_code, 
							  $occupation, $employer, $health_limits,
							  $health_limits_comment, $affiliated, $affiliated_comment,
							  $limestone, $neighbor, $anywhere,
							  $emer_first_name, $emer_last_name, $emer_relationship,
							  $emer_phone, $special_skills, $special_skills_comment,
							  $admin_review, $active);
				  
		mysql_query($insert_sql)
			or handle_error2("an error occurred while adding volunteer", mysql_error());

		$vol_id = mysql_insert_id();
		
		foreach ($skill as $sk) {
			$insert_sql = "INSERT INTO vol_skill (vol_id, skill_id) " .
						  "VALUES ('{$vol_id}', '{$sk}')";
			mysql_query($insert_sql)
				or handle_error2("an error occurred while saving skills", mysql_error());
		}
		
		

	} catch (Exception $exc) {
		handle_error2("something went wrong while attempting to save volunteer.",
					 "Error saving volunteer: " . $exc->getMessage());
	}
	
	if ($form_id == 'submit_register_volunteer') {
			// Redirect to view volunteer info
			$msg = "The volunteer has been successfully added.";
			header("Location: /mobile/index.php");
		}
		if ($form_id == 'submit_register_new_volunteer') {
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
		$message .= '<br><div align="center">Thank you for your interest in volunteering with United Way of Athens-Limestone County.</div>';
 		$message .= '<div align="center"><p>Once your application is processed, we will contact you to set up a meeting.</div>';
		$message .= '<div align="center"><br>However, if you have any questions or concerns feel free to contact 
		             <br><b>Anna Beth Thomason at 256-233-2323</b>. Thank you!</p><br><br><br></div><hr>';
		$message .= '<div align="center"><small>This is a transactional email and is sent from an automated address - please do not reply to this message.</small></div><br>';	    
		$message .= '<div align="center"><a href="https://www.facebook.com/pages/United-Way-Athens-Limestone/131401963542374?ref=ts" 
		             target="_blank"><img src="http://www.unitedwayathenslimestone.com/images/facebook.jpg" alt="Facebook" width="50" style="border: none;" class="img" /></a>	
			     <a href="https://twitter.com/UWlimestone" target="_blank"><img src="http://www.unitedwayathenslimestone.com/images/twitter.gif"
			      alt="Twitter" width="50" style="border: none;" class="img" /></a></div>';
     
		mail($email, $subject, $message, $headers);
		
		
	try {
	
		$sql = "SELECT DISTINCT email_id, " .
			   "email_display_name, " .
			   "email_address, " .
			   "email_action, " .
			   "email_action_description " .
			   "FROM email_forms a, email_action b " .
			   "WHERE (a.email_action_id=b.email_action_id) AND (b.email_action='new_volunteer') ";
			   "ORDER BY email_display_name";

		$result =  mysql_query($sql)
			or handle_error2("An error occurred while reporting volunteer", mysql_error());

		$num_of_rows = mysql_num_rows($result);
				
	} catch (Exception $exc) {
		handle_error2("Something went wrong while attempting to save volunteer.",
					 "Error saving volunteer: " . $exc->getMessage());
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

		$subject = "A Volunteer Form has been submitted by ".$first_name." ".$last_name;
		$message = "<table border=1 cellpadding=10>".
					"<tr><td>EMAIL:</td><td>".$email."</td></tr>" . 
					"<tr><td>HOME PHONE:</td><td>".$home_phone."</td></tr>" . 
					"<tr><td>CELL PHONE:</td><td>".$cell_phone."</td></tr>" . 
					"</table>";
		
		if(!mail($to,$subject,$message,$headers,"-f".$from_address))
		{
			//handle_error2("Failed to send email.<br>".$to."<br>".$headers."<br>".$subject."<br>".$message."<br><br>");
		};

	}

			header("Location: /mobile/index.php");
		}
	
	exit();
?>
