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
	

	
	if (isset($_POST['form_id']) || isset($_GET['edit_vol'])) {
		
		$searchform = $_POST['form_id'];
		
		if ($searchform == 'submit_form_search_for_volunteer') {
			$searchforvol = 1;
			$searchfirstname = mysql_real_escape_string(trim($_POST['searchfirstname']));
			$searchlastname = mysql_real_escape_string(trim($_POST['searchlastname']));
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_volunteer, #form_edit_volunteer ').hide();
			$(' #form_search_by_volunteer ').show();
			
			$('#form_search_by_volunteer').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #editvoltable ');
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
		} else if (($searchform == 'submit_form_search_by_volunteer') || isset($_GET['edit_vol'])) {
			$searchbyvol = 1;
			
			if(isset($_GET['edit_vol']))
			{
				$searchvolid = $_GET['edit_vol'];
			} else {
				$searchvolid = $_POST['vol_id'];
			}
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_volunteer, #form_search_by_volunteer, #editvoltable ').hide();
			$(' #form_edit_volunteer ').show();
			
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
			
			$('#form_edit_volunteer').submit(function()
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
				
				$('#form_edit_volunteer').validate( {
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
	
			$(' #form_search_by_volunteer, #form_edit_volunteer ').hide();
			$(' #form_search_for_volunteer ').show();
			$(' #searchfirstname ').focus();
			
			$('#form_search_for_volunteer').submit(function()
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
		header: 'Volunteers',
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
            { field: 'reg_date', caption: 'Registration Date', type: 'date' },
		/*	**ASU2016**  Added database fields for (disaster, community) 		6/19/2016		*/
			{ field: 'disaster', caption: 'Disaster Volunteer', type: 'list', options: { items: [ 'YES', 'NO' ] } },		     
		/* **ASU2016**  End added code 6/19/2016   */  
		],
        columns: [                
            { field: 'first_name', caption: 'First Name', size: '90px', sortable: true, attr: 'align=right' },
            { field: 'last_name', caption: 'Last Name', size: '90px', sortable: true, attr: 'align=right' },
            { field: 'email_address', caption: 'Email', size: '90px', sortable: true, attr: 'align=center' },
            { field: 'home_phone', caption: 'Home Phone', size: '120px', sortable: true, attr: 'align=center' },
            { field: 'cell_phone', caption: 'Cell Phone', size: '120px', sortable: true, attr: 'align=center' },
            { field: 'reg_date', caption: 'Registration Date', size: '120px', sortable: true, searchable:'date', render:'date', attr: 'align=center' },
		/*	**ASU2016**  Added database fields for (disaster, community, and ssn) that were missing in updates		6/19/2016		*/
            { field: 'disaster', caption: 'Disaster Volunteer', size: '120px', sortable: true, attr: 'align=center' },
		/* **ASU2016**  End added code 6/19/2016   */
 ],
        onAdd: function (event) {
			location.href = 'admin_new_volunteer.php';
        },
        onEdit: function (event) {
			location.href = 'admin_vols_disaster.php?edit_vol='+event.recid;
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
			$sql = "SELECT DISTINCT vol_id, " .
				   "				reg_date, " .
				   "				first_name, " .
				   "				last_name, " .
				   "				email_address, " .
				   "				home_phone, " .
				   "				cell_phone, " .
				   "				active, " .
		/*	**ASU2016**  Added database fields for (disaster, community, date_of_birth) 	6/20/2016		*/
				   "                disaster, " .
				   "                community, " .
				   "                date_of_birth " .				   
		/* **ASU2016**  End added code 6/20/2016   */
				   "		   FROM volunteers " .
/*				   "		  WHERE " . $where .	*/
				   "		  WHERE disaster = 1 " .
				   "	   ORDER BY disaster DESC, reg_date DESC, " .
				   "	 		    last_name";
		
			$result = mysql_query($sql)
				or handle_error("an error occurred while searching for volunteers", mysql_error());
			
			$num_of_rows = mysql_num_rows($result);

		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to search for volunteers.",
				"Error searching for volunteers: " . $exc->getMessage());
		}
		
		while ($row = mysql_fetch_array($result))
		{
		/*	**ASU2016**  Added database fields for (disaster, community, date_of_birth) 	6/20/2016		*/
			$javascript .= "{ recid: ".$row['vol_id'].", reg_date: '".date("n/j/Y",strtotime($row['reg_date']))."', first_name: '".$row['first_name']."', last_name: '".$row['last_name']."', email_address: '".$row['email_address']."', home_phone: '".$row['home_phone']."', cell_phone: '".$row['cell_phone']."', disaster: '".$row['disaster']."', community: '".$row['community']."', date_of_birth: '".$row['date_of_birth'];
		/* **ASU2016**  End added code 6/20/2016   */
					
			if($row['disaster']==1)
			{
				$javascript .= "', disaster: 'YES' },";
			}
			else
			{
				$javascript .= "', disaster: 'NO' },";
			}
				
			$javascript .= "
			";
			

		}

	$javascript .= "		
        ]
    });    
});";
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminVols",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Volunteer Administration</h2>
				<p>Allows Administrators to edit a volunteer's information.<br>(NOTE: Volunteers that have not been approved by admin review, will not be listed below.)</p>
			</div>	
			
			<div id="editvoltable"></div>
			
			<center>
			<form name="form_search_for_volunteer" id="form_search_for_volunteer" method="post" style="margin:25px 10px" 
				action="admin_vols_disaster.php">
			</form>
			</center>
			
			<form name="form_search_by_volunteer" id="form_search_by_volunteer" method="post" style="margin:25px 10px" 
				action="admin_vols_disaster.php">
			</form>
			
			<form name="form_edit_volunteer" id="form_edit_volunteer" class="appnitro" method="POST" action="scripts/process_admin_volunteers.php">
				<?php
					if ($searchbyvol == 1) {
						$searchbyvol = 0;
					
						$vol_query = "SELECT * " .
								 	"  FROM volunteers " .
								 	" WHERE vol_id = " . $searchvolid;
								 
						$vol_data = mysql_query($vol_query)
						 	or handle_error("an error occurred while searching for volunteer", mysql_error());
						
					 	$vol_row = mysql_fetch_array($vol_data);
					 	
					 	try {
							$volskill_sql = "	 SELECT skill_id " .
											"	   FROM vol_skill " .
											"     WHERE vol_id = $searchvolid " .
											"  ORDER BY skill_id";
						
							$volskill_result = mysql_query($volskill_sql)
								or handle_error("an error occurred while searching for skills associated with the opportunity", mysql_error());
								
							$num_of_rows = mysql_num_rows($volskill_result);
							
							$list = "";
							while($skill = mysql_fetch_array($volskill_result)) {
								$list .= $skill[0] . ",";
							}
							$skills = rtrim($list, ",");
							$volskill = explode(',', $skills);
							
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for skills associated with the opportunity.",
								"Error searching for skills associated with the opportunity: " . $exc->getMessage());
						}
					 }
				?>
				<ul>
					<li>
						<label class="description" for="type_of_work">I am willing to volunteer for: (Please check all the apply.) </label>
						<span class="left" style="width:200px">
							<input name="disaster" class="checkbox" type="checkbox" 
								value="1" <?php if ($vol_row['disaster']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="disaster">Disaster Relief</label>
						</span>
						<span class="left" style="width:200px">
							<input name="community" class="checkbox" type="checkbox" 
								value="1" <?php if ($vol_row['community']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="community">Community Service</label>
						</span>
					</li>
					<li style="width:650px">
						<span>
							<label class="description" for="first_name">First Name</label>
							<input name="first_name" size="26" maxlength="30" type="text" value="<?php echo $vol_row['first_name']; ?>">
						</span>
						<span>
							<label class="description" for="middle_initial">M.I.</label>
							<input name="middle_initial" size="2" maxlength="2" type="text" class="center_text" value="<?php echo $vol_row['middle_initial']; ?>">
						</span>
						<span>
							<label class="description" for="last_name">Last Name</label>
							<input name="last_name" size="26" maxlength="30" type="text" value="<?php echo $vol_row['last_name']; ?>">
						</span>
						<span class="clear">
							<label class="description" for="dob">Date Of Birth</label>
							<input id="dob" name="dob" size="20" value="<?php echo date_format(date_create($vol_row['date_of_birth']),'m/d/Y'); ?>">
						</span>
						<span style="margin-left:10px" id="ssn">
							<label class="description" for="ssn">Last 4 Digits of SSN (####)</label>
							<input name="ssn" size="8" maxlength="4" type="text" value="<?php echo $vol_row['ssn']; ?>">
						</span>
						<span class="clear">
							<label class="description" for="email">Email Address</label>
							<input name="email" id="email" type="text" size="40" maxlength="40" class="text email" value="<?php echo $vol_row['email_address']; ?>"> 
						</span> 
						<span style="margin-left:10px" id="phone">
							<label class="description" for="home_phone_header">Home Phone </label>
							<input name="home_phone" id="home_phone" size="22" maxlength="15" type="text" class="text_phone_required" value="<?php echo $vol_row['home_phone']; ?>">
						</span>
						<span style="margin-left:10px" id="phone">
							<label class="description" for="cell_phone_header">Cell Phone </label>
							<input name="cell_phone" id="cell_phone" size="22" maxlength="15" type="text" class="text_phone_required" value="<?php echo $vol_row['cell_phone']; ?>">
						</span>
					</li>
					<li>
						<span>
							<label class="description" for="address">Home Address</label>
							<input name="street_address1" size="80" maxlength="30" type="text" class="text" value="<?php echo $vol_row['street_address1']; ?>">
							<label for="street_address1">Street Address (line 1)</label>
						</span>
						<span class="clear">
							<input name="street_address2" size="80" maxlength="30" type="text" class="text" value="<?php echo $vol_row['street_address2']; ?>">
							<label for="street_address2">Street Address (line 2)</label>
						</span>
						<span class="clear">
							<input name="city" size="45" maxlength="30" type="text" value="<?php echo $vol_row['city']; ?>">
							<label for="city">City</label>
						</span>
						<span>
							<input name="state" size="2" maxlength="2" type="text" value="AL" class="center_text" value="<?php echo $vol_row['state']; ?>">
							<label for="state">State</label>
						</span>
						<span>
							<input name="zip_code" size="24" maxlength="15" type="text" class="text" value="<?php echo $vol_row['zip_code']; ?>">
							<label for="zip_code">Postal &#47; Zip Code</label>
						</span>
					</li>
					<li>
						<span>
							<label class="description" for="occupation">Occupation</label>
							<input name="occupation" size="41" maxlength="255" type="text" class="text" value="<?php echo $vol_row['occupation']; ?>"> 
						</span>
						<span>
							<label class="description" for="employer">Employer </label>
							<input name="employer" size="40" maxlength="255" type="text" class="text" value="<?php echo $vol_row['employer']; ?>"> 
						</span> 
					</li>
					<li>
						<label class="description" for="health">Do you have any Health Limitations? </label>
						<span>
							<input type="radio" id="health_limits_yes" name="health_limits" value=1 <?php if ($vol_row['health_limits']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="health_limits_yes">Yes </label>
						</span>
						<span style="margin-left:10px">
							<input type="radio" id="health_limits_no" name="health_limits" value=0 <?php if ($vol_row['health_limits']==0) {echo 'checked="checked"';} ?>>
							<label class="choice" for="health_limits_no">No</label>
						</span> 
					</li>
					<li>
						<div id="hide_health_comment">
							<label class="description" for="health_limits_comment">Please explain your health limitations here: </label>
							<span>
								<textarea id="health_limits_comment" name="health_limits_comment" rows="4"
									cols="70" maxlength="250"><?php echo $vol_row['health_limits_comment']; ?></textarea> 
							</span>
						</div>
					</li>
					<li>
						<label class="description" for="affiliation">Are you currently affiliated 
							with any disaster relief organizations? </label>
						<span>
							<input type="radio" id="affiliated_yes" name="affiliated" value=1 <?php if ($vol_row['affiliated']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="affiliated_yes">Yes </label>
						</span>
						<span style="margin-left:10px">
							<input type="radio" id="affiliated_no" name="affiliated" value=0 <?php if ($vol_row['affiliated']==0) {echo 'checked="checked"';} ?>>
							<label class="choice" for="affiliated_no">No</label>
						</span> 
					</li>
					<li>
						<div id="hide_affiliated_comment">
							<label class="description" for="affiliated_comment">Please explain your affiliations here: </label>
							<span>
								<textarea id="affiliated_comment" name="affiliated_comment" rows="4"
									cols="70" maxlength="250"><?php echo $vol_row['affiliated_comment']; ?></textarea> 
							</span>
						</div>
					</li>	
					<li>
						<label class="description" for="location">I am willing to volunteer in: </label>
						<span class="left" style="width:200px">
							<input name="limestone" class="checkbox" type="checkbox" 
								value="1" <?php if ($vol_row['location_limestone_county']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="limestone">Limestone County</label>
						</span>
						<span class="left" style="width:200px">
							<input name="neighbor" class="checkbox" type="checkbox" 
								value="1" <?php if ($vol_row['location_neighbor_county']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="neighbor">Neighboring Counties</label>
						</span>
						<span class="left" style="width:200px">
							<input name="anywhere" class="checkbox" type="checkbox" 
								value="1" <?php if ($vol_row['affiliated']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="anywhere">Anywhere in Alabama</label>
						</span>
					</li>
				</ul>
				<ul>
					<li class="section_break">
						<h3>Emergency Contact:</h3>
						<p>&#160;</p>
						<center>
							<table align="center">
								<tr>
									<td>
										<span>
											<label class="description" for="emer_first_name">First Name</label>
											<input name="emer_first_name" size="26" maxlength="30" 
												type="text" value="<?php echo $vol_row['emer_con_first_name']; ?>">
										</span>
										<span style="margin-left:5px">
											<label class="description" for="emer_last_name">Last Name</label>
											<input name="emer_last_name" size="26" maxlength="30" 
												type="text" value="<?php echo $vol_row['emer_con_last_name']; ?>">
										</span>
									</td>
								</tr>
								<tr>
									<td>
										<span>
											<label class="description" for="emer_relationship">Relationship</label>
											<input name="emer_relationship" 
												type="text" size="26" maxlength="30" value="<?php echo $vol_row['emer_con_relationship']; ?>"> 
										</span>
										<span style="margin-left:5px">
											<label class="description" for="emerg_phone_header">Emergency Contact Phone</label>
											<input name="emer_phone" id="emer_phone" size="26" maxlength="15" type="text" 
											value="<?php echo $vol_row['emer_con_phone']; ?>">	
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
									<?php populate_skills($volskill); ?>
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
							<input type="radio" id="special_skills_yes" name="special_skills" 
								value=1 <?php if ($vol_row['special_skills']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="special_skills_yes">Yes </label>
						</span>
						<span style="margin-left:10px">
							<input type="radio" id="special_skills_no" name="special_skills" 
								value=0 <?php if ($vol_row['special_skills']==0) {echo 'checked="checked"';} ?>>
							<label class="choice" for="special_skills_no">No</label>
						</span> 
					</li>
					<li>
						<div id="hide_special_skills_comment">
							<label class="description" for="special_skills_comment">Please list and/or explain them here.</label>
							<span>
								<textarea id="special_skills_comment" name="special_skills_comment" 
									rows="4" cols="60" maxlength="250"><?php echo $vol_row['special_skills_comment']; ?></textarea> 
							</span>
						</div> 
					</li>
				</ul>
				<div>
		 			<p><br></p>
		 		</div>
				<div id="activeinactive" align="center">
					<input type="radio" name="active_inactive" id="active" value="1" title="&nbsp;Active&nbsp;" <?php if($vol_row['active'] == 1) {echo 'checked';} ?>>
						<label for="active">&nbsp;Active&nbsp;</label></input>
					<input type="radio" name="active_inactive" id="inactive" value="0" title="Inactive" <?php if($vol_row['active'] == 0) {echo 'checked';} ?>>
						<label for="inactive">Inactive</label></input>
				</div>
				<ul>
					<li class="section_break"></li>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_edit_volunteer">
						<input type="hidden" name="submit_vol_id" value="<?php echo $vol_row['vol_id']; ?>">					
						<input type="submit" name="submitAdminVol" id="submitApproveVol" class="button_text" value="Update">
						<input type="submit" name="submitAdminVol" id="submitDeleteVol" class="button_text" value="Delete">					
						<input type='reset' name='clearEditVolunteer' id='clearEditVolunteer' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
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