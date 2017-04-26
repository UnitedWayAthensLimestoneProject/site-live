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
		
		if ($searchform == 'submit_form_search_by_skills') {
			$searchbyskills = 1;
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #search_by_skills ').prop('checked', true);
			$(' #search_by_agency, #search_by_volunteer ').attr('disabled', true);
			$(' #form_search_by_skills, #form_search_for_agency_requests, #form_search_by_agency_requests, #form_search_by_agency, #form_search_for_volunteer, #form_search_by_volunteer, #form_view_volunteer_skills ').hide();
			$('#print_btn').click(function() {
					window.print();
				});
		});
EOD;
		} else if ($searchform == 'submit_form_search_by_agency') {
			$searchbyagency = 1;
			$agyid = $_POST['agencyID'];
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #search_by_agency ').prop('checked', true);
			$(' #search_by_skills, #search_by_volunteer ').attr('disabled', true);
			$(' #form_search_by_skills, #form_search_for_agency_requests, #form_search_by_agency, #form_search_for_volunteer, #form_search_by_volunteer, #form_view_volunteer_skills ').hide();
		
			$(' #form_search_by_agency_requests ').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #opptable ');
					} else {
						error.insertAfter(element);
					} 
				},
				messages: {
					opp_id: {
						required: "<br>Select a row to edit."
					}
				}
			});
		});
EOD;
		} else if ($searchform == 'submit_form_search_by_agency_requests') {
			$searchbyopp = 1;
			$oppid = $_POST['opp_id'];
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #search_by_agency ').prop('checked', true);
			$(' #search_by_skills, #search_by_volunteer ').attr('disabled', true);
			$(' #form_search_by_skills, #form_search_for_agency_requests, #form_search_by_agency, #form_search_for_volunteer, #form_search_by_volunteer, #form_view_volunteer_skills, #form_search_results ').hide();
			$(' #form_skiils_by_opportunity ').show();
			$('#print_btn').click(function() {
				window.print();
			});
	
		});
EOD;
		} else if ($searchform == 'submit_form_search_for_volunteer') {
			$searchforvol = 1;
			$searchfirstname = mysql_real_escape_string(trim($_POST['searchfirstname']));
			$searchlastname = mysql_real_escape_string(trim($_POST['searchlastname']));
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #search_by_volunteer ').prop('checked', true);
			$(' #search_by_skills, #search_by_agency ').attr('disabled', true);
			$(' #form_search_by_skills, #form_search_for_agency_requests, #form_search_by_agency_requests, #form_search_by_agency, #form_skiils_by_opportunity, #form_search_for_volunteer, #form_view_volunteer_skills, #form_search_results ').hide();
			$(' #form_search_by_volunteer ').show();
			
			$('#form_search_by_volunteer').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #voltable ');
					} else {
						error.insertAfter(element);
					}
				},
				messages: {
					vol_id: {
						required: "<br>Select a row to edit."
					}
				}
			});
		});
EOD;
		} else if ($searchform == 'submit_form_search_by_volunteer') {
			$searchbyvol = 1;
			$searchvolid = $_POST['vol_id'];
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #search_by_volunteer ').prop('checked', true);
			$(' #search_by_skills, #search_by_agency ').attr('disabled', true);
			$(' #form_search_by_skills, #form_search_for_agency_requests, #form_search_by_agency_requests, #form_search_by_agency, #form_skiils_by_opportunity, #form_search_for_volunteer, #form_search_by_volunteer, #form_search_results ').hide();
			$(' #form_view_volunteer_skills ').show();
			
			$('#print_btn').click(function() {
				window.print();
			});
		});
