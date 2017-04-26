<?php

	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$form_id = mysql_real_escape_string(trim($_REQUEST['form_id']));

//error_reporting(E_ALL);	
	
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
			header('Location: /inc/securimage/captcha_error.html');
			exit();
		}
		
		$admin_review = 0;
		$active = 0;

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

        // get the household member details
        $members = array();
		foreach($_REQUEST['hhmem_firstname'] as $k => $v)
		{
            if(strlen($v) > 0)
            {
                $members[$k] = array($_REQUEST['hhmem_firstname'][$k],
                                    $_REQUEST['hhmem_lastname'][$k],
                                    $_REQUEST['hhmem_gender'][$k],
                                    $_REQUEST['hhmem_dob'][$k],
                                    $_REQUEST['hhmem_relation'][$k]);
            }
		}

		$insert_sql = sprintf("INSERT INTO disaster " .
							  			 "(first_name, middle_initial, last_name, " .
							  			  "date_of_birth, email, home_phone, " .
							  			  "cell_phone, have_interview," .
							  			  "interview_date, event_date," .
							  			  "pre_add_st1, pre_add_st2, " .
							  			  "pre_add_city, pre_add_state, pre_add_zip, " .
							  			  "post_add_st1, post_add_st2, " .
							  			  "post_add_city, post_add_state, post_add_zip, " .
							  			  "health_limitation, health_limit_desc, " .
							  			  "annual_income, dwelling, " .
							  			  "owner_renter_info, landlord_first_name, landlord_last_name, " .
							  			  "monthly_rent, monthly_utilities, dwelling_use, " .
							  			  "dwelling_insurance_contents, dwelling_insurance_hazzard, dwelling_insurance_structure, " .
							  			  "insurance_provider_name, insurance_provider_phone, " .
							  			  "level_of_damage, electricity_on, housing_need, housing_need_type, ip_address) " .
							  "VALUES ('%s', '%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', '%s', '%s', '%s');",
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
                                    $leveL_of_damage, $electricity_on, $housing_need, $housing_need_type, $_SERVER['REMOTE_ADDR']);
									

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

}


	try {
	
		$sql = "SELECT DISTINCT email_id, " .
			   "email_display_name, " .
			   "email_address, " .
			   "email_action, " .
			   "email_action_description " .
			   "FROM email_forms a, email_action b " .
			   "WHERE (a.email_action_id=b.email_action_id) AND (b.email_action='new_disaster') ";
			   "ORDER BY email_display_name";

		$result =  mysql_query($sql)
			or handle_error("An error occurred while reporting disaster", mysql_error());

		$num_of_rows = mysql_num_rows($result);
				
	} catch (Exception $exc) {
		handle_error("Something went wrong while attempting to save disaster.",
					 "Error saving disaster: " . $exc->getMessage());
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

		$subject = "A Disaster Form has been submitted by ".$first_name." ".$last_name;
		$message = "<table border=1 cellpadding=10>".
					"<tr><td>EMAIL:</td><td>".$email."</td></tr>" . 
					"<tr><td>HOME PHONE:</td><td>".$home_phone."</td></tr>" . 
					"<tr><td>CELL PHONE:</td><td>".$cell_phone."</td></tr>" . 
					"<tr><td>DAMAGE LEVEL:</td><td>".$leveL_of_damage."</td></tr>" . 
					"</table>";
		
		if(!mail($to,$subject,$message,$headers,"-f".$from_address))
		{
			handle_error("Failed to send email.<br>".$to."<br>".$headers."<br>".$subject."<br>".$message."<br><br>");
		};

	}
    // redirect on success
	header("Location: /forms/disaster_thankyou.php");

	exit();
