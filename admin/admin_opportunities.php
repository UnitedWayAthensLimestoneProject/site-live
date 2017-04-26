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
		
		if ($searchform == 'submit_form_search_for_agency_requests') {
			$searchbyagency = 1;
			$agyid = $_POST['agencyID'];
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_agency_requests, #form_edit_agency_opp ').hide();
		
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
	
			$(' #form_search_for_agency_requests, #form_search_by_agency_requests ').hide();
			
			$( 'input#opp_open, input#opp_closed' ).button();
			$( 'div#open_closed' ).buttonset();
		
			if ($( '#opp_open' ).attr('checked') == 'checked') {
				$( '#opp_open' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
				$( '#opp_closed' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
			} else {
				$( '#opp_open' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
				$( '#opp_closed' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
			};
		
			$( '#opp_open' ).click(function() {
				$( '#opp_open' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
				$( '#opp_closed' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
			});
		
			$( '#opp_closed' ).click(function() {
				$( '#opp_open' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
				$( '#opp_closed' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
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
	
			$(' #form_search_by_agency_requests, #form_edit_agency_opp ').hide();
		
			$(' #form_search_for_agency_requests ').validate();
		
		});
EOD;
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminOpportunities",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);
			   
	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Agency Opportunities Administration</h2>
				<p>Gives Administrators the ability to edit agency opportunities.
				<br>(NOTE: Opportunities that have not been approved by admin review, will not be listed below.)
				<br>(Also: If opportunity is listed from an inactive agency, you MUST
				<br>reactivate the agency before you can reactivate the opportunity.)</br>
				</p>
			</div>
			
			<center>
			<form name="form_search_for_agency_requests" id="form_search_for_agency_requests" method="post" style="margin:10px" action="admin_opportunities.php">
				<div align="center">
					<?php
			 			$sql = ("SELECT agy_id, agy_name " .
			 						    "  FROM agency " .
										" WHERE active = 1 " .
			 						    "ORDER BY agy_name");
			 			
			 			$result = mysql_query($sql)
			 				or die ("Unable to make populate the agency list: " . mysql_error());
			 			
			 			echo "<select autofocus name='agencyID' id='agencyID' style='width:200px'>";
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

				<?php
				//This section being added to add options to the search criteria
				//Do you want to search for all types of opps? only active? only inactive?
				?>
				<div>
					<input type="radio" name="searchOppsOption" id="searchAllOpps" value ="all" checked="checked" <?php print $all_opp_status; ?> />All Opportunities
					<input type="radio" name="searchOppsOption" id="searchOpenOpps" value="open" <?php print $open_opp_status; ?> />Open Opportunities
					<input type="radio" name="searchOppsOption" id="searchClosedOpps" value="closed" <?php print $closed_opp_status; ?> />Closed Opportunities
				
				</div>
				
				<ul>
		 			<li class="buttons">
				    	<input type="hidden" name="form_id" value="submit_form_search_for_agency_requests">
						<input type="submit" name="submitAgencySearch" id="submitAgencySearch" class="button_text" value="View Opportunities">
						<input type="reset" name="clearAgencySearch" id="clearAgencySearch" class="button_text" value=" Cancel " onclick="window.location = window.location.pathname">
						<br><br><br>
						<input type="button" name="addAgencySearch" id="addAgencySearch" class="button_text" value=" Add Opportunitiy " onclick="window.location = 'admin_agency_opp.php'"><br>
		 			</li>
				</ul>
			</form>
			</center>
			
			<form name="form_search_by_agency_requests" id="form_search_by_agency_requests" method="post" style="margin:10px" action="admin_opportunities.php">
				<?php
					$searchOppType = $_POST['searchOppsOption'];
					if($searchOppsOption == 'all') {
						$all_opp_status = 'checked';
					}
					else if ($searchOppsOption == 'open') {
						$open_opp_status = 'checked';
					}
					else {
						$closed_opp_status = 'checked';
					}

					
					if ($searchbyagency == 1) {
						$searchbyagency = 0;

						if($agyid>0)
						{
							$agy_where = "agy_id = ".$agyid." AND ";
							$agy_where2 = "(o.agy_id = ".$agyid." AND ";
						} else {
							$agy_where = "";
							$agy_where2 = "(";
						}
						
						
						$sql1 = ("SELECT agy_id, agy_name " .
									"FROM agency " .
									"WHERE " . $agy_where .
									"active = 1");
						$result1 = mysql_query($sql1)
							or die("Unable to find the agency name: " . mysql_error());
							
						$agyname = mysql_fetch_array($result1);
						//all opportunities
						if ($searchOppType == 'all') {	
						$sql2 = ("SELECT o.opp_id, " .
								 "		 o.agy_id, " .
								 "		 a.agy_name, " .
								 "		 o.opp_name, " .
								 "		 o.opp_description, " .
								 "		 o.open " .
								 "  FROM opportunity o " .
								 "INNER JOIN agency a " .
								 "    ON a.agy_id = o.agy_id " .
								 " WHERE " . $agy_where2 .
								 "o.admin_review = 1) " .
								 "ORDER BY o.open desc, " .
								 "		   o.opp_name");
						}
						//active opportunities
						else if ($searchOppType == 'open') {
						$sql2 = ("SELECT o.opp_id, " .
								 "		 o.agy_id, " .
								 "		 a.agy_name, " .
								 "		 o.opp_name, " .
								 "		 o.opp_description, " .
								 "		 o.open " .
								 "  FROM opportunity o " .
								 "INNER JOIN agency a " .
								 "    ON a.agy_id = o.agy_id " .
								 " WHERE " . $agy_where2 .
								 "o.admin_review = 1) " .
								 " AND o.open = 1 " .
								 "ORDER BY o.opp_name");
						}
						//inactive opportunities
						else {
						$sql2 = ("SELECT o.opp_id, " .
								 "		 o.agy_id, " .
								 "		 a.agy_name, " .
								 "		 o.opp_name, " .
								 "		 o.opp_description, " .
								 "		 o.open " .
								 "  FROM opportunity o " .
								 "INNER JOIN agency a " .
								 "    ON a.agy_id = o.agy_id " .
								 " WHERE " . $agy_where2 .
								 "o.admin_review = 1) " .
								 " AND o.open = 0 " .
								 "ORDER BY o.opp_name");
						}
						$result2 = mysql_query($sql2)
			 				or die ("Unable to make the agency opportunity table: " . mysql_error());
			 				
			 			$num_of_rows = mysql_num_rows($result2);
						
						echo "				<h2 align='center'>" . $agyname['agy_name'] . "</h2>";
						echo "				<center>";
						echo "				<table class='admin_search_results' id='opptable' border=1>";
						echo "					<th width='5px' style='min-width:5px'></th>";
						echo "					<th width='200px'>Opportunity Name</th>";
						echo "					<th width='430px'>Description</th>";
						echo "					<th width='10px' style='min-width:10px'>Open?</th>";
						
						while ($row = mysql_fetch_array($result2))
						{
							if($row['open']==1)
							{
								$openyesno="yes";
							}
							else
							{
							 $openyesno="no";
							}
							echo "					<tr>";
							echo "						<td><input type='radio' name='opp_id' id='opp_id' class='required' value='" . $row['opp_id'] . "'</td>";
							echo "						<td>" . $row['opp_name'] . "</td>";
							echo "						<td>" . $row['opp_description'] . "</td>";
							echo "						<td align='center'>" . $openyesno . "</td>";
							echo "					</tr>";
						}
						echo "				</table>";
						echo "				</center>";
						
						if ($num_of_rows == 0) {
							echo "				<br><h3 align='center' style='color:#FF0000'>Currently there are no opportunities for " . $agyname['agy_name'] . ".</h3><br>";
							$disabled = "disabled";
						} else {
							$disabled = "";
						}
						
						echo "				<ul>";
						echo "					<li class='buttons'>";
						echo "						<input type='hidden' name='form_id' value='submit_form_search_by_agency_requests'>";
						echo "						<input type='submit' name='submitSearchByAgencyRequests' id='submitSearchByAgencyRequests' class='button_text' value='Edit Opportunity' " . $disabled . ">";
				    	echo "						<input type='reset' name='clearSearchByAgencyRequests' id='clearSearchByAgencyRequests' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>";
						echo "					</li>";
						echo "				</ul>";
					}
				?>
			</form>

			<form id="form_edit_agency_opp" class="appnitro" method="post" action="scripts/process_admin_opportunities.php">					
				<?php	
					if ($searchbyopp == 1) {
						$searchbyopp = 0;
						
						echo "				<ul>";
						echo "		 			<li>";
						echo "		 				<span>";
						echo "		 					<label class='description' for='agencyID'>Agency </label>";

	 					$opp_sql = ("SELECT * " .
	 							 "  FROM opportunity " .
	 							 " WHERE opp_id = $oppid");
	 							 
	 					$opp_result = mysql_query($opp_sql)
	 						or die ("Unable to find agency opportunity!");
	 						
	 					$opp_row = mysql_fetch_array($opp_result);
	 					
	 					$dd_sql = ("SELECT agy_id, agy_name " .
			 					 "  FROM agency " .
			 					 " WHERE active = 1 " .
			 					 "ORDER BY agy_name");
			 						    
			 			$dd_result = mysql_query($dd_sql)
			 				or die ("Unable to make the query: " . mysql_error());
			 				
			 			try {
							$oppskill_sql = "	 SELECT skill_id " .
											"	   FROM opp_skill " .
											"     WHERE opp_id = $oppid " .
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
			 			
						echo "<select autofocus name='agencyID' id='agencyID' style='width:200px'>";
			 			echo "<option value=''>Select an agency</option>";
			 			while ($dd_row = mysql_fetch_array($dd_result)) {
			 				if ($dd_row['agy_id'] == $opp_row['agy_id']) {
			 					$selected = 'selected="selected"';
			 				} else {
				 				$selected = "";
			 				}
				 			echo "<option " . $selected . " value='" . $dd_row['agy_id'] . "'>" . $dd_row['agy_name'] . "</option>";
				 		}
				 		echo "</select>";
					}
				?>
						</span>
						<span>
						<span style="margin-left:15px">
							<label class="description" for="dateOfRequest">Request Date</label>
							<input id="dateOfRequest" name="dateOfRequest" class="text required" size="15" style="text-align:center"
								value="<?php echo date_format(date_create($opp_row['opp_requestdate']),'m/d/Y'); ?>">
						</span>
		 			</li>
					<li class="section_break">
						<p></p>
					</li>
					<li>
						<span>
							<label class="description" for="assignment_title">Title of Opportunity </label>
							<input name="opportunity_title" id="opportunity_title" class="text required" type="text" 
								size="60" maxlength="255" value="<?php echo $opp_row['opp_name']; ?>"> 
						</span>
					</li>
					<li>
						<span>	
							<label class="description" for="assignment_descr">Opportunity Description </label>
							<textarea name="opportunity_descr" class="text" rows="4" cols="69" maxlength="250"><?php echo $opp_row['opp_description']; ?></textarea> 
						</span>
					</li>
					<li>
						<div>
							<label class="description" for="startDate">Opportunity Date Range</label>
							<span>
								<input id="startDate" name="startDate" class="text required" size="11" value="<?php echo date_format(date_create($opp_row['opp_startdate']),'m/d/Y'); ?>">
								<label for="startDate">From</label>
							</span>
							<span style="margin-left:10px">
								<input id="endDate" name="endDate" class="text required" size="11" value="<?php echo date_format(date_create($opp_row['opp_enddate']),'m/d/Y'); ?>">
								<label for="endDate">To</label>
							</span>
						</div>
					</li>
					<li>
						<div>
							<span>
								<label class="description" for="startTime">Start Time </label>
								<input type="text" name="startTime" id="startTime" class="text" size="11"  value="<?php echo $opp_row['opp_starttime']; ?>">
							</span>
							<span style="margin-left:10px">
								<label class="description" for="endTime">End Time </label>
								<input type="text" name="endTime" id="endTime" class="text" size="11"  value="<?php echo $opp_row['opp_endtime']; ?>">
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
												class="text" value="<?php echo $opp_row['opp_streetaddress1']; ?>">
											<label for="street_address1">Street Address (line 1)</label>
										</span>
										<span class="clear">
											<input name="street_address2" size="60" maxlength="30" type="text"
												class="text" value="<?php echo $opp_row['opp_streetaddress2']; ?>">
											<label for="street_address2">Street Address (line 2)</label>
										</span>
										<span class="clear">
											<input name="city" size="40" maxlength="30" type="text"
												class="text" value="<?php echo $opp_row['opp_city']; ?>">
											<label for="city">City</label>
										</span>
										<span>
											<input name="state" size="3" maxlength="2" type="text" value="AL"
												class="center_text" value="<?php echo $opp_row['opp_state']; ?>">
											<label for="state">State</label>
										</span>
										<span>
											<input name="zip_code" size="15" maxlength="15" type="text"
												class="text" value="<?php echo $opp_row['opp_zipcode']; ?>">
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
				<div id="open_closed" align="center">
					<input type="radio" name="opp_isopen" id="opp_open" value="1" title="&nbsp;Open&nbsp;" <?php if($opp_row['open'] == 1) {echo 'checked';} ?>>
						<label for="opp_open">&nbsp;Open&nbsp;</label></input>
					<input type="radio" name="opp_isopen" id="opp_closed" value="0" title="Closed" <?php if($opp_row['open'] == 0) {echo 'checked';} ?>>
						<label for="opp_closed">Closed</label></input>
				</div>
				
				<ul>
					<li class="section_break">
					</li>
					<li class="buttons">
						<input type="hidden" name="submit_opp_id" value="<?php echo $opp_row['opp_id']; ?>">
						<input type="hidden" name="form_id" value="submit_form_edit_agency_opp">
						<input type="submit" name="submitAdminOpp" id="submitApproveOpp" class="button_text" value="Update">
						<input type="submit" name="submitAdminOpp" id="submitDeleteOpp" class="button_text" value="Delete">
						<input type='reset' name='clearSearchByVolunteer' id='clearSearchByVolunteer' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
					</li>
				</ul>
			</form>
			
		</div>
		<div class="footer">
			Designed by Athens State University
		</div>
	</div>
	</div>
</body>
</html>