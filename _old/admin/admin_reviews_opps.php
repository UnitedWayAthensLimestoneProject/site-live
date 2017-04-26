<?php 
	
	require_once 'scripts/authorize.php';
	require_once 'scripts/database_connection.php';
	require_once 'scripts/view.php';
	require_once 'scripts/functions.php';
	
	// request error message, null if not.
	$error_message = $_REQUEST['error_message'];

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
	authorize_user(array("Administrators", "Agencies"));
	
	// Add any page specific javascript here.
	if (isset($_POST['form_id'])) {
		
		$searchform = $_POST['form_id'];
		
		if ($searchform == 'submit_form_list_opportunities') {
			$searchforopp = 1;
			$searchoppid = $_POST['opp_id'];
	$javascript = <<<EOD
	$(document).ready(function() {
	
		$(' #form_list_opportunities ').hide();
		$(' #form_process_opportunities ').show();
		
		$( 'input#active, input#inactive' ).button();
			$( 'div#activeinactive' ).buttonset();
			
		if ($( '#active' ).attr('checked') == 'checked') {
				$( '#active' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
				$( '#inactive' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
			} else {
				$( '#active' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
				$( '#inactive' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
			};
			
		$( '#active' ).click(function() {
				$( '#active' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
				$( '#inactive' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
			});
		
			$( '#inactive' ).click(function() {
				$( '#active' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
				$( '#inactive' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
			});
		
		$( '#form_process_opportunities' ).submit(function() 
		{
			return true;
		});
		
		$('#form_process_opportunities').validate( {
				errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.appendTo( '#skilllabel' );
		        } else {
		          error.insertAfter(element);
		        } 
		    }
				});
		
		$(function() {
			$(' #startTime ').timepicker({ 'timeFormat' : 'h:i A' })
			$(' #endTime ').timepicker({ 'timeFormat' : 'h:i A' })
		});
	});
	
	$(function() {
		$( "input#dateOfRequest" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "c-1:c+1",
			onClose: function( selectedDate ) {
				$( "#dateOfRequest" ).focus();
			}
		});		
		$( "#startDate" ).datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
				$( "#endDate" ).datepicker( "option", "minDate", selectedDate );
				$( "#endDate" ).focus();
			}
	    });
		$( "#endDate" ).datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
		        $( "#startDate" ).datepicker( "option", "maxDate", selectedDate );
		        $( "#startHour" ).focus();
			}
	    });
	    

	});
EOD;

		}
	} else {
	
		$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_process_opportunities ').hide();
			$(' #form_list_opportunities ').show();
		
			$('#form_list_opportunities').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #editopptable ');
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
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminReviewOpps",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);
			   
	admin_menu();
?>

		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Admin Review of New Opportunity Registrations</h2>
				<p>Gives Administrators the ability to approve/disapprove agency opportunities.
				<br>(NOTE: Only opportunities requiring review will appear here.)
				</p>
			</div>
			

			<form name="form_list_opportunities" id="form_list_opportunities" method="post" style="margin:25px 10px" 
				action="admin_reviews_opps.php">
				<?php
					
					try {
						$count_sql = "SELECT opp_id " .
									 "  FROM opportunity " .
									 " WHERE admin_review = 0";
									 
						$count_result = mysql_query($count_sql)
							or handle_error("an error occurred while searching for opportunities requiring an admin review", mysql_error());
						
						$count_records = mysql_num_rows($count_result);
						
					} catch (Exception $exc) {
						handle_error("something went wrong while attempting to search for opportunities that require an admin review.",
							"Error searching for opportunities that require an admin review: " . $exc->getMessage());
					}
					
					if ($count_records > 0) {
						
						$disabled = "";
						
						try {
							$sql = "SELECT 			 o.opp_id, " .
									"				o.agy_id, " .
									"				a.agy_name, " .
								   "				o.opp_name, " .
								   "				o.opp_description, " .
								   "				o.opp_startdate, " .
								   "				o.opp_enddate " .
								   "		   FROM opportunity o, " .
								   "		 	 	agency a " .
								   "			WHERE (a.agy_id = o.agy_id) " .
								   "		  AND o.admin_review = 0 " .
								   "	   ORDER BY agy_id, " .
								   "	 		    opp_name";
						
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for opportunities", mysql_error());
				
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for opportunities.",
								"Error searching for opportunities: " . $exc->getMessage());
						}
						
						echo "				<center>";
						echo "				<table class='editopptable' id='editopptable' width='90%'>";
						echo "					<th style='width:4px'></th>";
						echo "					<th>Agency Name</th>";
						echo "					<th>Opportunity Name</th>";
						echo "					<th>Description</th>";
						echo "					<th>Start Date</th>";
						echo "					<th>End Date</th>";

						while ($row = mysql_fetch_array($result))
						{
							echo "					<tr>";
							echo "						<td style='width:4px'><input type='radio' name='opp_id' id='opp_id' class='required' value='" . $row['opp_id'] . "'</td>";
							echo "						<td><center>" . $row['agy_name'] . "</center></td>";
							echo "						<td><center>" . $row['opp_name'] . "</center></td>";
							echo "						<td><center>" . $row['opp_description'] . "</center></td>";
							echo "						<td><center>" . date_format(date_create($row['opp_startdate']),'m/d/Y') . "</center></td>";
							echo "						<td><center>" . date_format(date_create($row['opp_enddate']),'m/d/Y') . "</center></td>";
							echo "					</tr>";
						}
						echo "				</table>";
						echo "				</center>";
						
						echo "				<ul>";
						echo "					<li class='buttons'>";
						echo "						<input type='hidden' name='form_id' value='submit_form_list_opportunities'>";
						echo "						<input type='submit' name='submitListOpportunities' id='submitListOpportunities' class='button_text' value='View Opportunity Info' " . $disabled . ">";
						echo "					</li>";
						echo "				</ul>";
					
					} else {
						echo "				<br><h3 align='center' style='color:#FF0000'>There are no Opportunities requiring an admin review.</h3><br>";
						$disabled = "disabled";
					}	
				?>
			</form>
	
			<form id="form_process_opportunities" class="appnitro" method="post" action="scripts/process_admin_opps_reviews.php">
				<?php
					if ($searchforopp == 1) {
						$searchforopp = 0;
					
						$opp_query = "SELECT * " .
								 	"  FROM opportunity o, " .
									"	agency a " .
									" WHERE (a.agy_id = o.agy_id) " .
								 	" AND o.opp_id = " . $searchoppid;
								 
						$opp_data = mysql_query($opp_query)
						 	or handle_error("an error occurred while searching for opportunities", mysql_error());
						
					 	$opp_row = mysql_fetch_array($opp_data);
					 	
					 	try {
							$oppskill_sql = "	 SELECT skill_id " .
											"	   FROM opp_skill " .
											"     WHERE opp_id = $searchoppid " .
											"  ORDER BY skill_id";
						
							$oppskill_result = mysql_query($oppskill_sql)
								or handle_error("an error occurred while searching for skills associated with the opportunity", mysql_error());
								
							$num_of_rows = mysql_num_rows($oppskill_result);
							
							$list = "";
							while($skill = mysql_fetch_array($oppskill_result)) {
								$list .= $skill[0] . ",";
							}
							$skills = rtrim($list, ",");
							$oppskill = explode(',', $skills);
							
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for skills associated with the opportunity.",
								"Error searching for skills associated with the opportunity: " . $exc->getMessage());
						}
					 }
				?>						
				<ul>
		 			<li>
		 				<span>
		 					<label class="description" for="agencyName">Agency </label>
				 			<input id="agency_text" name="agency_text" type="text" class="text" size="50" value="<?php echo $opp_row['agy_name']; ?>" />
							<label class="description" for="agencyID"> Agency ID: </label>
							<input id="agencyID" name="agencyID" type="text" class="text" size="10" value="<?php echo $opp_row['agy_id']; ?>" />
						</span>
						<span>
						<span style="margin-left:15px">
							<label class="description" for="dateOfRequest">Request Date</label>
							<input id="dateOfRequest" name="dateOfRequest" class="text required" size="15" style="text-align:center" value=<?php echo date_format(date_create($opp_row['opp_requestdate']),'m/d/Y'); ?> />
						</span>
		 			</li>
					<li class="section_break">
						<p></p>
					</li>
					<li>
						<span>
							<label class="description" for="assignment_title">Title of Opportunity </label>
							<input name="opportunity_title" id="opportunity_title" class="text required" type="text" value="<?php echo $opp_row['opp_name']; ?>"
								size="60" maxlength="255" /> 
						</span>
					</li>
					<li>
						<span>	
							<label class="description" for="assignment_descr">Opportunity Description </label>
							<textarea name="opportunity_descr" class="text" type="text" rows="4" cols="69" maxlength="250" /><?php echo $opp_row['opp_description']; ?></textarea> 
						</span>
					</li>
					<li>
						<div>
							<label class="description" for="startDate">Opportunity Date Range</label>
							<span>
								<input id="startDate" name="startDate" class="text required" size="11" value="<?php echo date_format(date_create($opp_row['opp_startdate']),'m/d/Y'); ?>" />
								<label for="startDate">From</label>
							</span>
							<span style="margin-left:10px">
								<input id="endDate" name="endDate" class="text required" size="11" value="<?php echo date_format(date_create($opp_row['opp_enddate']),'m/d/Y'); ?>" />
								<label for="endDate">To</label>
							</span>
						</div>
					</li>
					<li>
						<div>
							<span>
								<label class="description" for="startTime">Start Time </label>
								<input type="text" name="startTime" id="startTime" class="text" size="11" value="<?php echo $opp_row['opp_starttime']; ?>">
							</span>
							<span style="margin-left:10px">
								<label class="description" for="endTime">End Time </label>
								<input type="text" name="endTime" id="endTime" class="text" size="11" value="<?php echo $opp_row['opp_endtime']; ?>">
							</span>
						</div>
					</li>
					<li class="section_break">
						<h3>Jobsite:</h3>
						<p>&nbsp;</p>
					</li>
				</ul>
				<center>
					<table align="center">
						<tr valign="top">
							<td>
								<ul>
									<li>
										<span>
											<label class="description" for="address">Address</label>
											<input name="street_address1" size="60" maxlength="30" type="text"
												class="text" value="<?php echo $opp_row['opp_streetaddress1']; ?>" />
											<label for="street_address1">Street Address (line 1)</label>
										</span>
										<span class="clear">
											<input name="street_address2" size="60" maxlength="30" type="text"
												class="text" value="<?php echo $opp_row['opp_streetaddress2']; ?>" />
											<label for="street_address2">Street Address (line 2)</label>
										</span>
										<span class="clear">
											<input name="city" size="40" maxlength="30" type="text"
												class="text" value="<?php echo $opp_row['opp_city']; ?>" />
											<label for="city">City</label>
										</span>
										<span>
											<input name="state" size="3" maxlength="2" type="text" 
												class="center_text" value="<?php echo $opp_row['opp_state']; ?>" />
											<label for="state">State</label>
										</span>
										<span>
											<input name="zip_code" size="15" maxlength="15" type="text"
												class="text" value="<?php echo $opp_row['opp_zipcode']; ?>" />
											<label for="zip_code">Postal / Zip Code</label>
										</span>
									</li>
									<li>
										<label class="description" for="directions">Directions to Job Site </label>
										<div>
											<textarea id="directions" name="directions" class="text" 
												rows="4" cols="70" maxlength="250"><?php echo $opp_row['opp_directions']; ?></textarea> 
										</div> 
									</li>
								</ul>
							</td>
						</tr>
					</table>
				</center>
				
				<ul>	
					<li class="section_break break_before" style="font-size:14px">
						<h3>Skills Needed for Assignment:</h3>
						<h3 id="skilllabel" align="center">&nbsp;</h3>
						<p>&nbsp;</p>
					</li>
				</ul>
				<center>
					<table align="center">
						<tr valign="top">
							<td>
								<ul>
									<?php populate_skills($oppskill); ?>
										</span>
									</li>
								</ul>
							</td>
						</tr>
					</table>
				</center>

				<div>
		 			<p><br></p>
		 		</div>
				<div id="activeinactive" align="center">
					<input type="radio" name="active_inactive" id="active" value="1" title="&nbsp;Active&nbsp;" <?php if($opp_row['open'] == 1) {echo 'checked';} ?>>
						<label for="active">&nbsp;Active&nbsp;</label></input>
					<input type="radio" name="active_inactive" id="inactive" value="0" title="Inactive" <?php if($opp_row['open'] == 0) {echo 'checked';} ?>>
						<label for="inactive">Inactive</label></input>
				</div>
				<ul>
					<li class="section_break"></li>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_process_opportunities">
						<input type="hidden" name="submit_opp_id" value="<?php echo $opp_row['opp_id']; ?>">
						<input type="submit" name="submitProcessOpp" id="submitApproveOpp" class="button_text" value="Approve">
						<input type="submit" name="submitProcessOpp" id="submitDeleteOpp" class="button_text" value="Delete">
						<input type='reset' name='clearProcessOpportunity' id='clearProcessOpportunity' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
					</li>
				</ul>
			</form>	
		</div>
		<div class="footer">
			Designed by Athens State University
		</div>
	</body>
</html>