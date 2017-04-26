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
	// Current user groups are Administrators, damages, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	authorize_user(array("Administrators"));
	

	
	if (isset($_POST['form_id']) || isset($_GET['edit_damage'])) {
		
		$searchform = $_POST['form_id'];
		
		if ($searchform == 'submit_form_search_for_damage') {
			$searchforvol = 1;
			$searchfirstname = mysql_real_escape_string(trim($_POST['searchfirstname']));
			$searchlastname = mysql_real_escape_string(trim($_POST['searchlastname']));
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_damage, #form_edit_damage ').hide();
			$(' #form_search_by_damage ').show();
			
			$('#form_search_by_damage').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #editvoltable ');
					} else {
						error.insertAfter(element);
					}
				},
				messages: {
					damage_id: {
						required: "<br>Select a row to edit."
					}
				}
			});
		});
EOD;
		} else if (($searchform == 'submit_form_search_by_damage') || isset($_GET['edit_damage'])) {
			$searchbyvol = 1;
			
			if(isset($_GET['edit_damage']))
			{
				$searchvolid = $_GET['edit_damage'];
			} else {
				$searchvolid = $_POST['damage_id'];
			}
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_damage, #form_search_by_damage, #editvoltable ').hide();
			$(' #form_edit_damage ').show();
			
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
			
			$('#form_edit_damage').submit(function()
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
				
				$('#form_edit_damage').validate( {
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
	
			$(' #form_search_by_damage, #form_edit_damage ').hide();
			$(' #form_search_for_damage ').show();
			$(' #searchfirstname ').focus();
			
			$('#form_search_for_damage').submit(function()
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
		header: 'Damages',
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
			location.href = 'admin_new_damage.php';
        },
        onEdit: function (event) {
			location.href = 'admin_damage.php?edit_damage='+event.recid;
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
			$sql = "SELECT DISTINCT damage_id, " .
				   "				first_name, " .
				   "				last_name, " .
				   "				email, " .
				   "				home_phone, " .
				   "				cell_phone " .
				   "		   FROM damage " .
				   "		  WHERE " . $where .
				   "	   ORDER BY first_name, " .
				   "	 		    last_name";
		
			$result = mysql_query($sql)
				or handle_error("an error occurred while searching for damages", mysql_error());
			
			$num_of_rows = mysql_num_rows($result);

		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to search for damages.",
				"Error searching for damages: " . $exc->getMessage());
		}
		
		while ($row = mysql_fetch_array($result))
		{
			$javascript .= "{ recid: ".$row['damage_id'].", first_name: '".$row['first_name']."', last_name: '".$row['last_name']."', email_address: '".$row['email']."', home_phone: '".$row['home_phone']."', cell_phone: '".$row['cell_phone']."' },
			";
		}

$javascript .= "		
        ]
    });    
});";
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminDamage",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Damage Administration</h2>
				<p>Allows Administrators to edit a damage's information.<br>(NOTE: damages that have not been approved by admin review, will not be listed below.)</p>
			</div>	
			
			<div id="editvoltable"></div>
			
			<center>
			<form name="form_search_for_damage" id="form_search_for_damage" method="post" style="margin:25px 10px" 
				action="admin_damage.php">
			</form>
			</center>
			
			<form name="form_search_by_damage" id="form_search_by_damage" method="post" style="margin:25px 10px" 
				action="admin_damage.php">
			</form>
			
			<form name="form_edit_damage" id="form_edit_damage" class="appnitro" method="POST" action="scripts/process_admin_damage.php">
				<?php
					if ($searchbyvol == 1) {
						$searchbyvol = 0;
					
						$damage_query = "SELECT * " .
								 	"  FROM damage " .
								 	" WHERE damage_id = " . $searchvolid;
								 
						$damage_data = mysql_query($damage_query)
						 	or handle_error("an error occurred while searching for damage", mysql_error());
						
					 	$damage_row = mysql_fetch_array($damage_data);

						}
				?>
				<ul>
					<li style="width:650px">
		<h3>Primary Client or Household Representative</h3><br>
		
		<ul>
	<li style ="width: 1000px">
		<span>
			<label class="description" for="first_name">First Name</label>
			<input name="first_name" size ="26" maxlength="30" type ="text" class ="text required" value="<?php echo($damage_row['first_name']); ?>"/>
		</span>
		<span>
			<label class ="description" for ="middle_initial">M.I.</label>
			<input name="middle_initial" size ="1" maxlength="1" type ="text" class ="center_text" value="<?php echo($damage_row['middle_initial']); ?>"/>
		</span>
		<span>
			<label class ="description" for ="last_name"> Last Name</label>
			<input name ="last_name" size="26" maxlength ="30" type ="text" class= "text required" value="<?php echo($damage_row['last_name']); ?>"/>
			</span>
		<span style = "margin-left:10px">
			<label class = "description" for ="dob"> Date Of Birth </label>
			<input type="date" id ="dob" name ="dob" class ="text required" value="<?php echo($damage_row['date_of_birth']); ?>" />
		</span>
		<span class = "clear">
			<label class ="description" for ="email"> Email Address</label>
			<input name="email" id = "email" type ="email" size ="40" maxlength ="100" class ="text email" placeholder="email@address.com" value="<?php echo($damage_row['email']); ?>" />
		</span>
		<span style ="margin-left:10px" id="phone">
			<label class="description" for="home_phone_header">Home Phone </label>
			<input name ="home_phone" id="home_phone" size="15" maxlength="15" type ="text" class="text_phone" placeholder="###-###-####" value="<?php echo($damage_row['home_phone']); ?>"/>
		</span>
		<span style ="margin-left:10px">
			<label class ="description" for ="cell_phone_header">Cell Phone </label>
			<input name ="cell_phone" id="cell_phone" size="15" maxlength="15" type ="text" class="text_phone" placeholder="###-###-####" value="<?php echo($damage_row['cell_phone']); ?>"/>
		</span>

	</li>
          <p>&nbsp;</p> 
        <h3>Location of Damaged Area</h3><br /> 
        <li> <span> 
            <label for="address" class="description"> Address of Damaged Area</label> <input maxlength="30" size="80" name="add_st1" class="text required" type="text" value="<?php echo($damage_row['add_st1']); ?>" /> 
            <label for="add_st2"> Street Address (line 1)</label> </span> <span class="clear"> <input maxlength="30" size="80" name="add_st2" class="text " type="text" value="<?php echo($damage_row['add_st2']); ?>" /> 
            <label for="add_st2">Street Address (line 2) </label> </span> <span class="clear"> <input maxlength="30" size="25" name="add_city" class="text" type="text" value="<?php echo($damage_row['add_city']); ?>" /> 
            <label for="add_city"> City </label> </span> <span> <input maxlength="2" size="2" name="add_state" class="center_text" type="text" value="AL" value="<?php echo($damage_row['add_state']); ?>" /> 
            <label for="add_state">State</label> </span> <span> <input maxlength="15" size="5" name="add_zip" class="text" type="text" placeholder="#####" value="<?php echo($damage_row['add_zip']); ?>" /> 
            <label for="add_zip"> Postal/ Zip Code </label> </span> </li> 
        <div class="form_description"> 
          <p>&nbsp;</p> 
        </div> 
		<li>
			<label class ="description" for ="health">Do you have any health limitations?</label>
			
			<span>
				<input  type ="radio" id ="health_limits_yes" name ="health_limits" value ="1" title ="*PLEASE SELECT A HEALTH OPTION"   <?php if($damage_row['health_limitation']==1){ echo('checked="checked"'); } ?> />
				<label class ="choice "  for ="health_limits_yes">Yes</label>
			</span>
			<span style ="margin-left:10px">
				<input type="radio" id="health_limits_no" name="health_limits"   value ="0"    <?php if($damage_row['health_limitation']==0){ echo('checked="checked"'); } ?>/>
				<label class="choice " for="health_limits_no" >No</label>
				</span>
				
			</li>



			<li>
				<div id="hide_health_comment">
					<label class ="description" for="health_limits_comment">Please explain your health limitations here:</label>

							<span>
								<textarea id ="health_limits_comment" name ="health_limits_comment" rows ="4" cols ="80"
								maxlength ="250"> <?php echo($damage_row['post_add_zip']); ?></textarea>
							</span>
				</div>
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
						<input name ="dwelling" type ="radio"  value="single_family" title ="*PLEASE SELECT A DWELLING TYPE"  <?php if($damage_row['dwelling']=="single_family"){ echo('checked="checked"'); } ?>/>
						Single Family
					</span>
					<span class ="left" style ="width:200px">
						<input name ="dwelling" type ="radio" value="Apt/Condo"  <?php if($damage_row['dwelling']=="Apt/Condo"){ echo('checked="checked"'); } ?>/>
						 Apartment/Condo
					</span>
					<span class ="left" style ="width:200px">
						<input name ="dwelling" type ="radio" value="mobile_home"  <?php if($damage_row['dwelling']=="mobile_home"){ echo('checked="checked"'); } ?>/>
						 Mobile Home
					</span>
		</li>
		<br>

	<li>
			<label class ="description" for ="owner_renter_info">Are you an owner or renter?</label>
			<span>
				<input  type ="radio" name="owner_renter_info" value="owner" <?php if($damage_row['owner_renter_info']=="owner"){ echo('checked="checked"'); } ?>  />
				<label class ="choice" for ="owner">Owner</label>
			</span>
			<span style ="margin-left:10px">
				<input type="radio" value="renter" name="owner_renter_info" <?php if($damage_row['owner_renter_info']=="renter"){ echo('checked="checked"'); } ?> />
				<label class="choice" for="renter">Renter</label>
				</span>
			</li>


