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
	// Current user groups are Administrators, disasters, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	authorize_user(array("Administrators"));
	

	
	if (isset($_POST['form_id']) || isset($_GET['edit_disaster'])) {
		
		$searchform = $_POST['form_id'];
		
		if ($searchform == 'submit_form_search_for_disaster') {
			$searchforvol = 1;
			$searchfirstname = mysql_real_escape_string(trim($_POST['searchfirstname']));
			$searchlastname = mysql_real_escape_string(trim($_POST['searchlastname']));
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_disaster, #form_edit_disaster ').hide();
			$(' #form_search_by_disaster ').show();
			
			$('#form_search_by_disaster').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #editvoltable ');
					} else {
						error.insertAfter(element);
					}
				},
				messages: {
					disaster_id: {
						required: "<br>Select a row to edit."
					}
				}
			});
		});
EOD;
		} else if (($searchform == 'submit_form_search_by_disaster') || isset($_GET['edit_disaster'])) {
			$searchbyvol = 1;
			
			if(isset($_GET['edit_disaster']))
			{
				$searchvolid = $_GET['edit_disaster'];
			} else {
				$searchvolid = $_POST['disaster_id'];
			}
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_disaster, #form_search_by_disaster, #editvoltable ').hide();
			$(' #form_edit_disaster ').show();
			
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
			
			$( '#home_phone' ).mask('(999) 999-9999');
			$( '#cell_phone' ).mask('(999) 999-9999');
			$( '#emer_phone' ).mask('(999) 999-9999');
			
			$('#form_edit_disaster').submit(function()
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
				
				$('#form_edit_disaster').validate( {
				errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.appendTo( '#skilllabel' );
		        } else {
		          error.insertAfter(element);
		        } 
		    }
				});
		});
		
		$(function() {
			$( "input#dob" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: "c-100:c",
				onClose: function( selectedDate ) {
					$( "#dob" ).focus();
				}
			});
	    });