EOD;
			
		}

	} else {
		
		$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_by_skills, #form_search_for_agency_requests, #form_search_by_agency_requests, #form_search_by_agency, #form_search_for_volunteer, #form_search_by_volunteer, #form_view_volunteer_skills, #form_search_results ').hide();
		
			$(' #search_by_skills ').click(function() {
				$(' #form_search_for_agency_requests, #form_search_by_agency, #form_search_for_volunteer, #form_search_by_volunteer ').hide();
				$(' #agencyID ').val('');
				$(' #form_search_by_skills ').show();
			});
		
			$(' #search_by_agency ').click(function() {
				$(' #form_search_by_skills, #form_search_for_agency_requests, #form_search_for_volunteer, #form_search_by_volunteer ').hide();
				$(' input[type=checkbox] ').attr('checked', false);
				$(' #form_search_for_agency_requests ').show();
			});
		
			$(' #search_by_volunteer ').click(function() 
			{
				$(' #form_search_by_skills, #form_search_for_agency_requests, #form_search_by_agency, #form_search_for_volunteer ').hide();
				$(' input[type=checkbox] ').attr('checked', false);
				$(' #agencyID ').val('');
				$(' #form_search_for_volunteer ').show();
				$(' #searchfirstname ').focus();
				
				$('#form_search_for_volunteer').submit(function()
				{
					if( $('#searchfirstname').val() == "" && $('#searchlastname').val() == "")
					{
						$('#buttons').prepend('<label class="error">You must fill in at least one name! <br>&nbsp;</label>');
						return false;
					}
					else
					{
						return true;
					}
				});
			});
		
			$('#form_search_by_skills').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #skillstable ');
					} else {
						error.insertAfter(element);
					} 
				}
			});
		
			$(' #form_search_for_agency_requests ').validate();
		
		});
EOD;
		
	}
		
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "searchAll",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);
	
