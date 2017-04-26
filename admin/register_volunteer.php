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
	authorize_user(array("Volunteers", "Administrators"));
	
	// Add any page specific javascript here.
	$javascript = <<<EOD
	$(document).ready(function() {
		$(':text:first').focus();
		$('#hide_health_comment').hide();
		$('#hide_affiliated_comment').hide();
		$('#hide_special_skills_comment').hide();
		
		$('#affiliated_yes').click(function() {
			$('#hide_affiliated_comment').show();
			$('#affiliated_comment').focus();
		});
		
		$('#affiliated_no').click(function() {
			$('#hide_affiliated_comment').hide();
			$('#affiliated_comment').val('');
		});
		
		$('#health_limits_yes').click(function() {
			$('#hide_health_comment').show();
			$('#health_limits_comment').focus();
		});
		
		$('#health_limits_no').click(function() {
			$('#hide_health_comment').hide();
			$('#health_limits_comment').val('');
		});
		
		$('#special_skills_yes').click(function() {
			$('#hide_special_skills_comment').show();
			$('#special_skills_comment').focus();
		});
		
		$('#special_skills_no').click(function() {
			$('#hide_special_skills_comment').hide();
			$('#special_skills_comment').val('');
		});
		
		$('#form_register_volunteer').validate( {
			errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.appendTo( '#skilllabel' );
		        } else {
		          error.insertAfter(element);
		        } 
		    }
		});
		
		
		$("input#dob").datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "c-100:c",
			onClose: function( selectedDate ) {
				$( "#dob" ).focus();
			}
		});
		
		$( '#home_phone' ).mask('(999) 999-9999');
		$( '#cell_phone' ).mask('(999) 999-9999');
		$( '#emer_phone' ).mask('(999) 999-9999');
		
		$('#form_register_volunteer').submit(function()
				{
					//This part makes a phone number be mandatory field
					/*
					if( $('#home_phone').val() == "" && $('#cell_phone').val() == "")
					{
						$('#phone').append('<label class="error" id="error">You must fill in a number. <br>&nbsp;</label>');
						$('input.text_phone').addClass('text_phone_invalid');
						$('input.text_phone').keypress(function()
						{
							$('input.text_phone').removeClass('text_phone_invalid');
							$('#error').remove();
						});
						return false;
					}
					*/
					//else
					{
						return true;
					}
				});
			
		$('#print_btn').click(function() {
			$('#health_limits_no').prop('checked', false);
			$('#affiliated_no').prop('checked', false);
			$('#special_skills_no').prop('checked', false);
			$('#hide_health_comment').show();
			$('#hide_affiliated_comment').show();
			$('#hide_special_skills_comment').show();
				
			window.print();
				
			$(':text:first').focus();
			$('#health_limits_no').prop('checked', true);
			$('#affiliated_no').prop('checked', true);
			$('#special_skills_no').prop('checked', true);
			$('#hide_health_comment').hide();
			$('#hide_affiliated_comment').hide();
			$('#hide_special_skills_comment').hide();
		});
	});
EOD;

	// Creates the Banner and Menus/Tabs based on the type of user logged in. Function is
	// 		located in view.php
	// Format is 'page_start("<page_title>", <embedded_javascript_from_above>, "<selected_tab>",
	//		<success_message>, <error_message>);
	// The selected_tab must be setup in the uw.css file around line 165.
	// If there's no embedded javascript, change $javascript to NULL, below.
	page_start("Disaster Volunteer Registration Form", $javascript, "addvol", $_REQUEST['success_message'], $error_message);
	