EOD;
			
		}

	} else {
		
		$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_by_disaster, #form_edit_disaster ').hide();
			$(' #form_search_for_disaster ').show();
			$(' #searchfirstname ').focus();
			
			$('#form_search_for_disaster').submit(function()
				{
					return true;
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
EOD;
		
	

	$javascript .= "
	
	$(function () {    
    $('#editvoltable').w2grid({ 
        name: 'grid', 
		header: 'Disasters',
		multiSelect : false,
        show: { 
            toolbar: true,
            footer: true,
			header: true,
            toolbarEdit: true,
            toolbarAdd: true
        },
        searches: [                
            { field: 'first_name', caption: 'First Name', type: 'text' },
            { field: 'last_name', caption: 'Last Name', type: 'text' },
            { field: 'email_address', caption: 'Email', type: 'text' },
            { field: 'home_phone', caption: 'Home Phone', type: 'text' },
            { field: 'cell_phone', caption: 'Cell Phone', type: 'text' },
        ],
        columns: [                
            { field: 'first_name', caption: 'First Name', size: '30%', sortable: true, attr: 'align=right' },
            { field: 'last_name', caption: 'Last Name', size: '30%', sortable: true, attr: 'align=right' },
            { field: 'email_address', caption: 'Email', size: '40%', sortable: true, attr: 'align=center' },
            { field: 'home_phone', caption: 'Home Phone', size: '120px', sortable: true, attr: 'align=center' },
            { field: 'cell_phone', caption: 'Cell Phone', size: '120px', sortable: true, attr: 'align=center' },
         ],
        onAdd: function (event) {
			location.href = 'admin_new_disaster.php';
        },
        onEdit: function (event) {
			location.href = 'admin_disaster.php?edit_disaster='+event.recid;
        },
        onDelete: function (event) {
            console.log('delete has default behaviour');
        },
        onSave: function (event) {
            w2alert('save');
        },
        records: [
		";
		
		if ($searchfirstname != "" && $searchlastname != "") {
			$where = "first_name LIKE '$searchfirstname%' " .
					 "AND last_name LIKE '$searchlastname%' " .
					 "AND admin_review = 1";
		} else if ($searchfirstname != "") {
			$where = "first_name LIKE '$searchfirstname%' " .
					 "AND admin_review = 1";
		} else if ($searchlastname != "") {
			$where = "last_name LIKE '$searchlastname%' " .
					 "AND admin_review = 1";
		} else {
			$where = "admin_review = 1";
		}
		
		try {
			$sql = "SELECT DISTINCT disaster_id, " .
				   "				first_name, " .
				   "				last_name, " .
				   "				email, " .
				   "				home_phone, " .
				   "				cell_phone " .
				   "		   FROM disaster " .
				   "		  WHERE " . $where .
				   "	   ORDER BY first_name, " .
				   "	 		    last_name";
		
			$result = mysql_query($sql)
				or handle_error("an error occurred while searching for disasters", mysql_error());
			
			$num_of_rows = mysql_num_rows($result);

		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to search for disasters.",
				"Error searching for disasters: " . $exc->getMessage());
		}
		
		while ($row = mysql_fetch_array($result))
		{
			$javascript .= "{ recid: ".$row['disaster_id'].", first_name: '".$row['first_name']."', last_name: '".$row['last_name']."', email_address: '".$row['email']."', home_phone: '".$row['home_phone']."', cell_phone: '".$row['cell_phone']."' },
			";
		}

$javascript .= "		
        ]
    });    
});";
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminDisaster",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Disaster Administration</h2>
				<p>Allows Administrators to edit a disaster's information.<br>(NOTE: disasters that have not been approved by admin review, will not be listed below.)</p>
			</div>	
			
			<div id="editvoltable"></div>
			
			<center>
			<form name="form_search_for_disaster" id="form_search_for_disaster" method="post" style="margin:25px 10px" 
				action="admin_disaster.php">
			</form>
			</center>
			
			<form name="form_search_by_disaster" id="form_search_by_disaster" method="post" style="margin:25px 10px" 
				action="admin_disaster.php">
			</form>
			
			<form name="form_edit_disaster" id="form_edit_disaster" class="appnitro" method="POST" action="scripts/process_admin_disaster.php">
				<?php
					if ($searchbyvol == 1) {
						$searchbyvol = 0;
					
						$disaster_query = "SELECT * " .
								 	"  FROM disaster " .
								 	" WHERE disaster_id = " . $searchvolid;
								 
						$disaster_data = mysql_query($disaster_query)
						 	or handle_error("an error occurred while searching for disaster", mysql_error());
						
					 	$disaster_row = mysql_fetch_array($disaster_data);

						}
				?>
				<ul>
					<li style="width:650px">
		<h3>Primary Client or Household Representative</h3><br>
		
		<ul>
	<li style ="width: 1000px">
		<span>
			<label class="description" for="first_name">First Name</label>
			<input name="first_name" size ="26" maxlength="30" type ="text" class ="text required" value="<?php echo($disaster_row['first_name']); ?>"/>
		</span>
		<span>
			<label class ="description" for ="middle_initial">M.I.</label>
			<input name="middle_initial" size ="1" maxlength="1" type ="text" class ="center_text" value="<?php echo($disaster_row['middle_initial']); ?>"/>
		</span>
		<span>
			<label class ="description" for ="last_name"> Last Name</label>
			<input name ="last_name" size="26" maxlength ="30" type ="text" class= "text required" value="<?php echo($disaster_row['last_name']); ?>"/>
			</span>
		<span style = "margin-left:10px">
			<label class = "description" for ="dob"> Date Of Birth </label>
			<input type="date" id ="dob" name ="dob" class ="text required" value="<?php echo($disaster_row['date_of_birth']); ?>" />
		</span>
		<span class = "clear">
			<label class ="description" for ="email"> Email Address</label>
			<input name="email" id = "email" type ="email" size ="40" maxlength ="100" class ="text email" placeholder="email@address.com" value="<?php echo($disaster_row['email']); ?>" />
		</span>
		<span style ="margin-left:10px" id="phone">
			<label class="description" for="home_phone_header">Home Phone </label>
			<input name ="home_phone" id="home_phone" size="15" maxlength="15" type ="text" class="text_phone" placeholder="###-###-####" value="<?php echo($disaster_row['home_phone']); ?>"/>
		</span>
		<span style ="margin-left:10px">
			<label class ="description" for ="cell_phone_header">Cell Phone </label>
			<input name ="cell_phone" id="cell_phone" size="15" maxlength="15" type ="text" class="text_phone" placeholder="###-###-####" value="<?php echo($disaster_row['cell_phone']); ?>"/>
		</span>

	</li>
	<br>


	<br><br>

	<li>
	<label class ="description" for "interview_date"> Do you have an interview with a United Way employee? </label>
	<span>
				<input  type ="radio" id ="interview_yes" name ="interview" value="1" title ="*PLEASE LET US KNOW IF YOU HAVE AN INTERVIEW "  <?php if($disaster_row['interview']==1){ echo('checked="checked"'); } ?>/>
				<label class ="choice" for ="interview_yes">Yes</label>
			</span>
			<span style ="margin-left:10px">
				<input type="radio" id="interview_no" name="interview" value="0" <?php if($disaster_row['interview']==0){ echo('checked="checked"'); } ?> />
				<label class="choice" for="interview_no">No</label>
				</span>
			
			</li>

	<li>
				<span style ="margin-left:10px">
						<label class="description" for="interview_date"> Interview Date </label>
			<input name ="date_of_interview" id="date_of_interview" class ="text"  value="<?php echo($disaster_row['date_of_interview']); ?>" />
		</span>
		<span style ="margin-left:10px">
		<label class ="description" for="event_date"> Event Date </label>
			<input name ="date_of_event" id="date_of_event" class ="text"  value="<?php echo($disaster_row['date_of_event']); ?>"/>
		</span>
			</li>
	<br>
	<br>


	<li>
		<span>
			<label class = "description" for="address"> Pre-Disaster Address</label>
			<input name="pre_add_st1" size ="80" maxlength ="30" type ="text" class ="text" value="<?php echo($disaster_row['pre_add_st1']); ?>" />
			<label for ="pre_add_st1"> Street Address (line 1)</label>
		</span>
		<span class ="clear">
			<input name= "pre_add_st2" size="80" maxlength ="30" type ="text" class ="text" value="<?php echo($disaster_row['pre_add_st2']); ?>"/>
			<label for ="pre_add_st2">Street Address (line 2) </label>
			</span>
		<span class ="clear">
			<input name ="pre_add_city" size ="25" maxlength ="30" type ="text" class ="text" value="<?php echo($disaster_row['pre_add_city']); ?>"/>
			<label for ="pre_add_city"> City </label>
		</span>
		<span>
		<input name="pre_add_state" size="2" maxlength ="2" type ="text" value="AL" class ="center_text" value="<?php echo($disaster_row['pre_add_state']); ?>"/>
		<label for ="pre_add_state">State</label>
		</span>
		<span>
			<input name ="pre_add_zip" size ="5" maxlength ="5" type ="text" class ="text" placeholder="#####" value="<?php echo($disaster_row['pre_add_zip']); ?>"/>
				<label for ="pre_add_zip"/> Postal&#47; Zip Code </label>
		</span>
		</li>
		<li>
		<br>
	<br>


	<li>
		<span>
			<label class = "description" for="address2"> Post Disaster-Address</label>
			<input name="post_add_st1" size ="80" maxlength ="30" type ="text" class ="text required" value="<?php echo($disaster_row['post_add_st1']); ?>" />
			<label for ="post_add_st1"> Street Address (line 1)</label>
		</span>
		<span class ="clear">
			<input name= "post_add_st2" size="80" maxlength ="30" type ="text" class ="text " value="<?php echo($disaster_row['post_add_st2']); ?>"/>
			<label for ="post_add_st2">Street Address (line 2) </label>
			</span>
		<span class ="clear">
			<input name ="post_add_city" size ="25" maxlength ="30" type ="text" class ="text required" value="<?php echo($disaster_row['post_add_city']); ?>"/>
			<label for ="post_add_city"> City </label>
		</span>
		<span>
		<input name="post_add_state" size="2" maxlength ="2" type ="text" value="AL" class ="center_text required" value="<?php echo($disaster_row['post_add_state']); ?>"/>
		<label for ="post_add_state">State</label>
		</span>
		<span>
			<input name ="post_add_zip" size ="5" maxlength ="5" type ="text" class ="text" placeholder="#####" value="<?php echo($disaster_row['post_add_zip']); ?>"/>
				<label for ="post_add_zip"/> Postal&#47; Zip Code </label>
		</span>
		</li>

		<br>



	


		<li>
			<label class ="description" for ="health">Do you have any health limitations?</label>
			
			<span>
				<input  type ="radio" id ="health_limits_yes" name ="health_limits" value ="1" title ="*PLEASE SELECT A HEALTH OPTION"   <?php if($disaster_row['health_limitation']==1){ echo('checked="checked"'); } ?> />
				<label class ="choice "  for ="health_limits_yes">Yes</label>
			</span>
			<span style ="margin-left:10px">
				<input type="radio" id="health_limits_no" name="health_limits"   value ="0"    <?php if($disaster_row['health_limitation']==0){ echo('checked="checked"'); } ?>/>
				<label class="choice " for="health_limits_no" >No</label>
				</span>
				
			</li>



			<li>
				<div id="hide_health_comment">
					<label class ="description" for="health_limits_comment">Please explain your health limitations here:</label>

							<span>
								<textarea id ="health_limits_comment" name ="health_limits_comment" rows ="4" cols ="80"
								maxlength ="250"> <?php echo($disaster_row['post_add_zip']); ?></textarea>
							</span>
				</div>
			</li>


			<br>





			<li>
				<label class="description" for="annual_hh_income" >Annual Household Income </label>
				

				
					<span class ="left" style ="width:200px">
					
					<input name ="household_income" type ="radio"  value="0-9,999"  title ="*PLEASE SELECT AN INCOME LEVEL"  <?php if($disaster_row['annual_income']=="0-9,999"){ echo('checked="checked"'); } ?> />
						$0 to $9,999
					</span>
					<span class ="left" style ="width:200px">
						<input name ="household_income" type ="radio" value="10,000-29,999"  <?php if($disaster_row['annual_income']=="10,000-29,999"){ echo('checked="checked"'); } ?> />
						$10,000 to $29,999
					</span>
					<span class ="left" style ="width:200px">
						<input name ="household_income" type ="radio" value="30,000-49,999"  <?php if($disaster_row['annual_income']=="30,000-49,999"){ echo('checked="checked"'); } ?>/>
						 $30,000 to $49,000
					</span>
			</li>

			<li>
					<span class ="left" style ="width:200px">
					<input name ="household_income" type ="radio"   value="50,000-69999" <?php if($disaster_row['annual_income']=="50,000-69999"){ echo('checked="checked"'); } ?>/>
					$50,000 to $69,000
					</span>
					<span class ="left" style ="width:200px">
					<input name ="household_income" type ="radio"   value="70,000-89,999" <?php if($disaster_row['annual_income']=="70,000-89,999"){ echo('checked="checked"'); } ?>/>
					$70,000 to $89,999
					</span>
					<span class ="left" style ="width:200px">
					<input name ="household_income" type ="radio"  value="90,000-over" <?php if($disaster_row['annual_income']=="90,000-over"){ echo('checked="checked"'); } ?>/>
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
						<input name ="dwelling" type ="radio"  value="single_family" title ="*PLEASE SELECT A DWELLING TYPE"  <?php if($disaster_row['dwelling']=="single_family"){ echo('checked="checked"'); } ?>/>
						Single Family
					</span>
					<span class ="left" style ="width:200px">
						<input name ="dwelling" type ="radio" value="Apt/Condo"  <?php if($disaster_row['dwelling']=="Apt/Condo"){ echo('checked="checked"'); } ?>/>
						 Apartment/Condo
					</span>
					<span class ="left" style ="width:200px">
						<input name ="dwelling" type ="radio" value="mobile_home"  <?php if($disaster_row['dwelling']=="mobile_home"){ echo('checked="checked"'); } ?>/>
						 Mobile Home
					</span>
		</li>
		<br>

	<li>
			<label class ="description" for ="owner_renter_info">Are you an owner or renter?</label>
			<span>
				<input  type ="radio" name="owner_renter_info" value="owner" <?php if($disaster_row['owner_renter_info']=="owner"){ echo('checked="checked"'); } ?>  />
				<label class ="choice" for ="owner">Owner</label>
			</span>
			<span style ="margin-left:10px">
				<input type="radio" value="renter" name="owner_renter_info" <?php if($disaster_row['owner_renter_info']=="renter"){ echo('checked="checked"'); } ?> />
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
			<input name="landlord_first_name" size ="26" maxlength="30" type ="text" class ="text" value="<?php echo($disaster_row['landlord_first_name']); ?>"/>
		</span>
		<span class ="left" style="width:200px">
			<label class="description" for="landlord_last_name">Last Name</label>
			<input name="landlord_last_name" size ="26" maxlength="30" type ="text" class ="text" value="<?php echo($disaster_row['landlord_last_name']); ?>"/>
		</span>
		</li>
		<li>
		<span class ="left" style="width:275px">
			<label class="description" for="monthly_rent">Monthly Rent</label>
			 $<input name="monthly_rent" size ="26" maxlength="30" type ="text" class ="text" value="<?php echo($disaster_row['monthly_rent']); ?>"/>
		</li>
		<br>
				</div>
<br>
		<li>
		</span>
		<span class ="left" style="width:275px">
			<label class="description" for="monthly_utilities">Monthly Utilities ( owners and renters):</label>
			$<input name="monthly_utilities" size ="26" maxlength="30" type ="text" class ="text" value="<?php echo($disaster_row['monthly_utilities']); ?>"/>
		</span>

		</li>

	<li>
		<label class="description" for="dwelling_use">How is this dwelling used?</label>
		<span class ="left" style="width:200px">
			<input name ="dwelling_use" type ="radio" value="primary_dwelling" title = "*PLEASE SELECT DWELLING USAGE"  <?php if($disaster_row['dwelling_use']=="primary_dwelling"){ echo('checked="checked"'); } ?> />
			Primary Dwelling
		</span>
		<span class ="left" style="width:200px">
			<input name ="dwelling_use" type ="radio" value="secondary_dwelling" <?php if($disaster_row['dwelling_use']=="secondary_dwelling"){ echo('checked="checked"'); } ?> />
			Secondary Dwelling
		</span>
		<span class ="left" style="width:200px">
			<input name ="dwelling_use" type ="radio" value="business" <?php if($disaster_row['dwelling_use']=="business"){ echo('checked="checked"'); } ?> />
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
			<input name ="dwelling_insurance_contents" type ="checkbox" value="1" <?php if($disaster_row['dwelling_insurance_contents']==1){ echo('checked="checked"'); } ?>/>
			Contents
		</span>
		<span class ="left" style="width:150px">
			<input name ="dwelling_insurance_hazzard" type ="checkbox" value="1" <?php if($disaster_row['dwelling_insurance_hazzard']==1){ echo('checked="checked"'); } ?>/>
			Hazzard
		</span>
		<span class ="left" style="width:150px">
			<input name ="dwelling_insurance_structure" type ="checkbox" id="1" <?php if($disaster_row['dwelling_insurance_structure']==1){ echo('checked="checked"'); } ?>/>
			Structure
		</span>
		<span class = "left" style ="width:150px">  
			<input name ="dwelling_insurance_none" type ="checkbox" id="1" <?php if($disaster_row['dwelling_insurance_none']==1){ echo('checked="checked"'); } ?>/>
			None
		</span>
	</li>

	<li>
		<span class ="left" style="width:250px">
		<label class="description" for="dwelling_insurance">Insurance Providers Name</label>
		<input name="insurance_provider_name" size ="26" maxlength="30" type ="text" class ="text" value="<?php echo($disaster_row['insurance_provider_name']); ?>"/>
		</span>
		<span class ="left" style="width:200px">
		<label class="description" for="dwelling_insurance">Insurance Providers Phone</label>
		<input id="insurance_provider_phone" name="insurance_provider_phone" size ="26" maxlength="30" type ="text" class ="text" placeholder="###-###-####" value="<?php echo($disaster_row['insurance_provider_phone']); ?>"/>
	</li>
	<div class="form_description">

			<p>&#160;</p>
		</div>
	<h1> Damage </h1>
	<br>

<li>
			<label class ="description" for ="damage_level"> Level of damage: </label>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="destroyed" title ="*PLEASE SELECT LEVEL OF DAMAGE"  <?php if($disaster_row['level_of_damage']=="destroyed"){ echo('checked="checked"'); } ?> />
				Destroyed
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="major" <?php if($disaster_row['level_of_damage']=="major"){ echo('checked="checked"'); } ?>/>
				Major
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="minor" <?php if($disaster_row['level_of_damage']=="minor"){ echo('checked="checked"'); } ?>/>
				Minor
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="affected" <?php if($disaster_row['level_of_damage']=="affected"){ echo('checked="checked"'); } ?>/>
				Affected
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="inaccessible" <?php if($disaster_row['level_of_damage']=="inaccessible"){ echo('checked="checked"'); } ?>/>
				Inaccessible
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="unknown" <?php if($disaster_row['level_of_damage']=="unknown"){ echo('checked="checked"'); } ?>/>
				Unknown
				</span>
		</li>

	<li>
			<label class ="description" for ="electricity">Is the electricity on or off at the affected location?</label>
			<span class ="left" style ="width:200px">
				<input  type ="radio" value="1" name ="elec_on_off" title = "*PLEASE LET US KNOW IF YOUR ELECTRICTY IS ON OR OFF" <?php if($disaster_row['elec_on_off']==1){ echo('checked="checked"'); } ?> />
				The electricity is ON
			</span>
			<span class ="left" style ="width:200px">
				<input  type ="radio" value="0" name ="elec_on_off" <?php if($disaster_row['elec_on_off']==0){ echo('checked="checked"'); } ?>/>
				The electricity is OFF
				</span>
			</li>

		<li>
			<label class ="description" for ="housing_needs">Do you have any housing needs due to the disaster?</label>
			<span>
				<input  type ="radio" id="housing_needs_yes" name ="housing_needs" value="1" title ="*PLEASE SELECT A HOUSING NEEDS CHOICE "  <?php if($disaster_row['housing_needs_yes']==1){ echo('checked="checked"'); } ?>  />
				<label class ="choice" for="housing_needs_yes">Yes</label>
			</span>
			<span style ="margin-left:10px">
				<input type="radio" id="housing_needs_no" name="housing_needs" value="0" <?php if($disaster_row['housing_needs_yes']==0){ echo('checked="checked"'); } ?> />
				<label class="choice" for="housing_needs_no">No</label>
				</span>
			</li>
			<li>
				<div id="hide_housing_needs">
				<label class ="description" for="housing_needs">What type of housing do you need?</label>
				<span class ="left" style="width:200px">
				<input name ="housing_need_type" type ="radio" value="Permanent" <?php if($disaster_row['housing_need_type']=="Permanent"){ echo('checked="checked"'); } ?>/>
				Permanent
				</span>
				<span class ="left" style="width:200px">
				<input name ="housing_need_type" type ="radio" value="Temporary" <?php if($disaster_row['housing_need_type']=="Temporary"){ echo('checked="checked"'); } ?>/>
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
		<li style ="width: 850px">

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
	<li style ="width: 850px">

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
	<li style ="width: 850px">

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
	<li style ="width: 850px">

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
	
		</ul>
				<ul>
					<li class="section_break"></li>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_edit_disaster">
						<input type="hidden" name="submit_disaster_id" value="<?php echo $disaster_row['disaster_id']; ?>">					
						<input type="submit" name="submitAdminVol" id="submitApproveVol" class="button_text" value="Update">
						<input type="submit" name="submitAdminVol" id="submitDeleteVol" class="button_text" value="Delete">					
						<input type='reset' name='clearEditdisaster' id='clearEditdisaster' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
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