?>

		<div id="form_container">
			<div id="search_by_radio_buttons" align="center" style="margin-top:25px">
				<label class="skills_search_by">Search Skills : </label>
				<input type="radio" name="search_by" id="search_by_skills" value="search_by_skills" title="Search by Skills List">
				<label class="skills_search_form" style="text-align:left"> by Skills List</label><br>
				<label class="skills_search_by">&nbsp;</label>
				<input type="radio" name="search_by" id="search_by_agency" value="search_by_agency" title="Search by Agency Opportunity">
				<label class="skills_search_form" style="text-align:left"> by Agency Opportunity</label><br>
				<label class="skills_search_by">&nbsp;</label>
				<input type="radio" name="search_by" id="search_by_volunteer" value="search_by_volunteer" title="Search by Volunteer">
				<label class="skills_search_form" style="text-align:left"> by Volunteer</label>
			</div>
			
			<form name="form_search_by_skills" id="form_search_by_skills" method="post" class="appnitro" style="margin:25px 10px" action="skills_search.php">
				<ul><li class="section_break"></li></ul>
				<center>
					<table id="skillstable" align="center">
						<tr valign="top">
							<td>
								<ul>
									<?php list_skills(); ?>
										</span>
									</li>
								</ul>
							</td>
						</tr>
					</table>
				</center>
				<ul>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_search_by_skills">
						<input type="submit" name="submitSearchBySkills" id="submitSearchBySkills" class="button_text" value="Search">
						<input type="reset" name="clearSearchBySkills" id="clearSearchBySkills" class="button_text" value="Cancel" onclick="window.location = window.location.pathname">
					</li>
				</ul>
			</form>
			
			<form name="form_search_results" id="form_search_results" method="post" style="margin:25px 10px" action="skills_search.php">
				<?php
					if ($searchbyskills == 1) {
						$searchbyskills = 0;
						$list = "";
						foreach($_REQUEST['checkbox'] as $cb) {
							if ($cb > 0) {
								$skill[] = $cb;
								$list .= "$cb, ";
							}
						}
						$skills = rtrim($list, ", ");
		
						try {
							$insert_sql = "SELECT DISTINCT v.vol_id, " .
										  "				   v.first_name, " .
										  "				   v.last_name, " .
										  "				   v.email_address, " .
										  "				   v.home_phone, " .
										  "				   v.cell_phone, " .
										  "				   s.skill_name " .
										  "			  FROM volunteers v " .
										  "	    INNER JOIN vol_skill vs " .
										  "			    ON vs.skill_id IN ($skills) " .
										  "			   AND vs.vol_id = v.vol_id " .
										  "	    INNER JOIN skill s " .
										  "			    ON s.skill_id = vs.skill_id " .
										  "			 WHERE v.active = 1 " .
										  "			   AND v.admin_review = 1 " .
										  "		  ORDER BY v.last_name, " .
										  "				   v.first_name;";
	  		
							$result = mysql_query($insert_sql)
									  	  or handle_error("an error occurred while searching for volunteers by skill", mysql_error());
				
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for volunteers by skill.",
								"Error searching for volunteers by skill: " . $exc->getMessage());
						}
						
						echo "				<center>";
						echo "				<table class='search_results'>";
						//echo "					<th width='10px' border=1 style='border: 1px solid #000; background:#CCC'></th>";
						echo "					<th>First Name</th>";
						echo "					<th>Last Name</th>";
						echo "					<th>Email</th>";
						echo "					<th>Home Phone</th>";
						echo "					<th>Cell Phone</th>";
						echo "					<th>Skill</th>";

						while ($row = mysql_fetch_array($result))
						{
							echo "					<tr>";
							//echo "						<td border=1 style='border: 1px solid #000'><input type='radio' name='vol_id' id='vol_id' class='required' value='" . $row['vol_id'] . "'</td>";
							echo "						<td>" . $row['first_name'] . "</td>";
							echo "						<td>" . $row['last_name'] . "</td>";
							echo "						<td>" . $row['email_address'] . "</td>";
							echo "						<td>" . $row['home_phone'] . "</td>";
							echo "						<td>" . $row['cell_phone'] . "</td>";
							echo "						<td>" . $row['skill_name'] . "</td>";
							echo "					</tr>";
						}
						echo "				</table>";
						echo "				</center>";
						echo "				<ul>";
						echo "					<li class='buttons'>";
						echo "						<input type='button' class='button_text' id='print_btn' value='Print'>";
				    	echo "						<input type='reset' name='clearSearchResults' id='clearSearchResults' class='button_text' value='Clear' onclick='window.location = window.location.pathname'>";
						echo "					</li>";
						echo "				</ul>";
					}	
				?>
					
			</form>
			
			<center>
			<form name="form_search_for_agency_requests" id="form_search_for_agency_requests" method="post" style="margin:25px 10px" action="skills_search.php">
				<ul><li class="section_break"></li></ul>
				<div align="center">
					<?php
			 			$sql = ("SELECT agy_id, agy_name " .
			 						    "  FROM agency " .
			 						    " WHERE active = 1 " .
			 						    "ORDER BY agy_name");
			 			
			 			$result = mysql_query($sql)
			 				or die ("Unable to make populate the agency list: " . mysql_error());
			 			
			 			echo "<br>";
			 			echo "<select autofocus name='agencyID' id='agencyID' class='required' style='width:200px'>";
			 			echo "<option value=''>Select an agency</option>";
			 			while ($row = mysql_fetch_array($result)) {
				 			echo "<option value='" . $row['agy_id'] . "'>" . $row['agy_name'] . "</option>";
				 		}
				 		echo "</select>";
				 	?>
				</div>
				<div>
		 			<p><br></p>
		 		</div>
				<ul>
		 			<li class="buttons">
				    	<input type="hidden" name="form_id" value="submit_form_search_by_agency">
						<input type="submit" name="submitAgencySearch" id="submitAgencySearch" class="button_text" value="View Opportunities">
						<input type="reset" name="clearAgencySearch" id="clearAgencySearch" class="button_text" value=" Cancel " onclick="window.location = window.location.pathname">
		 			</li>
				</ul>
			</form>
			</center>
			
			<form name="form_search_by_agency_requests" id="form_search_by_agency_requests" method="post" style="margin:25px 10px" action="skills_search.php">
				<ul><li class="section_break"></li></ul>
				<?php
					if ($searchbyagency == 1) {
						$searchbyagency = 0;
						
						$sql1 = ("SELECT agy_name " .
								 "  FROM agency " .
								 " WHERE agy_id = $agyid " .
								 "   AND active = 1");
								 
						$result1 = mysql_query($sql1)
							or die("Unable to find the agency name: " . mysql_error());
							
						$agyname = mysql_fetch_array($result1);
							
						$sql2 = ("SELECT o.opp_id, " .
								 "		 a.agy_name, " .
								 "		 o.opp_name, " .
								 "		 o.opp_description " .
								 "  FROM opportunity o " .
								 "INNER JOIN agency a " .
								 "    ON a.agy_id = o.agy_id " .
								 " WHERE o.agy_id = $agyid " .
								 "   AND o.admin_review = 1 " .
								 "   AND o.open = 1");
								
						$result2 = mysql_query($sql2)
			 				or die ("Unable to make the agency opportunity table: " . mysql_error());
			 				
			 			$num_of_rows = mysql_num_rows($result2);
						
						echo "				<h2 align='center'>" . $agyname['agy_name'] . "</h2>";
						echo "				<center>";
						echo "				<table class='search_results' id='opptable'>";
						echo "					<th width='5px' style='min-width:5px'></th>";
						echo "					<th width='200px'>Opportunity Name</th>";
						echo "					<th width='500px'>Description</th>";
						
						while ($row = mysql_fetch_array($result2))
						{
							echo "					<tr>";
							echo "						<td><input type='radio' name='opp_id' id='opp_id' class='required' value='" . $row['opp_id'] . "'</td>";
							echo "						<td>" . $row['opp_name'] . "</td>";
							echo "						<td>" . $row['opp_description'] . "</td>";
							echo "					</tr>";
						}
						echo "				</table>";
						echo "				</center>";
						
						if ($num_of_rows == 0) {
							echo "				<br><h3 align='center' style='color:#FF0000'>Currently there are no open opportunities for " . $agyname['agy_name'] . ".</h3><br>";
							$disabled = "disabled";
						} else {
							$disabled = "";
						}
						
						echo "				<ul>";
						echo "					<li class='buttons'>";
						echo "						<input type='hidden' name='form_id' value='submit_form_search_by_agency_requests'>";
						echo "						<input type='submit' name='submitSearchByAgencyRequests' id='submitSearchByAgencyRequests' class='button_text' value='View Vols' " . $disabled . ">";
				    	echo "						<input type='reset' name='clearSearchByAgencyRequests' id='clearSearchByAgencyRequests' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>";
						echo "					</li>";
						echo "				</ul>";
					}
				?>
			</form>
			
			<form name="form_skiils_by_opportunity" id="form_skiils_by_opportunity" method="post" style="margin:25px 10px" action="skills_search.php">
				<?php
					if ($searchbyopp == 1) {
						$searchbyopp = 0;
						
						$sql1 = ("SELECT skill_id " .
								"  FROM opp_skill " .
								" WHERE opp_id = $oppid " .
								"ORDER BY skill_id");
								
						$result1 = mysql_query($sql1);
						
						$list = "";
						while($skill = mysql_fetch_array($result1)) {
							$list .= $skill[0] . ", ";
						}
						$skills = rtrim($list, ", ");
						
						try {
							$sql2 = "SELECT DISTINCT v.vol_id, " .
									"				 v.first_name, " .
									"				 v.last_name, " .
									"				 v.email_address, " .
									"				 v.home_phone, " .
									"				 v.cell_phone, " .
									"				 s.skill_name " .
									"			FROM volunteers v " .
									"	  INNER JOIN vol_skill vs " .
									"			  ON vs.skill_id IN ($skills) " .
									"			 AND vs.vol_id = v.vol_id " .
									"	  INNER JOIN skill s " .
									"			  ON s.skill_id = vs.skill_id " .
									"		   WHERE v.active = 1 " .
									"			 AND v.admin_review = 1 " .
									"		ORDER BY v.last_name, " .
									"	 		     v.first_name";
	  		
							$result = mysql_query($sql2)
								or handle_error("an error occurred while searching for volunteers by agency opportunity", mysql_error());
				
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for volunteers by agency opportunity.",
								"Error searching for volunteers by agency opportunity: " . $exc->getMessage());
						}
						
						echo "				<center>";
						echo "				<table class='search_results' width='90%'>";
						//echo "					<th width='10px' border=1 style='border: 1px solid #000; background:#CCC'></th>";
						echo "					<th>First Name</th>";
						echo "					<th>Last Name</th>";
						echo "					<th>Email</th>";
						echo "					<th>Home Phone</th>";
						echo "					<th>Cell Phone</th>";
						echo "					<th>Skill</th>";

						while ($row = mysql_fetch_array($result))
						{
							echo "					<tr>";
							//echo "						<td border=1 style='border: 1px solid #000'><input type='radio' name='vol_id' id='vol_id' class='required' value='" . $row['vol_id'] . "'</td>";
							echo "						<td>" . $row['first_name'] . "</td>";
							echo "						<td>" . $row['last_name'] . "</td>";
							echo "						<td>" . $row['email_address'] . "</td>";
							echo "						<td>" . $row['home_phone'] . "</td>";
							echo "						<td>" . $row['cell_phone'] . "</td>";
							echo "						<td>" . $row['skill_name'] . "</td>";
							echo "					</tr>";
						}
						echo "				</table>";
						echo "				</center>";
						echo "				<ul>";
						echo "					<li class='buttons'>";
						echo "						<input type='button' class='button_text' id='print_btn' value='Print'>";
				    	echo "						<input type='reset' name='clearSearchResults' id='clearSearchResults' class='button_text' value='Clear' onclick='window.location = window.location.pathname'>";
						echo "					</li>";
						echo "				</ul>";
					}	
				?>
					
			</form>

			<center>
			<form name="form_search_for_volunteer" id="form_search_for_volunteer" method="post" style="margin:25px 10px" 
				action="skills_search.php">
				<ul><li class="section_break"></li></ul>
				<h3 align="center"><br>Enter at least three letters of the volunteer's first name, last name, or both.<br>&nbsp;</h3>
				<label for="searchfirstname">First Name : </label>
				<input type="text" name="searchfirstname" id="searchfirstname" class="name">
				<label for="searchlastname" style="margin-left:10px"> Last Name : </label>
				<input type="text" name="searchlastname" id="searchlastname" class="name">
				<ul>
					<li class="buttons" id="buttons">
						<input type="hidden" name="form_id" value="submit_form_search_for_volunteer">
						<input type="submit" name="submitSearchForVolunteer" id="submitSearchForVolunteer" class="button_text" value="Find Volunteer">
						<input type="reset" name="clearSearchForVolunteer" id="clearSearchForVolunteer" class="button_text" value="Cancel" onclick="window.location = window.location.pathname">
					</li>
				</ul>
			</form>
			</center>
			
			<form name="form_search_by_volunteer" id="form_search_by_volunteer" method="post" style="margin:25px 10px" 
				action="skills_search.php">
				<ul><li class="section_break"></li></ul>
				<?php
					if ($searchforvol == 1) {
						$searchforvol = 0;
						
						if ($searchfirstname != "" && $searchlastname != "") {
							$where = "first_name LIKE '$searchfirstname%' " .
									 "AND last_name LIKE '$searchlastname%' ";
						} else if ($searchfirstname != "") {
							$where = "first_name LIKE '$searchfirstname%' ";
						} else {
							$where = "last_name LIKE '$searchlastname%' ";
						}
						
						try {
							$sql = "SELECT DISTINCT vol_id, " .
								   "				first_name, " .
								   "				last_name, " .
								   "				email_address, " .
								   "				home_phone, " .
								   "				cell_phone " .
								   "		   FROM volunteers " .
								   "		  WHERE " . $where .
								   "			AND active = 1 " .
								   "			AND admin_review = 1 " .
								   "	   ORDER BY first_name, " .
								   "	 		    last_name";
						
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for volunteers", mysql_error());
			 				
							$num_of_rows = mysql_num_rows($result);
				
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for volunteers.",
								"Error searching for volunteers: " . $exc->getMessage());
						}
						
						echo "				<center>";
						echo "				<table class='search_results' id='voltable' width='90%'>";
						echo "					<th width='5px' style='min-width:5px'></th>";
						echo "					<th>First Name</th>";
						echo "					<th>Last Name</th>";
						echo "					<th>Email</th>";
						echo "					<th>Home Phone</th>";
						echo "					<th>Cell Phone</th>";

						while ($row = mysql_fetch_array($result))
						{
							echo "					<tr>";
							echo "						<td><input type='radio' name='vol_id' id='vol_id' class='required' value='" . $row['vol_id'] . "'</td>";
							echo "						<td>" . $row['first_name'] . "</td>";
							echo "						<td>" . $row['last_name'] . "</td>";
							echo "						<td>" . $row['email_address'] . "</td>";
							echo "						<td>" . $row['home_phone'] . "</td>";
							echo "						<td>" . $row['cell_phone'] . "</td>";
							echo "					</tr>";
						}
						echo "				</table>";
						echo "				</center>";
						
						if ($num_of_rows == 0) {
							echo "				<br><h3 align='center' style='color:#FF0000'>There are no Volunteers matching your search request.</h3><br>";
							$disabled = "disabled";
						} else {
							$disabled = "";
						}
						
						echo "				<ul>";
						echo "					<li class='buttons'>";
						echo "						<input type='hidden' name='form_id' value='submit_form_search_by_volunteer'>";
						echo "						<input type='submit' name='submitSearchByVolunteer' id='submitSearchByVolunteer' class='button_text' value='View Skills' " . $disabled . ">";
				    	echo "						<input type='reset' name='clearSearchByVolunteer' id='clearSearchByVolunteer' class='button_text' value='Clear' onclick='window.location = window.location.pathname'>";
						echo "					</li>";
						echo "				</ul>";
					}	
				?>
			</form>
			
			<center>
			<form name="form_view_volunteer_skills" id="form_view_volunteer_skills" method="post" style="margin:25px 10px" 
				action="skills_search.php">
				<ul><li class="section_break"></li></ul>
				<?php
					if ($searchbyvol == 1) {
						$searchbyvol = 0;
					
						try {
							$sql1 = "SELECT first_name, " .
									"		middle_initial, " .
								    "		last_name, " .
								    "		email_address, " .
								    "		home_phone, " .
								    "		cell_phone " .
								    "  FROM volunteers " .
								    " WHERE vol_id = $searchvolid";
						
							$result1 = mysql_query($sql1)
								or handle_error("an error occurred while searching for volunteer", mysql_error());
								
						} catch (Exception $exc) {
							handle_error("something went wrong while searching for volunteer.",
								"Error searching for volunteer: " . $exc->getMessage());
						}
						
						$vol = mysql_fetch_array($result1);
						
						if (isset($vol['middle_initial'])) {
							$volname = $vol['first_name'] . " " . $vol['middle_initial'] . " " . $vol['last_name'];
						} else {
							$volname = $vol['first_name'] . " " . $vol['last_name'];
						}
						
						echo "<label class='label_right'>Volunteer : &nbsp;</label>";
						echo "<label class='label_left'>" . $volname . "</label><br>\n";
						echo "<label class='label_right'>Home Phone : &nbsp;</label>";
						echo "<label class='label_left'>" . $vol['home_phone'] . "</label><br>\n";
						echo "<label class='label_right'>Cell Phone : &nbsp;</label>";
						echo "<label class='label_left'>" . $vol['cell_phone'] . "</label><br>\n";
						echo "<label class='label_right'>Email Address : &nbsp;</label>";
						echo "<label class='label_left'>" . $vol['email_address'] . "</label><br>";
									
						echo "<p>&nbsp;<br>&nbsp;</p>";
						
						try {
							$sql2 = "	 SELECT s.skill_name " .
									"	   FROM vol_skill v " .
									"INNER JOIN skill s " .
									"        ON s.skill_id = v.skill_id " .
									"     WHERE v.vol_id = $searchvolid " .
									"  ORDER BY s.skill_name";
						
							$result2 = mysql_query($sql2)
								or handle_error("an error occurred while searching for volunteer's skills", mysql_error());
								
							$num_of_rows = mysql_num_rows($result2);
							
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for volunteer's skills.",
								"Error searching for volunteer's skills: " . $exc->getMessage());
						}
						
						if ($num_of_rows > 0) {
							$rowsincol = $num_of_rows / 3;
							$rowcnt = 0;
							echo "			<table align='center' class='skilltable'>";
							echo "				<caption><h2>Volunteer's Skills</h2></caption>";
							echo "				<tr>";
							echo "					<td>";
							while ($volskills = mysql_fetch_array($result2)) {
								if ($rowcnt <= $rowsincol) {
									echo "					" . $volskills[0] . "<br>\n";
									$rowcnt++;
								} else {
									echo "					</td>";
									echo "					<td>" . $volskills[0] . "</br>\n";
									$rowcnt = 1;
								}
							}
							echo "					</td>";
							echo "				</tr>";
							echo "			</table>";
						} else {
							echo "				<br><h3 align='center'>No skills found for this volunteer.</h3>\n";
						}
						
						echo "				<ul>";
						echo "					<li class='buttons'>";
						echo "						<input type='button' class='button_text' id='print_btn' value='Print'>";
				    	echo "						<input type='reset' name='clearVolunteerSkillResults' id='clearVolunteerSkillResults' class='button_text' value='Clear' onclick='window.location = window.location.pathname'>";
						echo "					</li>";
						echo "				</ul>";
						
					}
				?>		
			</form>
			</center>
			
		</div>
		<div class="footer">
			Designed by Athens State University
		</div>
	</div>
	</div>
</body>
</html>