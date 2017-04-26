<?php

	require_once 'database_connection.php';
	require_once 'functions.php';

	
	$form_id = mysql_real_escape_string(trim($_REQUEST['form_id']));
	
	
	
	
if ($form_id == 'submit_damage_form') {
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

		$insert_sql = sprintf("INSERT INTO damage " .
							  			 "(first_name, middle_initial, last_name, " .
							  			  "date_of_birth, email, home_phone, " .
							  			  "cell_phone, " .
							  			  "add_st1, add_st2, " .
							  			  "add_city, add_state, add_zip, " .
							  			  "health_limitation, health_limit_desc, " .
							  			  "dwelling, " .
							  			  "owner_renter_info, " .
							  			  "level_of_damage, ip_address) " .
							  "VALUES ('%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', '%s', " .
                                      "'%s', '%s', " .
                                      "'%s', '%s', '%s', '%s', '%s');",
                                    $first_name, $middle_initial, $last_name,
                                    $date_of_birth, $email, $home_phone,
                                    $cell_phone,
                                    $add_st1, $add_st2,
                                    $add_city, $add_state, $add_zip,
                                    $health_limitation, $health_limit_desc,
                                    $dwelling, $owner_renter_info,
                                    $leveL_of_damage, $_SERVER['REMOTE_ADDR']);

        mysql_query($insert_sql)
			or handle_error("An error occurred while reporting damage", mysql_error());

		$damage_id = mysql_insert_id();

		foreach ($members as $member) {
			$insert_sql = "INSERT INTO damage_member_names (damage_id, first_name, last_name, gender, date_of_birth, relationship) " .
						  "VALUES ('{$damage_id}', '{$member[0]}', '{$member[1]}', '{$member[2]}', '{$member[3]}', '{$member[4]}')";
			mysql_query($insert_sql)
				or handle_error("An error occurred saving household member details", mysql_error());
		}

	} catch (Exception $exc) {
		handle_error("Something went wrong while attempting to save damage.",
					 "Error saving damage: " . $exc->getMessage());
	}

	try {
	
		$sql = "SELECT DISTINCT email_id, " .
			   "email_display_name, " .
			   "email_address, " .
			   "email_action, " .
			   "email_action_description " .
			   "FROM email_forms a, email_action b " .
			   "WHERE (a.email_action_id=b.email_action_id) AND (b.email_action='new_damage') ";
			   "ORDER BY email_display_name";

		$result =  mysql_query($sql)
			or handle_error("An error occurred while reporting damage", mysql_error());

		$num_of_rows = mysql_num_rows($result);
				
	} catch (Exception $exc) {
		handle_error("Something went wrong while attempting to save damage.",
					 "Error saving damage: " . $exc->getMessage());
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

		$subject = "A Damage Form has been submitted by ".$first_name." ".$last_name;
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
	header("Location: /forms/damage_thankyou.php");

	exit();
?>