?>
		
    <div id="form_container">
		
		<form id="form_register_volunteer" class="appnitro"  method="POST"
			action="scripts/add_volunteer.php">
		
		<div class="form_description">
			<h2>Disaster Volunteer Registration Form
				<div style="float:right">
					<input type="button" id="print_btn" value="Print Blank Form">
				</div>
			</h2>
			<p class="clear">Note: Verification of the volunteering individual's credentials and 
			   certifications are the responsibility of the agency receiving the 
			   volunteer.</p>
		</div>
		<!-- **ASU2016**  Added missing checkboxes for volunteer type on form  06/19/2016   -->
		<li>
			<label class="description" for="type_of_work">I am willing to volunteer for: (Please check all the apply.) 
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
		<!-- **ASU2016**  End added code  06/19/2016   -->
		<ul>
			<li style="width:650px">
				<span>
					<label class="description" for="first_name">First Name</label>
					<input name="first_name" size="26" maxlength="30" type="text" 
						 />
				</span>
				<span>
					<label class="description" for="middle_initial">M.I.</label>
					<input name="middle_initial" size="2" maxlength="2" type="text" 
						class="center_text" />
				</span>
				<span>
					<label class="description" for="last_name">Last Name</label>
 					<input name="last_name" size="26" maxlength="30" type="text" 
						 />
 				</span>
 				<span style="margin-left:10px">
					<label class="description" for="dob">Date Of Birth</label>
 					<input id="dob" name="dob"  size="20" />
				</span>
				<!-- **ASU2016**  Added missing ssn on form  06/19/2016   -->
				<span style="margin-left:10px" id="ssn">
					<label class="description" for="ssn">Last 4 Digits of SSN (####)</label>
					<input name="ssn" size="8" maxlength="4" type="text" value="<?php echo $vol_row['ssn']; ?>">
				</span>
				<!-- **ASU2016**  End added code  06/19/2016   -->
				<span class="clear">
					<label class="description" for="email">Email Address</label>
 					<input name="email" id="email" type="text" size="40" maxlength="40" 
						class="text email" /> 
				</span> 
 				<span style="margin-left:10px" id="phone">
					<label class="description" for="home_phone_header">Home Phone </label>
					<input name="home_phone" id="home_phone" size="22" maxlength="15" type="text" 
						class="text_phone" />
				</span>
				<span style="margin-left:10px" id="phone">
					<label class="description" for="cell_phone_header">Cell Phone </label>
					<input name="cell_phone" id="cell_phone" size="22" maxlength="15" type="text" 
						class="text_phone" />
				</span>
			</li>
			<li>
				<span>
					<label class="description" for="address">Home Address</label>
					<input name="street_address1" size="87" maxlength="30" type="text"
						class="text" />
					<label for="street_address1">Street Address (line 1)</label>
				</span>
				<span class="clear">
					<input name="street_address2" size="87" maxlength="30" type="text"
						class="text" />
					<label for="street_address2">Street Address (line 2)</label>
				</span>
				<span class="clear">
					<input name="city" size="45" maxlength="30" type="text"
						 />
					<label for="city">City</label>
				</span>
				<span>
					<input name="state" size="2" maxlength="2" type="text" value="AL"
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
				<span>
					<label class="description" for="occupation">Occupation</label>
					<input name="occupation" size="41" maxlength="255" type="text" 
						class="text" /> 
				</span>
				<span>
					<label class="description" for="employer">Employer </label>
					<input name="employer" size="40" maxlength="255" type="text" 
						class="text" /> 
				</span> 
			</li>
			<li>
				<label class="description" for="health">Do you have any Health Limitations? </label>
				<span>
					<input type="radio" id="health_limits_yes" name="health_limits" value=1 />
					<label class="choice" for="health_limits_yes">Yes </label>
				</span>
				<span style="margin-left:10px">
					<input type="radio" id="health_limits_no" name="health_limits" value=0 checked="checked" />
					<label class="choice" for="health_limits_no">No</label>
				</span> 
			</li>
			<li>
				<div id="hide_health_comment">
					<label class="description" for="health_limits_comment">Please explain your health limitations here: </label>
					<span>
						<textarea id="health_limits_comment" name="health_limits_comment" rows="4"
							cols="80" maxlength="250"></textarea> 
					</span>
				</div>
				 
			</li>
			<li>
				<label class="description" for="affiliation">Are you currently affiliated 
					with any disaster relief organizations? </label>
				<span>
					<input type="radio" id="affiliated_yes" name="affiliated" value=1 />
					<label class="choice" for="affiliated_yes">Yes </label>
				</span>
				<span style="margin-left:10px">
					<input type="radio" id="affiliated_no" name="affiliated" value=0 checked="checked" />
					<label class="choice" for="affiliated_no">No</label>
				</span> 
			</li>
			<li>
				<div id="hide_affiliated_comment">
					<label class="description" for="affiliated_comment">Please explain your affiliations here: </label>
					<span>
						<textarea id="affiliated_comment" name="affiliated_comment" rows="4"
							cols="80" maxlength="250"></textarea> 
					</span>
				</div>
			</li>	
			<li>
				<label class="description" for="location">I am willing to volunteer in: 
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
			<li class="section_break break_before" style="font-size:14px">
				<h3>Emergency Contact:</h3>
				<p>&#160;</p>
				<center>
				<table align="center">
					<tr>
						<td>
							<span>
								<label class="description" for="emer_first_name">First Name</label>
								<input name="emer_first_name" size="26" maxlength="30" 
									type="text"  />
							</span>
							<span style="margin-left:5px">
								<label class="description" for="emer_last_name">Last Name</label>
			 					<input name="emer_last_name" size="26" maxlength="30" 
 									type="text"  />
		 					</span>
					 	</td>
					 </tr>
					 <tr>
					 	<td>
							<span>
								<label class="description" for="emer_relationship">Relationship</label>
								<input name="emer_relationship"  
									type="text" size="26" maxlength="30" /> 
							</span>
							<span style="margin-left:5px">
								<label class="description" for="emerg_phone_header">Emergency Contact 
									Phone</label>
								<input name="emer_phone" id="emer_phone" size="26" maxlength="15" type="text" 
									 />
							</span>
						</td>
					</tr>
				</table>
				</center>
			</li>
			<li class="section_break break_before" style="font-size:14px">
				<h3>Skills:</h3>
				<h3 id="skilllabel" align="center">&nbsp;</h3>
				<p>&#160;</p>
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
		
		<ul style="margin-left:75px">
			<li>
				<label class="description" for="spec_skills">Do you have any Special Skills or 
				Experience that's not listed above? </label>
				<span>
					<input type="radio" id="special_skills_yes" name="special_skills" value=1 />
					<label class="choice" for="special_skills_yes">Yes </label>
				</span>
				<span style="margin-left:10px">
					<input type="radio" id="special_skills_no" name="special_skills" value=0 checked="checked" />
					<label class="choice" for="special_skills_no">No</label>
				</span> 
			</li>
			<li>
				<div id="hide_special_skills_comment">
					<label class="description" for="special_skills_comment">Please list and/or explain them here.</label>
					<span>
						<textarea id="special_skills_comment" name="special_skills_comment" 
							rows="4" cols="70" maxlength="250"></textarea> 
					</span>
				</div> 
			</li>
		</ul>
		<ul>
			<li class="section_break">
			</li>
			<li class="buttons">
			    <input type="hidden" name="form_id" value="submit_register_volunteer" />
				<input id="submitForm" class="button_text" type="submit" name="submit" value="Submit" />
			</li>
		</ul>
		</form>	
		
	</div>
	<div class="footer">
		Designed by Athens State University
	</div>
	</div>
	</body>
</html>
