<?php 
	
	require_once 'scripts/database_connection.php';
	require_once 'scripts/view.php';
	require_once 'scripts/authorize.php';
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
	$javascript = <<<EOD
	$(document).ready(function() {
		$( '#submitForm' ).attr('disabled', true);
		$( '#agency_text' ).hide();
		
		$( '#agencyID' ).change(function() {
			if ($( '#agencyID' ).val() != '') {
				$( '#submitForm' ).attr('disabled', false);
		        $( "#dateOfRequest" ).focus();
			} else {
				$( '#submitForm' ).attr('disabled', true);
				$( '#agencyID' ).focus();
			}
		});
		
		$( '#form_agency_opp' ).validate( {
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
	    
	    $('#print_btn').click(function() {
			$( '#agencyID' ).hide();
			$( '#agency_text' ).show();
			
			window.print();
			
			$( '#agencyID' ).show();
			$( '#agency_text' ).hide();
		});
	});
EOD;

	page_start("Agency Opportunity Request Form", $javascript, "agencyopp", $_REQUEST['success_message'], $error_message);
?>
			
		<div id="form_container">
	
			<form id="form_agency_opp" class="appnitro" method="post" action="scripts/add_agency_opp.php">
				<div class="form_description">
					<h2>Agency Opportunity Request Form
						<div style="float:right">
							<input type="button" id="print_btn" value="Print Blank Form">
						</div>
					</h2>
					<p class="clear">Note: Verification of the volunteering individual's credentials and certifications are the responsibility of the agency receiving the volunteer.</p>
				</div>						
				<ul>
		 			<li>
		 				<span>
		 					<label class="description" for="agencyID">Agency </label>
		 					<?php
			 					$sql = ("SELECT agy_id, agy_name " .
			 						    "  FROM agency " .
			 						    " WHERE active = 1 " .
			 						    "ORDER BY agy_name");
			 					$result = mysql_query($sql)
			 						or die ("Unable to make the query: " . mysql_error());
			 					
			 					echo "<select autofocus name='agencyID' id='agencyID' style='width:200px'>";
			 					echo "<option value=''>Select an agency</option>";
			 					while ($row = mysql_fetch_array($result)) {
				 					echo "<option value='" . $row['agy_id'] . "'>" . $row['agy_name'] . "</option>";
				 				}
				 				echo "</select>";
				 			?>
				 			<input id="agency_text" name="agency_text" class="text" size="50" />
						</span>
						<span>
						<span style="margin-left:15px">
							<label class="description" for="dateOfRequest">Request Date</label>
							<input id="dateOfRequest" name="dateOfRequest" class="text required" size="15" style="text-align:center" />
						</span>
		 			</li>
					<li class="section_break">
						<p></p>
					</li>
					<li>
						<span>
							<label class="description" for="assignment_title">Title of Opportunity </label>
							<input name="opportunity_title" id="opportunity_title" class="text required" type="text" 
								size="60" maxlength="255" /> 
						</span>
					</li>
					<li>
						<span>	
							<label class="description" for="assignment_descr">Opportunity Description </label>
							<textarea name="opportunity_descr" class="text" rows="4" cols="69" maxlength="250"></textarea> 
						</span>
					</li>
					<li>
						<div>
							<label class="description" for="startDate">Opportunity Date Range</label>
							<span>
								<input id="startDate" name="startDate" class="text required" size="11" />
								<label for="startDate">From</label>
							</span>
							<span style="margin-left:10px">
								<input id="endDate" name="endDate" class="text required" size="11" />
								<label for="endDate">To</label>
							</span>
						</div>
					</li>
					<li>
						<div>
							<span>
								<label class="description" for="startTime">Start Time </label>
								<input type="text" name="startTime" id="startTime" class="text" size="11" value="07:00 AM">
							</span>
							<span style="margin-left:10px">
								<label class="description" for="endTime">End Time </label>
								<input type="text" name="endTime" id="endTime" class="text" size="11" value="05:00 PM">
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
												class="text" />
											<label for="street_address1">Street Address (line 1)</label>
										</span>
										<span class="clear">
											<input name="street_address2" size="60" maxlength="30" type="text"
												class="text" />
											<label for="street_address2">Street Address (line 2)</label>
										</span>
										<span class="clear">
											<input name="city" size="40" maxlength="30" type="text"
												class="text" />
											<label for="city">City</label>
										</span>
										<span>
											<input name="state" size="3" maxlength="2" type="text" value="AL"
												class="center_text" />
											<label for="state">State</label>
										</span>
										<span>
											<input name="zip_code" size="15" maxlength="15" type="text"
												class="text" />
											<label for="zip_code">Postal / Zip Code</label>
										</span>
									</li>
									<li>
										<label class="description" for="directions">Directions to Job Site </label>
										<div>
											<textarea id="directions" name="directions" class="text" 
												rows="4" cols="70" maxlength="250"></textarea> 
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
									<?php list_skills(); ?>
										</span>
									</li>
								</ul>
							</td>
						</tr>
					</table>
				</center>

				<ul>
					<li class="section_break">
					</li>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_agency_opp" />
						<input id="submitForm" class="button_text" type="submit" name="submit" value="Submit" />
					</li>
				</ul>
			</form>	
		</div>
		<div class="footer">
			Designed by Athens State University
		</div>
	</body>
</html>