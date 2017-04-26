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
			$('#hide_health_comment').hide();

			$('#health_limits_yes').click(function() {
				$('#hide_health_comment').show();
				$('#health_limits_comment').focus();
			});

			$('#health_limits_no').click(function() {
				$('#hide_health_comment').hide();
				$('#health_limits_comment').val('');
			});
			
				$('#damage_rport_form').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.appendTo( '#validationlabel' );
					} else {
						error.insertAfter(element);
					} 
				}
			});
			
			$('#damage_rport_form').validate();

			datePickerProperties = {
				changeMonth: true,
				changeYear: true,
				yearRange: "c-100:c"
            };

			$("input#dob").datepicker(datePickerProperties);
			$("input[name^=hhmem_dob").datepicker(datePickerProperties);

			$( '#home_phone' ).mask('(999) 999-9999');
			$( '#cell_phone' ).mask('(999) 999-9999');
			$( '#insurance_provider_phone' ).mask('(999) 999-9999');

			$('#damage_rport_form').submit(function()
				{
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
					else
					{
						return true;
					}
				});
		});

EOD;

	
	// Creates the Banner and Menus/Tabs based on the type of user logged in. Function is
	// 		located in view.php
	// Format is 'page_start("<page_title>", <embedded_javascript_from_above>, "<selected_tab>",
	//		<success_message>, <error_message>);
	// The selected_tab must be setup in the uw.css file around line 165.
	// If there's no embedded javascript, change $javascript to NULL, below.
	page_start("Disaster Registration Form", $javascript, "adddisaster", $_REQUEST['success_message'], $error_message);
	admin_menu();

	
?>
		
    <div id="admin_form_container">
