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
			$(' #search_by_volunteer ').attr('disabled', true);
			$(' #form_search_by_skills ').hide();
		});
EOD;
		} 
		// 
		if ($searchform == 'submit_form_search_by_vols') {
			$searchbyvols = 1;
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #search_by_vols ').prop('checked', true);
			$(' #search_by_skills ').attr('disabled', true);
			$(' #form_search_by_skills ').hide();
		});
EOD;
		} 
	} else {
		
		$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_by_skills, #form_view_volunteer_skills, #form_search_results ').hide();
		
			$(' #search_by_skills ').click(function() {
				$(' #form_search_for_volunteer, #form_search_by_volunteer ').hide();
				$(' #agencyID ').val('');
				$(' #form_search_by_skills ').show();
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
				<label class="skills_search_form" style="text-align:left"> by Skills List - Volunteer</label><br>
				<label class="skills_search_by">&nbsp;</label>
			</div>
			
			<form name="form_search_by_skills" id="form_search_by_skills" method="post" class="appnitro" style="margin:25px 10px" action="admin_vols_email1.php">
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
			
			
			<form name="form_search_results" id="form_search_results" method="post" style="margin:25px 150px" action="admin_vols_email1.php">
				<?php
					// Display Email Addresses for Skills Selection Results
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
										  "				   s.skill_name, " .
										  "                                v.reg_date " .
										  "			  FROM volunteers v " .
										  "	    INNER JOIN vol_skill vs " .
										  "			    ON vs.skill_id IN ($skills) " .
										  "			   AND vs.vol_id = v.vol_id " .
										  "	    INNER JOIN skill s " .
										  "			    ON s.skill_id = vs.skill_id " .
										  "			 WHERE v.active = 1 " .
										  "			   AND v.admin_review = 1 " .
										  "			   AND v.email_address != '            ' " .
										  "		  ORDER BY v.reg_date DESC, " .
										  "                                v.last_name, " .
										  "				   v.first_name; ";
										  
										  
	  		
							$result = mysql_query($insert_sql)
									  	  or handle_error("an error occurred while searching for volunteers by skill", mysql_error());
				
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for volunteers by skill.",
								"Error searching for volunteers by skill: " . $exc->getMessage());
						}
						
						echo "				<center>";
						while ($row = mysql_fetch_array($result))
						{

							echo "						<td>" . $row['email_address'] . "; </td>";

						}
						echo "				</center>";
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