<li>
			<label class ="description" for ="damage_level"> Level of damage: </label>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="destroyed" title ="*PLEASE SELECT LEVEL OF DAMAGE"  <?php if($damage_row['level_of_damage']=="destroyed"){ echo('checked="checked"'); } ?> />
				Destroyed
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="major" <?php if($damage_row['level_of_damage']=="major"){ echo('checked="checked"'); } ?>/>
				Major
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="minor" <?php if($damage_row['level_of_damage']=="minor"){ echo('checked="checked"'); } ?>/>
				Minor
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="affected" <?php if($damage_row['level_of_damage']=="affected"){ echo('checked="checked"'); } ?>/>
				Affected
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="inaccessible" <?php if($damage_row['level_of_damage']=="inaccessible"){ echo('checked="checked"'); } ?>/>
				Inaccessible
				</span>
				<span class ="left" style ="width:200px">
				<input name ="levofdamage" type ="radio" value ="unknown" <?php if($damage_row['level_of_damage']=="unknown"){ echo('checked="checked"'); } ?>/>
				Unknown
				</span>
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
						<input type="hidden" name="form_id" value="submit_form_edit_damage">
						<input type="hidden" name="submit_damage_id" value="<?php echo $damage_row['damage_id']; ?>">					
						<input type="submit" name="submitAdminVol" id="submitApproveVol" class="button_text" value="Update">
						<input type="submit" name="submitAdminVol" id="submitDeleteVol" class="button_text" value="Delete">					
						<input type='reset' name='clearEditdamage' id='clearEditdamage' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
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