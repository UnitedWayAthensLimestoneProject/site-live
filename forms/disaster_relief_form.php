<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>

<title> Disaster Relief Form - United Way of Athens/Limstone County </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="stylesheet" type="text/css" href="../inc/css/uw.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../inc/css/print.css" media="print">
	<link rel="stylesheet" type="text/css" href="../inc/js/jquery/jquery-ui/smoothness/jquery-ui-1.10.3.custom.min.css">
	<script type="text/javascript" src="../inc/js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="../inc/js/jquery/query-ui.min.js"></script>
	<script type="text/javascript" src="../inc/js/jquery/jquery.validate.min.js"></script>
	<script type="text/javascript" src="../inc/js/jquery/jquery.maskedinput.min.js"></script>


<script type= "text/javascript">

		$(document).ready(function() {

			$('#hide_health_comment').hide();
			$('#hide_affiliated_comment').hide();
			$('#hide_special_skills_comment').hide();
			$('#hide_housing_needs').hide();
			$('#hide_rent').hide();
			$('#hide_interview').hide();

			$('#health_limits_yes').click(function() {
				$('#hide_health_comment').show();
				$('#health_limits_comment').focus();
			});

			$('#health_limits_no').click(function() {
				$('#hide_health_comment').hide();
				$('#health_limits_comment').val('');
			});
		    $('#housing_needs_yes').click(function() {
				$('#hide_housing_needs').show();
				$('#hide_housing_needs').focus();
			});
			$('#housing_needs_no').click(function() {
				$('#hide_housing_needs').hide();
				$('#hide_housing_needs').val('');
			});
			
			$('#disaster_relief_form').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.appendTo( '#validationlabel' );
					} else {
						error.insertAfter(element);
					} 
				}
			});

		
			
			
			$('input[value=renter]').click(function() {
				$('#hide_rent').show();
			});
			$('input[value=owner]').click(function() {
				$('#hide_rent').hide();
			});
			$('#interview_yes').click (function() {
				$('#hide_interview').show();
				/*$('#date_of_interview').addClass('required');
				$('#date_of_event').addClass('required');*/
			});
			$('#interview_no').click(function() {
				$('#hide_interview').hide();
				/*$('#date_of_interview').removeClass('required');
				$('#date_of_event').removeClass('required');*/
			});

			$('#disaster_relief_form').validate();

			datePickerProperties = {
				changeMonth: true,
				changeYear: true,
				yearRange: "c-100:c"
            };

			$("input#dob").datepicker(datePickerProperties);
			$("input#date_of_interview").datepicker(datePickerProperties);
			$("input#date_of_event").datepicker(datePickerProperties);
			$("input#id_expiration_date").datepicker(datePickerProperties);
			$("input[name^=hhmem_dob").datepicker(datePickerProperties);

			
		

			$( '#home_phone' ).mask('(999) 999-9999');
			$( '#cell_phone' ).mask('(999) 999-9999');
			$( '#insurance_provider_phone' ).mask('(999) 999-9999');

			$('#disaster_relief_form').submit(function()
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


</script>


</head>
<body>
<div id="wrapper">
		<div class="banner"><img src="../images/uww-logo_2013.png" alt="United Way Logo" /></div>
		<div id="menu" align="center">
			<ul id="mainNav" class="center">
				<li>
				</li>
		</ul>
		</div>



<div id="form_container">
		<form id="disaster_relief_form" class="appnitro"  method="POST"
			action="../inc/scripts/add_disaster.php">

		<div class="form_description">
			<h2>Disaster Relief Form</h2>
			<p>&#160;</p>
		</div>
		


		<h3>Primary Client or Household Representative</h3><br>
		
		<ul>
	<li style ="width: 1000px">
		<span>
			<label class="description" for="first_name">First Name</label>
			<input name="first_name" size ="26" maxlength="30" type ="text" class ="text required"/>
		</span>
		<span>
			<label class ="description" for ="middle_initial">M.I.</label>
			<input name="middle_initial" size ="1" maxlength="1" type ="text" class ="center_text"/>
		</span>
		<span>
			<label class ="description" for ="last_name"> Last Name</label>
			<input name ="last_name" size="26" maxlength ="30" type ="text" class= "text required"/>
			</span>
		<span style = "margin-left:10px">
			<label class = "description" for ="dob"> Date Of Birth </label>
			<input type="date" id ="dob" name ="dob" class ="text required" />
		</span>
		<span class = "clear">
			<label class ="description" for ="email"> Email Address</label>
			<input name="email" id = "email" type ="email" size ="40" maxlength ="100" class ="text email" placeholder="email@address.com" required/>
		</span>
		<span style ="margin-left:10px" id="phone">
			<label class="description" for="home_phone_header">Home Phone </label>
			<input name ="home_phone" id="home_phone" size="22" maxlength="15" type ="text" class="text_phone" placeholder="###-###-####"/>
		</span>
		<span style ="margin-left:10px">
			<label class ="description" for ="cell_phone_header">Cell Phone </label>
			<input name ="cell_phone" id="cell_phone" size="22" maxlength="15" type ="text" class="text_phone" placeholder="###-###-####"/>
		</span>

	</li>
	<br>


	<br><br>

	<li>
	<label class ="description" for "interview_date"> Do you have an interview with a United Way employee? </label>
	<span>
				<input  type ="radio" id ="interview_yes" name ="interview" value="1" title ="*PLEASE LET US KNOW IF YOU HAVE AN INTERVIEW " required/>
				<label class ="choice" for ="interview_yes">Yes</label>
			</span>
			<span style ="margin-left:10px">
				<input type="radio" id="interview_no" name="interview" value="0"  />
				<label class="choice" for="interview_no">No</label>
				</span>
			
			</li>

	<li>
				<div id="hide_interview">
				<span style ="margin-left:10px">
						<label class="description" for="interview_date"> Interview Date </label>
			<input name ="date_of_interview" id="date_of_interview" class ="text required" />
		</span>
		<span style ="margin-left:10px">
		<label class ="description" for="event_date"> Event Date </label>
			<input name ="date_of_event" id="date_of_event" class ="text required" />
		</span>
				</div>
			</li>
	<br>
	<br>


	<li>
		<span>
			<label class = "description" for="address"> Pre-Disaster Address</label>
			<input name="pre_add_st1" size ="87" maxlength ="30" type ="text" class ="text" />
			<label for ="pre_add_st1"> Street Address (line 1)</label>
		</span>
		<span class ="clear">
			<input name= "pre_add_st2" size="87" maxlength ="30" type ="text" class ="text"/>
			<label for ="pre_add_st2">Street Address (line 2) </label>
			</span>
		<span class ="clear">
			<input name ="pre_add_city" size ="25" maxlength ="30" type ="text" class ="text"/>
			<label for ="pre_add_city"> City </label>
		</span>
		<span>
		<input name="pre_add_state" size="2" maxlength ="2" type ="text" value="AL" class ="center_text"/>
		<label for ="pre_add_state">State</label>
		</span>
		<span>
			<input name ="pre_add_zip" size ="5" maxlength ="5" type ="text" class ="text" placeholder="#####"/>
				<label for ="pre_add_zip"/> Postal&#47; Zip Code </label>
		</span>
		</li>
		<li>
		<br>
	<br>


	<li>
		<span>
			<label class = "description" for="address2"> Post Disaster-Address</label>
			<input name="post_add_st1" size ="87" maxlength ="30" type ="text" class ="text required" />
			<label for ="post_add_st1"> Street Address (line 1)</label>
		</span>
		<span class ="clear">
			<input name= "post_add_st2" size="87" maxlength ="30" type ="text" class ="text "/>
			<label for ="post_add_st2">Street Address (line 2) </label>
			</span>
		<span class ="clear">
			<input name ="post_add_city" size ="25" maxlength ="30" type ="text" class ="text required"/>
			<label for ="post_add_city"> City </label>
		</span>
		<span>
		<input name="post_add_state" size="2" maxlength ="2" type ="text" value="AL" class ="center_text required"/>
		<label for ="post_add_state">State</label>
		</span>
		<span>
			<input name ="post_add_zip" size ="5" maxlength ="5" type ="text" class ="text" placeholder="#####"/>
				<label for ="post_add_zip"/> Postal&#47; Zip Code </label>
		</span>
		</li>

		<br>



	


		<li>
			<label class ="description" for ="health">Do you have any health limitations?</label>
			
			<span>
				<input  type ="radio" id ="health_limits_yes" name ="health_limits" value ="1" title ="*PLEASE SELECT A HEALTH OPTION"   required />
				<label class ="choice "  for ="health_limits_yes">Yes</label>
			</span>
			<span style ="margin-left:10px">
				<input type="radio" id="health_limits_no" name="health_limits"   value ="0" />
				<label class="choice " for="health_limits_no" >No</label>
				</span>
				
			</li>



			<li>
				<div id="hide_health_comment">
					<label class ="description" for="health_limits_comment">Please explain your health limitations here:</label>

							<span>
								<textarea id ="health_limits_comment" name ="health_limits_comment" rows ="4" cols ="80"
								maxlength ="250"></textarea>
							</span>
				</div>
			</li>


			<br>





			<li>
				<label class="description" for="annual_hh_income" >Annual Household Income </label>
				

				
					<span class ="left" style ="width:200px">
					
					<input name ="household_income" type ="radio"  value="0-9,999"  title ="*PLEASE SELECT AN INCOME LEVEL" required />
						$0 to $9,999
					</span>
					<span class ="left" style ="width:200px">
						<input name ="household_income" type ="radio" value="10,000-29,999"  />
						$10,000 to $29,999
					</span>
					<span class ="left" style ="width:200px">
						<input name ="household_income" type ="radio" value="30,000-49,999" />
						 $30,000 to $49,000
					</span>
			</li>

			<li>
					<span class ="left" style ="width:200px">
					<input name ="household_income" type ="radio"   value="50,000-69999"/>
					$50,000 to $69,000
					</span>
					<span class ="left" style ="width:200px">
					<input name ="household_income" type ="radio"   value="70,000-89,999"/>
					$70,000 to $89,999
					</span>
					<span class ="left" style ="width:200px">
					<input name ="household_income" type ="radio"  value="90,000-over"/>
					$90,000 and over
					</span>
					
			</li>
		<br>

			<div class="form_description">
			<p>&#160;</p>
		</div>

			<h1>Dwelling</h1>
			<br>
			<li>
				<label class ="description" for ="dwelling"> Type: </label>
					<span class ="left" style ="width:200px">
						<input name ="dwelling" type ="radio"  value="single_family" title ="*PLEASE SELECT A DWELLING TYPE" required/>
						Single Family
					</span>
					<span class ="left" style ="width:200px">
						<input name ="dwelling" type ="radio" value="Apt/Condo" />
						 Apartment/Condo
					</span>
					<span class ="left" style ="width:200px">
						<input name ="dwelling" type ="radio" value="mobile_home" />
						 Mobile Home
					</span>
		</li>
		<br>

	<li>
			<label class ="description" for ="owner_renter_info">Are you an owner or renter?</label>
			<span>
				<input  type ="radio" name="owner_renter_info" value="owner"  />
				<label class ="choice" for ="owner">Owner</label>
			</span>
			<span style ="margin-left:10px">
				<input type="radio" value="renter" name="owner_renter_info" />
				<label class="choice" for="renter">Renter</label>
				</span>
			</li>

		<div id="hide_rent">
		<br>
		<li>
			<label class ="description" for ="owner_renter_info"> Landlords Name: </label>
		</span>
		</li>
		<li>
		<span class ="left" style="width:200px">
			<label class="description" for="landlord_first_name">First Name</label>
			<input name="landlord_first_name" size ="26" maxlength="30" type ="text" class ="text"/>
		</span>
		<span class ="left" style="width:200px">
			<label class="description" for="landlord_last_name">Last Name</label>
			<input name="landlord_last_name" size ="26" maxlength="30" type ="text" class ="text"/>
		</span>
		</li>
		<li>
		<span class ="left" style="width:275px">
			<label class="description" for="monthly_rent">Monthly Rent</label>
			 $<input name="monthly_rent" size ="26" maxlength="30" type ="text" class ="text"/>
		</li>
		<br>
				</div>
<br>
		<li>
		</span>
		<span class ="left" style="width:275px">
			<label class="description" for="monthly_utilities">Monthly Utilities ( owners and renters):</label>
			$<input name="monthly_utilities" size ="26" maxlength="30" type ="text" class ="text"/>
		</span>

		</li>

	<li>
		<label class="description" for="dwelling_use">How is this dwelling used?</label>
		<span class ="left" style="width:200px">
			<input name ="dwelling_use" type ="radio" value="primary_dwelling" title = "*PLEASE SELECT DWELLING USAGE" required />
			Primary Dwelling
		</span>
		<span class ="left" style="width:200px">
			<input name ="dwelling_use" type ="radio" value="secondary_dwelling" />
			Secondary Dwelling
		</span>
		<span class ="left" style="width:200px">
			<input name ="dwelling_use" type ="radio" value="business" />
			Business
		</span>
	</li>
	<div class="form_description">

			<p>&#160;</p>
		</div>
	<h1>Insurance </h1>
	<br>
	<li>
		<label class="description" for="dwelling_insurance">Type of Insurance</label>
		<span class ="left" style="width:150px">
			<input name ="dwelling_insurance_contents" type ="checkbox" value="1"/>
			Contents
		</span>
		<span class ="left" style="width:150px">
			<input name ="dwelling_insurance_hazzard" type ="checkbox" value="1"/>
			Hazzard
		</span>
		<span class ="left" style="width:150px">
			<input name ="dwelling_insurance_structure" type ="checkbox" id="1"/>
			Structure
		</span>
		<span class = "left" style ="width:150px">  
			<input name ="dwelling_insurance_none" type ="checkbox" id="1"/>
			None
		</span>
	</li>

	<li>
		<span class ="left" style="width:250px">
		<label class="description" for="dwelling_insurance">Insurance Providers Name</label>
		<input name="insurance_provider_name" size ="26" maxlength="30" type ="text" class ="text"/>
		</span>
		<span class ="left" style="width:200px">
		<label class="description" for="dwelling_insurance">Insurance Providers Phone</label>
		<input id="insurance_provider_phone" name="insurance_provider_phone" size ="26" maxlength="30" type ="text" class ="text" placeholder="###-###-####"/>
	</li>
	<div class="form_description">

			<p>&#160;</p>
		</div>
	<h1> Damage </h1>
	<br>

<li>
			<label class ="description" for ="damage_level"> Level of damage: </label>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="destroyed" title ="*PLEASE SELECT LEVEL OF DAMAGE" required />
				Destroyed
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="major"/>
				Major
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="minor"/>
				Minor
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="affected"/>
				Affected
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="inaccessible"/>
				Inaccessible
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="unknown"/>
				Unknown
				</span>
		</li>

	<li>
			<label class ="description" for ="electricity">Is the electricity on or off at the affected location?</label>
			<span class ="left" style ="width:200px">
				<input  type ="radio" value="1" name ="elec_on_off" title = "*PLEASE LET US KNOW IF YOUR ELECTRICTY IS ON OR OFF" required />
				The electricity is ON
			</span>
			<span class ="left" style ="width:200px">
				<input  type ="radio" value="0" name ="elec_on_off"/>
				The electricity is OFF
				</span>
			</li>

		<li>
			<label class ="description" for ="housing_needs">Do you have any housing needs due to the disaster?</label>
			<span>
				<input  type ="radio" id="housing_needs_yes" name ="housing_needs" value="1" title ="*PLEASE SELECT A HOUSING NEEDS CHOICE " required  />
				<label class ="choice" for="housing_needs_yes">Yes</label>
			</span>
			<span style ="margin-left:10px">
				<input type="radio" id="housing_needs_no" name="housing_needs" value="0"   />
				<label class="choice" for="housing_needs_no">No</label>
				</span>
			</li>
			<li>
				<div id="hide_housing_needs">
				<label class ="description" for="housing_needs">What type of housing do you need?</label>
				<span class ="left" style="width:200px">
				<input name ="housing_need_type" type ="radio" value="Permanent"/>
				Permanent
				</span>
				<span class ="left" style="width:200px">
				<input name ="housing_need_type" type ="radio" value="Temporary"/>
				Temporary
				</span>
				
				</div>
			</li>
	<div class="form_description">

			<p>&#160;</p>
		</div>
	<br>
<h3>Please List names of other household members below </h3>	<br>
	<li style ="width: 850px">

	<span>
		<label class ="description" for ="hhmem_firstname">First Name</label>
		<input name="hhmem_firstname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
	<span>
		<label class ="description" for ="hhmem_lastname">Last Name</label>
	<input name="hhmem_lastname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
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
		<li style ="width: 850px">

	<span>
		<label class ="description" for ="hhmem_firstname">First Name</label>
		<input name="hhmem_firstname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
	<span>
		<label class ="description" for ="hhmem_lastname">Last Name</label>
	<input name="hhmem_lastname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
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
	<li style ="width: 850px">

	<span>
		<label class ="description" for ="hhmem_firstname">First Name</label>
		<input name="hhmem_firstname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
	<span>
		<label class ="description" for ="hhmem_lastname">Last Name</label>
	<input name="hhmem_lastname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
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
	<li style ="width: 850px">

	<span>
		<label class ="description" for ="hhmem_firstname">First Name</label>
		<input name="hhmem_firstname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
	<span>
		<label class ="description" for ="hhmem_lastname">Last Name</label>
	<input name="hhmem_lastname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
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
	<li style ="width: 850px">

	<span>
		<label class ="description" for ="hhmem_firstname">First Name</label>
		<input name="hhmem_firstname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
	<span>
		<label class ="description" for ="hhmem_lastname">Last Name</label>
	<input name="hhmem_lastname[]" type ="text" size ="23" maxlength ="30"/>
	</span>
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
	
	<br>
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

		<li class="buttons" id="buttons">
		<input type="hidden" name="form_id" value="submit_disaster_relief" />
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
