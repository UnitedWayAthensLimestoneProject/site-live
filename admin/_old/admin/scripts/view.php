<?php

	require_once 'authorize.php';
	require_once 'database_connection.php';

	define("SUCCESS_MESSAGE", "success");
	define("ERROR_MESSAGE", "error");

	// Start session to enable user control
	session_start();

	// Displays the html code for <html> through the menu
	function page_start($title, $javascript = NULL, $bodyId = NULL,
						$success_message = NULL, $error_message = NULL) {
		
		$count_records = 0;
		$count_opp_records = 0;
		$count_grp_records = 0;
		$count_sql = "SELECT vol_id " .
					 "  FROM volunteers " .
					 " WHERE admin_review = 0";
					 
		$count_opp_sql = "SELECT opp_id " .
						" FROM opportunity " .
						" WHERE admin_review = 0";
		
		$count_grp_sql = "SELECT grp_id " .
						" FROM grp_t " .
						" WHERE admin_review = 0";
						
		$count_result = mysql_query($count_sql)
			or handle_error("an error occurred while searching for volunteers requiring an admin review", mysql_error());
		
		$count_opp_result = mysql_query($count_opp_sql)
			or handle_error("an error occurred while searching for opportunities requiring an admin review", mysql_error());
			
		$count_grp_result = mysql_query($count_grp_sql)
			or handle_error("an error occurred while searching for volunteers requiring an admin review", mysql_error());
		
		$count_records = mysql_num_rows($count_result);
			
		$count_opp_records = mysql_num_rows($count_opp_result);
		
		$count_grp_records = mysql_num_rows($count_grp_result);
		
		$count = $count_records + $count_opp_records + $count_grp_records;
		
		display_head($title, $javascript, $count);
		display_body($bodyId, $title, $success_message, $error_message, $count_records, $count_opp_records, $count_grp_records);
	}

	// Displays the html code for <html> through </head>
	function display_head($page_title = "", $embedded_javascript = NULL, $count) {
		echo <<<EOD
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{$page_title}</title>
	<link rel="shortcut icon" href="images/uw_icon.ico" type="image/ico">
	<link rel="stylesheet" type="text/css" href="css/uw.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/print.css" media="print">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui/ui-darkness/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" type="text/css" href="js/jquery.timepicker.css">
	<link rel="stylesheet" type="text/css" href="css/badger.css">
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="js/jquery.timepicker.js"></script>
	<script type="text/javascript" src="js/badger.js"></script>\n
EOD;
		if (!is_null($embedded_javascript)) {
			echo "    <script type='text/javascript'>\n" .
				 $embedded_javascript .
				 "\n</script>\n" .
				 "<script>\n" .
				 "    $(document).ready(function() {\n" .
				 "        $('#MyBadge').badger('$count');\n" .
				 "    });\n" .
				 "</script>\n";
		}
		echo "</head>\n";
	}

	// Displays the html code for the start of body through the Menus
	function display_body($bodyId = NULL, $title, $success_message = NULL, $error_message = NULL, $count_records, $count_opp_records, $count_grp_records) {
		echo <<<EOD
<body id='{$bodyId}'>
	<div id="wrapper">
EOD;
		if (isset($_SESSION['user_id'])) {
			echo <<<EOD
		<div class="logout"><input type="button" value="Logout"
			onClick="parent.location='logout.php'"></div>
EOD;
		}
		echo <<<EOD
		<div class="banner"><img src="images/uwbanner.jpg" alt="United Way Banner" width="100%" /></div>
		<div class="PrintOnly"><img src="images/uwbanner_print.jpg" /></div>
		<div id="menu" align="center">
			<ul id="mainNav" class="center">
EOD;
		if (isset($_SESSION['user_id'])) {
			if (user_in_group($_SESSION['user_id'], "Administrators")) {
				echo "<li><a href='register_volunteer.php' id='addVolLink'>Add Volunteer</a></li>\n";
				echo "<li><a href='register_group.php' id='addGroupLink'>Add Group</a></li>\n";
				echo "<li><a href='skills_search.php' id='searchAllLink'>Skills Search</a></li>\n";
				echo "<li><a href='agency_opp.php' id='agencyOppLink'>Agency Opportunity</a></li>\n";
				if ($count_records >= 1 || $count_opp_records >= 1 || $count_grp_records >= 1) {
					echo "<li style='position:relative;border:0;padding:0px;' id='MyBadge'><a href='admin.php' id='adminLink'>Admin</a></li>\n";
				} else {
					echo "<li><a href='admin.php' id='adminLink'>Admin</a></li>\n";
				}
			} elseif (user_in_group($_SESSION['user_id'], "Volunteers")) {
				echo "<li><a href='register_volunteer.php' id='addVolLink'>Add Volunteer</a></li>\n";
			} elseif (user_in_group($_SESSION['user_id'], "Agencies")) {
				echo "<li><a href='agency_opp.php' id='agencyOppLink'>Agency Opportunity</a></li>\n";
			} else {
				echo "<li><a href='login.php'>Log In</a></li>";
			}
		}
		echo <<<EOD
    		</ul>
  		</div>
EOD;

		display_messages($success_message, $error_message);
		echo "		<p>&nbsp;</p>\n";
		echo "		<p>&nbsp;</p>\n";
	}

	function display_messages($success_msg = NULL, $error_msg = NULL) {
		echo "		<div id='messages'>\n";
		if (!is_null($success_msg) && (strlen($success_msg) > 0)) {
			display_message($success_msg, SUCCESS_MESSAGE);
		}
		if (!is_null($error_msg) && (strlen($error_msg) > 0)) {
			display_message($error_msg, ERROR_MESSAGE);
		}
		echo "		</div>\n\n";
	}

	function display_message($msg, $msg_type) {
		echo "			<div id='{$msg_type}' class='{$msg_type}'>\n";
		echo "				<p>{$msg}</p>\n";
		echo "			</div>\n";
	}

	function admin_menu() {
		
		$count_records = 0;
		$count_sql = "SELECT vol_id " .
					 "  FROM volunteers " .
					 " WHERE admin_review = 0";
		
		$count_result = mysql_query($count_sql)
			or handle_error("an error occurred while searching for volunteers requiring an admin review", mysql_error());
						
		$count_records = mysql_num_rows($count_result);
		
		if ($count_records > 0) {
			$adminReviewsLinkFormat = 'adminReviewsYesLink';
		} else {
			$adminReviewsLinkFormat = 'adminReviewsNoLink';
		}
		
		$count_grp_records = 0;
		$count_grp_sql = "SELECT grp_id " .
					 "  FROM grp_t " .
					 " WHERE admin_review = 0";
		
		$count_grp_result = mysql_query($count_grp_sql)
			or handle_error("an error occurred while searching for volunteers requiring an admin review", mysql_error());
						
		$count_grp_records = mysql_num_rows($count_grp_result);
		
		if ($count_grp_records > 0) {
			$adminReviewGroupsLinkFormat = 'adminReviewGroupsYesLink';
		} else {
			$adminReviewGroupsLinkFormat = 'adminReviewGroupsNoLink';
		}
		
		$count_opp_records = 0;
		$count_opp_sql = "SELECT opp_id " .
					 "  FROM opportunity " .
					 " WHERE admin_review = 0";
					 
		$count_opp_result = mysql_query($count_opp_sql)
			or handle_error("an error occurred while searching for opportunities requiring an admin review", mysql_error());
			
		$count_opp_records = mysql_num_rows($count_opp_result);
		
		if ($count_opp_records > 0) {
			$adminReviewOppsLinkFormat = 'adminReviewOppsYesLink';
		} else {
			$adminReviewOppsLinkFormat = 'adminReviewOppsNoLink';
		}
		
		echo <<<EOD
	<p>&nbsp;</p>
	<div id="adminWrapper">
		<div id="adminMenuSidebar">
			<ul id="adminNav">
				<li><a href="admin_agencies.php" id="adminAgenciesLink">Agencies</a></li>
				<li><a href="admin_opportunities.php" id="adminOpportunitiesLink">Opportunities</a></li>
				<li><a href="admin_skills.php" id="adminSkillsLink">Skills</a></li>
				<li><a href="admin_users.php" id="adminUsersLink">Users</a></li>
				<li><a href="admin_vols.php" id="adminVolsLink">Volunteers</a></li>
				<li><a href="admin_groups.php" id="adminGroupsLink">Groups</a></li>
				<li><a href="admin_reviews.php" id="{$adminReviewsLinkFormat}">New Volunteers</a></li>
				<li><a href="admin_reviews_groups.php" id="{$adminReviewGroupsLinkFormat}">New Group</a></li>
				<li><a href="admin_reviews_opps.php" id="{$adminReviewOppsLinkFormat}">New Opps</a></li>
			</ul>
		</div>
EOD;
	}
?>