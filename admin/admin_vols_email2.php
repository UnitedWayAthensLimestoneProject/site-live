<?php

	require_once 'scripts/authorize.php';
	require_once 'scripts/database_connection.php';
	require_once 'scripts/view.php';
	require_once 'scripts/functions.php';

	// Start session to enable user authorization and control.
	session_start();

	// set time-out period (in seconds)
	$inactive = 600;
 
	// check to see if $_SESSION["timeout"] is set
	if (isset($_SESSION["timeout"])) 
	{
		// calculate the session's "time to live"
		$sessionTTL = time() - $_SESSION["timeout"];
		if ($sessionTTL > $inactive) 
		{
			session_destroy();
			$msg = "Your session has timed out due to inactivity. Please log in again to continue.";
			header("Location: login.php?error_message=" . $msg);
			exit();
		}
	}
 
	$_SESSION["timeout"] = time();
	
	// Authorize users to access page. Function is found in authorize.php.
	// Current user groups are Administrators, Volunteers, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	authorize_user(array("Administrators"));

	if (isset($_POST['form_id'])) {
		
		$searchform = $_POST['form_id'];
		
		if ($searchform == 'submit_form_search_by_select') {
			$searchbyvols = 1;
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_volunteer ').hide();
		});
EOD;
		} 
	
	} else {
		
		$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_results ').hide();	
		
		});
EOD;
		
	}
		
		

$javascript .= "		
        ]
    });    
});";
	
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminVols",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);