<form action="scripts/add_damage.php" method="GET" id="damage_rport_form" class="appnitro"> 
      <div class="form_description"> <h2>Damage Reporting Form</h2> 
        <p>&nbsp;</p> 
      </div> <h3>Household Representative</h3><br /> 
      <ul> 
        <li style="width: 900px;"> <span> 
            <label for="first_name" class="description">First Name</label> <input maxlength="30" size="26" name="first_name" class="text required" type="text" /> </span> <span> 
            <label for="middle_initial" class="description">M.I.</label> <input maxlength="1" size="1" name="middle_initial" class="center_text" type="text" /> </span> <span> 
            <label for="last_name" class="description"> Last Name</label> <input maxlength="30" size="26" name="last_name" class="text required" type="text" /> </span> <span style="margin-left: 10px;"> 
            <label for="dob" class="description"> Date Of Birth </label> <input name="dob" id="dob" class="text required" type="date" /> </span> <span class="clear"> 
            <label for="email" class="description"> Email Address</label> <input maxlength="40" size="40" id="email" name="email" class="text email" type="email" placeholder="email@address.com" /> </span> <span style="margin-left: 10px;"> 
            <label for="home_phone_header" class="description">Home Phone </label> <input maxlength="15" size="15" id="home_phone" name="home_phone" class="text_phone" type="text" placeholder="###-###-####" /> </span> <span style="margin-left: 10px;"> 
            <label for="cell_phone" class="description">Cell Phone </label> <input maxlength="15" size="15" id="cell_phone" name="cell_phone" class="text_phone" type="text" placeholder="###-###-####" /> </span> </li> <br /> 
        <div class="form_description"> 
          <p>&nbsp;</p> 
        </div> <h3>Location of Damaged Area</h3><br /> 
        <li> <span> 
            <label for="address" class="description"> Address of Damaged Area</label> <input maxlength="30" size="80" name="add_st1" class="text required" type="text" /> 
            <label for="add_st2"> Street Address (line 1)</label> </span> <span class="clear"> <input maxlength="30" size="80" name="add_st2" class="text " type="text" /> 
            <label for="add_st2">Street Address (line 2) </label> </span> <span class="clear"> <input maxlength="30" size="25" name="add_city" class="text required" type="text" /> 
            <label for="add_city"> City </label> </span> <span> <input maxlength="2" size="2" name="add_state" class="center_text required" type="text" value="AL" /> 
            <label for="add_state">State</label> </span> <span> <input maxlength="15" size="5" name="add_zip" class="text" type="text" placeholder="#####" /> 
            <label for="add_zip"> Postal/ Zip Code </label> </span> </li> 
        <div class="form_description"> 
          <p>&nbsp;</p> 
        </div> 
        <li> 
          <label for="health" class="description">Do you have any health limitations?</label> <span> <input name="health_limits" id="health_limits_yes" type="radio" value="1" title = "*PLEASE SELECT A HEALTH OPTION" required/> 
            <label for="health_limits_yes" class="choice">Yes</label> </span> <span style="margin-left: 10px;"> <input  name="health_limits" id="health_limits_no" type="radio" value="0" /> 
            <label for="health_limits_no" class="choice" >No</label> </span> </li> 
        <li> 
          <div id="hide_health_comment"> 
            <label for="health_limits_comment" class="description">Please explain your health limitations here:</label> <span> <textarea maxlength="250" cols="80" rows="4" name="health_limits_comment" id="health_limits_comment" type="textarea"></textarea> </span> 
          </div> </li> <br /> <h3>Dwelling</h3> 
        <li> 
          <label for="dwelling" class="description"> Type: </label> <span style="width: 200px;" class="left"> <input  name="dwelling" type="radio" value="single_family" title ="*PLEASE SELECT DWELLING TYPE" required />						Single Family
					</span> <span style="width: 200px;" class="left"> <input name="dwelling" type="radio" value="Apt/Condo" />						 Apartment/Condo
					</span> <span style="width: 200px;" class="left"> <input name="dwelling" type="radio" value="mobile_home" />						 Mobile Home
					</span> </li> <br /> 
        <li> 
          <label for="dwelling" class="description"> Are you an Owner or Renter? </label> <span> <input name="owner_renter_info" type="radio" value="owner" /> 
            <label for="owner" class="choice">Owner</label> </span> <span style="margin-left: 10px;"> <input name="owner_renter_info" type="radio" value="renter" /> 
            <label for="renter" class="choice">Renter</label> </span> </li> <br /> 
        <div class="form_description"> 
          <p>&nbsp;</p> 
        </div> 
        <li> 
          <label for="damage_level" class="description"> Level of Damage: </label> <span style="width: 200px;" class="left"> <input  name="levofdamage" type="radio" value="destroyed" title = "*PLEASE SELECT LEVEL OF DAMAGE" required />				Destroyed
				</span> <span style="width: 200px;" class="left"> <input name="levofdamage" type="radio" value="major"  />				Major
				</span> <span style="width: 200px;" class="left"> <input name="levofdamage" type="radio" value="minor" />				Minor
				</span> <span style="width: 200px;" class="left"> <input name="levofdamage" type="radio" value="affected" />				Affected
				</span> <span style="width: 200px;" class="left"> <input name="levofdamage" type="radio" value="inaccessible" />				Inaccessible
				</span> <span style="width: 200px;" class="left"> <input name="levofdamage" type="radio" value="unknown" />				Unknown
				</span> </li> <br /> 
        <div class="form_description"> 
          <p>&nbsp;</p> 
 <h3>Please List names of other household members below </h3>	<br>
	<li style ="width: 650px">

	<span>
		<label class ="description" for ="hhmem_firstname">First Name</label>
		<input name="hhmem_firstname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
	<span>
		<label class ="description" for ="hhmem_lastname">Last Name</label>
	<input name="hhmem_lastname[]" type ="text" size ="23" maxlength ="30"/>
	</span></li><li style ="width: 650px">
	<span>
		<label class ="description" for ="gender">Gender</label>
		<select name="hhmem_gender[]">
		<option value="Male" selected>Male </option>
		<option value ="Female">Female</option>
		</select>
	</span>
	<span>
	<label class ="description" for ="hhmem_dob">D.O.B.</label>
	<input name="hhmem_dob[]" type ="date" size ="8" maxlength ="10"/>
	</span>
	<span>
	<label class ="description" for ="hhmem_relation">Relationship</label>
	<input name="hhmem_relation[]" type ="text" size ="15" maxlength ="30"/>
	</span>
	</li>
	<br>
		<li style ="width: 650px">

	<span>
		<label class ="description" for ="hhmem_firstname">First Name</label>
		<input name="hhmem_firstname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
	<span>
		<label class ="description" for ="hhmem_lastname">Last Name</label>
	<input name="hhmem_lastname[]" type ="text" size ="23" maxlength ="30"/>
	</span></li><li style ="width: 650px">
	<span>
		<label class ="description" for ="gender">Gender</label>
		<select name="hhmem_gender[]">
		<option value="Male" selected>Male </option>
		<option value ="Female">Female</option>
		</select>
	</span>
	<span>
	<label class ="description" for ="hhmem_dob">D.O.B.</label>
	<input name="hhmem_dob[]" type ="date" size ="8" maxlength ="10"/>
	</span>
	<span>
	<label class ="description" for ="hhmem_relation">Relationship</label>
	<input name="hhmem_relation[]" type ="text" size ="15" maxlength ="30"/>
	</span>
	</li>
	<br>
	<li style ="width: 650px">

	<span>
		<label class ="description" for ="hhmem_firstname">First Name</label>
		<input name="hhmem_firstname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
	<span>
		<label class ="description" for ="hhmem_lastname">Last Name</label>
	<input name="hhmem_lastname[]" type ="text" size ="23" maxlength ="30"/>
	</span></li><li style ="width: 650px">
	<span>
		<label class ="description" for ="gender">Gender</label>
		<select name="hhmem_gender[]">
		<option value="Male" selected>Male </option>
		<option value ="Female">Female</option>
		</select>
	</span>
	<span>
	<label class ="description" for ="hhmem_dob">D.O.B.</label>
	<input name="hhmem_dob[]" type ="date" size ="8" maxlength ="10"/>
	</span>
	<span>
	<label class ="description" for ="hhmem_relation">Relationship</label>
	<input name="hhmem_relation[]" type ="text" size ="15" maxlength ="30"/>
	</span>
	</li>
	<br>
	<li style ="width: 650px">

	<span>
		<label class ="description" for ="hhmem_firstname">First Name</label>
		<input name="hhmem_firstname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
	<span>
		<label class ="description" for ="hhmem_lastname">Last Name</label>
	<input name="hhmem_lastname[]" type ="text" size ="23" maxlength ="30"/>
	</span></li><li style ="width: 650px">
	<span>
		<label class ="description" for ="gender">Gender</label>
		<select name="hhmem_gender[]">
		<option value="Male" selected>Male </option>
		<option value ="Female">Female</option>
		</select>
	</span>
	<span>
	<label class ="description" for ="hhmem_dob">D.O.B.</label>
	<input name="hhmem_dob[]" type ="date" size ="8" maxlength ="10"/>
	</span>
	<span>
	<label class ="description" for ="hhmem_relation">Relationship</label>
	<input name="hhmem_relation[]" type ="text" size ="15" maxlength ="30"/>
	</span>
	</li>
	<br>
	<li style ="width: 650px">

	<span>
		<label class ="description" for ="hhmem_firstname">First Name</label>
		<input name="hhmem_firstname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
	<span>
		<label class ="description" for ="hhmem_lastname">Last Name</label>
	<input name="hhmem_lastname[]" type ="text" size ="23" maxlength ="30"/>
	</span></li><li style ="width: 650px">
	<span>
		<label class ="description" for ="gender">Gender</label>
		<select name="hhmem_gender[]">
		<option value="Male" selected>Male </option>
		<option value ="Female">Female</option>
		</select>
	</span>
	<span>
	<label class ="description" for ="hhmem_dob">D.O.B.</label>
	<input name="hhmem_dob[]" type ="date" size ="8" maxlength ="10"/>
	</span>
	<span>
	<label class ="description" for ="hhmem_relation">Relationship</label>
	<input name="hhmem_relation[]" type ="text" size ="15" maxlength ="30"/>
	</span>
	</li>
			
			<h2 id="validationlabel" align="center" > &nbsp; <br><br> </h2>
			
			
			<li class="buttons">
				<img id="captcha" src="/inc/securimage/securimage_show.php" alt="CAPTCHA Image" />
                                                                   <object type="application/x-shockwave-flash"data="/inc/securimage/securimage_play.swf?audio_file=/inc/securimage/securimage_play.php&amp;
                                                                        bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" width="25" height="25">
                                                                   <param name="movie" value="/inc/securimage/securimage_play.swf?audio_file=/inc/securimage/securimage_play.php&amp;
                                                                        bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" />
                                                                   </object><br>
				<input type="text" name="captcha_code" size="15" maxlength="6" />
                                                                   <br> 
                                                                   <a href="#" onclick="document.getElementById('captcha').src = '/inc/securimage/securimage_show.php?' + Math.random(); 
				return false">[ Different Image ]</a>
			</li>
		
        <ul> 
          <li id="buttons" class="buttons"> <input name="form_id" type="hidden" value="submit_damage_form" /> <input name="submit" id="submitForm" class="button_text" type="submit" value="Submit" /> </li> 
        </ul> 
      </ul>
	  </form>		</div>
	<div class="footer">
		Designed by Athens State University
	</div>
	</div>
</body>


</html>