?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Email Volunteers by Selection</h2>
				<p>Allows Administrators to select volunteers to generate email address list from.<br>(NOTE: Volunteers that have not been approved by admin review, will not be listed below.)</p>
			</div>	
			
			
		<form id="form_search_volunteer" class="appnitro" style="margin:25px 150px" method="POST"
			action="admin_vols_email2.php">
		
		<div class="form_description">
			<h2>Email Volunteer by Selection Form</h2>
		</div>
		<ul>
			<li>
				<label class="description" for="type_of_work">Type of work willing to volunteer for: 
					</label>
				<span class="left" style="width:200px">
					<input name="disaster" class="checkbox" type="checkbox" value="1" />
					<label class="choice" for="disaster">Disaster Relief</label>
				</span>
				<span class="left" style="width:200px">
					<input name="community" class="checkbox" type="checkbox" value="1" />
					<label class="choice" for="community">Community Service</label>
				</span>
				<span class="clear">
			</li>
			<li style="width:650px">
 				<span class="clear">
					<label class="description" for="dob_low">Date of Birth (from) - (YYYYMMDD)</label>
 					<input id="dob_low" name="dob_low" class="date" size="8" />
				</span>
				<span><label>&nbsp &nbsp &nbsp &nbsp &nbsp;</label>
				</span>
				<span>
					<label class="description" for="dob_high">Date of Birth (to) - (YYYYMMDD)</label>
 					<input id="dob_high" name="dob_high" class="date" size="8" />
				</span>
			</li>
			<li>
				<span class="clear">
					<input name="city" size="45" maxlength="30" type="text"
						 />
					<label for="city">City</label>
				</span>
				<span>
					<input name="state" size="2" maxlength="2" type="text"
						 />
					<label for="state">State</label>
				</span>
				<span>
					<input name="zip_code" size="24" maxlength="15" type="text"
						class="text" />
					<label for="zip_code">Postal &#47; Zip Code</label>
				</span>
			</li>
			<li>
				<label class="description" for="location">Willing to volunteer in: 
					</label>
				<span class="left" style="width:200px">
					<input name="limestone" class="checkbox" type="checkbox" value="1" />
					<label class="choice" for="limestone">Limestone County</label>
				</span>
				<span class="left" style="width:200px">
					<input name="neighbor" class="checkbox" type="checkbox" value="1" />
					<label class="choice" for="neighbor">Neighboring Counties</label>
				</span>
				<span class="left" style="width:200px">
					<input name="anywhere" class="checkbox" type="checkbox" value="1" />
					<label class="choice" for="anywhere">Anywhere in Alabama</label>
				</span>
			</li>
		</ul>
				<ul>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_search_by_select">
						<input type="submit" name="submitSearchBySelect" id="submitSearchBySelect" class="button_text" value="Search">
						<input type="reset" name="clearSearchBySelect" id="clearSearchBySelect" class="button_text" value="Cancel" onclick="window.location = window.location.pathname">
					</li>
				</ul>

		</form>	
			<form name="form_search_results" id="form_search_results" method="post" style="margin:25px 150px" action="admin_vols_email.php">
				<?php
					// Display Email Addresses for Volunteer Selection Results
					if ($searchbyvols == 1) {
						$searchbyvols = 0;

						$city = mysql_real_escape_string(trim($_REQUEST['city']));
						$disaster = mysql_real_escape_string(trim($_REQUEST['disaster']));
						$community = mysql_real_escape_string(trim($_REQUEST['community']));
						$limestone = mysql_real_escape_string($_REQUEST['limestone']);
						$neighbor = mysql_real_escape_string($_REQUEST['neighbor']);
						$anywhere = mysql_real_escape_string($_REQUEST['anywhere']);
						$state = mysql_real_escape_string(trim($_REQUEST['state']));
						$zip_code = mysql_real_escape_string(trim($_REQUEST['zip_code']));
						$dob_low = mysql_real_escape_string(trim($_REQUEST['dob_low']));
						$dob_high = mysql_real_escape_string(trim($_REQUEST['dob_high']));
						
						$where = "email_address != '            ' " .
								 "AND admin_review = 1 " .
								 "AND active = 1";
						$tempwhere = " ";
						
						if ($city != "") {
							$tempwhere = " ";
							$tempwhere = $where;							
							$where = $tempwhere .
									" AND city LIKE '$city%'";

						} 
						if ($community == 1) {
							$tempwhere = " ";
							$tempwhere = $where;							
							$where = $tempwhere .
									" AND community = 1";
						} 
						if ($disaster == 1) {
							$tempwhere = " ";
							$tempwhere = $where;							
							$where = $tempwhere .
									" AND disaster = 1"; 

						} 
						if ($location_anywhere == 1) {
							$tempwhere = " ";
							$tempwhere = $where;							
							$where = $tempwhere .
									" AND location_anywhere = 1";
						} 
						if ($location_limestone_county == 1) {
							$tempwhere = " ";
							$tempwhere = $where;							
							$where = $tempwhere .
									" AND location_limestone_county = 1";
						} 
						if ($location_neighbor_county == 1) {
							$tempwhere = " ";
							$tempwhere = $where;							
							$where = $tempwhere .
									" AND location_neighbor_county = 1";
						} 
						if ($state != "") {
							$tempwhere = " ";
							$tempwhere = $where;							
							$where = $tempwhere .
									" AND state = '$state'";
						} 
						if ($zip_code != "") {
							$tempwhere = " ";
							$tempwhere = $where;							
							$where = $tempwhere .
									" AND zip_code LIKE '$zip_code%'";
						} 
						if (($dob_low != "") && ($dob_high != "")) {
							$tempwhere = " ";
							$tempwhere = $where;							
							$where = $tempwhere .
									" AND date_of_birth BETWEEN '$dob_low' AND '$dob_high'";
//									" AND date_of_birth = '$dob_low'";
						} 

					
						try {
							$sql = "SELECT DISTINCT vol_id, " .
								   "				active, " .
								   "				city, " .
								   "				community, " .
								   "				disaster, " .
								   "				email_address, " .
								   "				location_anywhere, " .
								   "				location_limestone_county, " .
								   "				location_neighbor_county " .
								   "		   FROM volunteers " .
								   "		  WHERE " . $where .

								   "	   ORDER BY email_address";										  
							
											$result = mysql_query($sql)
														  or handle_error("an error occurred while searching for volunteers by skill", mysql_error());
								
										} catch (Exception $exc) {
											handle_error("something went wrong while attempting to search for volunteers by skill.",
												"Error searching for volunteers by skill: " . $exc->getMessage());
										}
										
										echo "				<center>";
										echo "				<hr />";
										echo "				<h2>Selection Results</h2>";
										echo "				<br />";
										while ($row = mysql_fetch_array($result))
										{

											echo "						<td>" . $row['email_address'] . "; </td>";

										}
										echo "				<br />";	
										echo "				</center>";
										echo "				<hr />";
										echo "				<ul>";
										echo "					<li class='buttons'>";
										echo "						<input type='reset' name='clearSearchResults' id='clearSearchResults' class='button_text' value='Clear' onclick='window.location = window.location.pathname'>";
										echo "					</li>";
										echo "				</ul>";
									}	
					?>
					
			</form>				
		</div>
		<div class="footer">
			Designed by Athens State University
		</div>
	</div>
	</div>
</body>
</html>
+