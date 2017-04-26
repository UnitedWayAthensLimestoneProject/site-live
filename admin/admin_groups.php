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
	
	if (isset($_POST['form_id']) || isset($_GET['edit_grp'])) {
		
		$searchform = $_POST['form_id'];
		
		if ($searchform == 'submit_form_search_for_group') {
			$searchforgrp = 1;
			$searchgroupname = mysql_real_escape_string(trim($_POST['searchgroupname']));
			$searchcontact = mysql_real_escape_string(trim($_POST['searchcontact']));
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_group, #form_edit_group ').hide();
			$(' #form_search_by_group ').show();
			
			$('#form_search_by_group').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #editgrptable ');
					} else {
						error.insertAfter(element);
					}
				},
				messages: {
					grp_id: {
						required: "<br>Select a row to edit."
					}
				}
			});
		});
EOD;
		} else if (($searchform == 'submit_form_search_by_group') || isset($_GET['edit_grp'])) {
			$searchbygrp = 1;
			
			if(isset($_POST['grp_id']))
			{
				$searchgrpid = $_POST['grp_id'];
			} else {
				$searchgrpid = $_GET['edit_grp'];
			}
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_group, #form_search_by_group, #editgrptable ').hide();
			$(' #form_edit_group ').show();
			
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
			
			$( '#phone_num' ).mask('(999) 999-9999');
			$( '#cell_phone' ).mask('(999) 999-9999');
			$( '#emer_phone' ).mask('(999) 999-9999');
			
			$('#form_edit_group').submit(function()
				{
					//This part makes a phone number be mandatory field
					/*
					if( $('#phone_num').val() == "" && $('#cell_phone').val() == "")
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
				
				$('#form_edit_group').validate( {
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
	
			$(' #form_search_by_group, #form_edit_group ').hide();
			$(' #form_search_for_group ').show();
			$(' #searchgroupname ').focus();
			
			$('#form_search_for_group').submit(function()
				{
					return true;
					if( $('#searchgroupname').val() == "" && $('#searchcontact').val() == "")
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
    $('#editgrptable').w2grid({ 
        name: 'grid', 
		header: 'Groups',
        show: { 
            toolbar: true,
            footer: true,
			header: true,
            toolbarEdit: true,
            toolbarAdd: true
       },
        searches: [                
            { field: 'group_name', caption: 'First Name', type: 'text' },
            { field: 'contact', caption: 'Last Name', type: 'text' },
            { field: 'email_address', caption: 'Email', type: 'text' },
            { field: 'phone_num', caption: 'Main Phone', type: 'text' },
            { field: 'cell_phone', caption: 'Cell Phone', type: 'text' },
        ],
        columns: [                
            { field: 'group_name', caption: 'Group Name', size: '40%', sortable: true, attr: 'align=right' },
            { field: 'contact', caption: 'Contact', size: '30%', sortable: true, attr: 'align=center' },
            { field: 'email_address', caption: 'Email', size: '30%', sortable: true, attr: 'align=center' },
            { field: 'phone_num', caption: 'Main Phone', size: '100px', sortable: true, attr: 'align=center' },
            { field: 'cell_phone', caption: 'Cell Phone', size: '100px', sortable: true, attr: 'align=center' },
         ],
        onAdd: function (event) {
 			location.href = 'admin_new_group.php';
       },
        onEdit: function (event) {
			location.href = 'admin_groups.php?edit_grp='+event.recid;
        },
        onDelete: function (event) {
            console.log('delete has default behaviour');
        },
        onSave: function (event) {
            w2alert('save');
        },
        records: [
		";
		
		if ($searchgroupname != "" && $searchcontact != "") {
			$where = "group_name LIKE '$searchgroupname%' " .
					 "AND contact LIKE '$searchcontact%' " .
					 "AND admin_review = 1";
		} else if ($searchgroupname != "") {
			$where = "group_name LIKE '$searchgroupname%' " .
					 "AND admin_review = 1";
		} else if ($searchgroupname != "") {
			$where = "contact LIKE '$searchcontact%' " .
					 "AND admin_review = 1";
		} else {
			$where = "admin_review = 1";
		}
		
		try {
			$sql = "SELECT DISTINCT grp_id, " .
				   "				group_name, " .
				   "				contact, " .
				   "				email_address, " .
				   "				phone_num, " .
				   "				cell_phone " .
				   "		   FROM grp_t " .
				   "		  WHERE " . $where .
				   "	   ORDER BY group_name, " .
				   "	 		    contact";
		
			$result = mysql_query($sql)
				or handle_error("an error occurred while searching for groups", mysql_error());
			
			$num_of_rows = mysql_num_rows($result);

		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to search for groups.",
				"Error searching for groups: " . $exc->getMessage());
		}
		
		while ($row = mysql_fetch_array($result))
		{
			$javascript .= "{ recid: ".$row['grp_id'].", group_name: '".$row['group_name']."', contact: '".$row['contact']."', email_address: '".$row['email_address']."', phone_num: '".$row['phone_num']."', cell_phone: '".$row['cell_phone']."' },
			";
		}

$javascript .= "		
        ]
    });    
});";
	}
	

	
	
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminGroups",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Group Administration</h2>
				<p>Allows Administrators to edit a Group's information.<br>(NOTE: Groups that have not been approved by admin review, will not be listed below.)</p>
			</div>	
			
			<center>
			<div id="editgrptable"></div>
			</center>
						
			<form name="form_edit_group" id="form_edit_group" class="appnitro" method="POST" action="scripts/process_admin_groups.php">
				<?php
					if ($searchbygrp == 1) {
						$searchbygrp = 0;
					
						$grp_query = "SELECT * " .
								 	"  FROM grp_t " .
								 	" WHERE grp_id = " . $searchgrpid;
								 
						$grp_data = mysql_query($grp_query)
						 	or handle_error("an error occurred while searching for group", mysql_error());
						
					 	$grp_row = mysql_fetch_array($grp_data);
					 	
					 	try {
							$grpskill_sql = "	 SELECT skill_id " .
											"	   FROM group_skill " .
											"     WHERE grp_id = $searchgrpid " .
											"  ORDER BY skill_id";
						
							$grpskill_result = mysql_query($grpskill_sql)
								or handle_error("an error occurred while searching for skills associated with the opportunity", mysql_error());
								
							$num_of_rows = mysql_num_rows($grpskill_result);
							
							$list = "";
							while($skill = mysql_fetch_array($grpskill_result)) {
								$list .= $skill[0] . ",";
							}
							$skills = rtrim($list, ",");
							$grpskill = explode(',', $skills);
							
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for skills associated with the opportunity.",
								"Error searching for skills associated with the opportunity: " . $exc->getMessage());
						}
					 }
				?>
				<ul>
					<li>
						<label class="description" for="type_of_work">The group is willing to volunteer for: (Please check all the apply.)</label>
						<span class="left" style="width:200px">
							<input name="disaster" class="checkbox" type="checkbox" 
								value="1" <?php if ($grp_row['disaster']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="disaster">Disaster Relief</label>
						</span>
						<span class="left" style="width:200px">
							<input name="community" class="checkbox" type="checkbox" 
								value="1" <?php if ($grp_row['community']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="community">Community Service</label>
						</span>
					</li>
					<li style="width:650px">
						<span>
							<label class="description" for="first_name">Group Name</label>
							<input name="group_name" size="26" maxlength="30" type="text" value="<?php echo $grp_row['group_name']; ?>">
						</span>
						<span>
							<label class="description" for="contact">Point of Contact</label>
							<input name="contact" size="26" maxlength="30" type="text" value="<?php echo $grp_row['contact']; ?>">
						</span>
						<span class="clear">
							<label class="description" for="dob">Date Of Birth</label>
							<input id="dob" name="dob" size="20" value="<?php echo date_format(date_create($grp_row['date_of_birth']),'m/d/Y'); ?>">
						</span>
						<span class="clear">
							<label class="description" for="email">Email Address</label>
							<input name="email" id="email" type="text" size="40" maxlength="40" class="text email" value="<?php echo $grp_row['email_address']; ?>"> 
						</span> 
						<span style="margin-left:10px" id="phone">
							<label class="description" for="phone_num_header">Phone </label>
							<input name="phone_num" id="phone_num" size="22" maxlength="15" type="text" class="text_phone_required" value="<?php echo $grp_row['phone_num']; ?>">
						</span>
						<span style="margin-left:10px" id="phone">
							<label class="description" for="cell_phone_header">Cell Phone </label>
							<input name="cell_phone" id="cell_phone" size="22" maxlength="15" type="text" class="text_phone_required" value="<?php echo $grp_row['cell_phone']; ?>">
						</span>
					</li>
					<li>
						<span>
							<label class="description" for="address">Mailing Address</label>
							<input name="street_address" size="80" maxlength="30" type="text" class="text" value="<?php echo $grp_row['street_address']; ?>">
							<label for="street_address">Street Address</label>
						</span>
						<span class="clear">
							<input name="city" size="45" maxlength="30" type="text" value="<?php echo $grp_row['city']; ?>">
							<label for="city">City</label>
						</span>
						<span>
							<input name="state" size="2" maxlength="2" type="text" value="AL" class="center_text" value="<?php echo $grp_row['state']; ?>">
							<label for="state">State</label>
						</span>
						<span>
							<input name="zip_code" size="24" maxlength="15" type="text" class="text" value="<?php echo $grp_row['zip_code']; ?>">
							<label for="zip_code">Postal &#47; Zip Code</label>
						</span>
					</li>
					<li>
						<label class="description" for="health">Do you have any Health Limitations? </label>
						<span>
							<input type="radio" id="health_limits_yes" name="health_limits" value=1 <?php if ($grp_row['health_limits']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="health_limits_yes">Yes </label>
						</span>
						<span style="margin-left:10px">
							<input type="radio" id="health_limits_no" name="health_limits" value=0 <?php if ($grp_row['health_limits']==0) {echo 'checked="checked"';} ?>>
							<label class="choice" for="health_limits_no">No</label>
						</span> 
					</li>
					<li>
						<div id="hide_health_comment">
							<label class="description" for="health_limits_comment">Please explain your health limitations here: </label>
							<span>
								<textarea id="health_limits_comment" name="health_limits_comment" rows="4"
									cols="70" maxlength="250"><?php echo $grp_row['health_limits_comment']; ?></textarea> 
							</span>
						</div>
					</li>
					<li>
						<label class="description" for="affiliation">Are you currently affiliated 
							with any disaster relief organizations? </label>
						<span>
							<input type="radio" id="affiliated_yes" name="affiliated" value=1 <?php if ($grp_row['affiliated']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="affiliated_yes">Yes </label>
						</span>
						<span style="margin-left:10px">
							<input type="radio" id="affiliated_no" name="affiliated" value=0 <?php if ($grp_row['affiliated']==0) {echo 'checked="checked"';} ?>>
							<label class="choice" for="affiliated_no">No</label>
						</span> 
					</li>
					<li>
						<div id="hide_affiliated_comment">
							<label class="description" for="affiliated_comment">Please explain your affiliations here: </label>
							<span>
								<textarea id="affiliated_comment" name="affiliated_comment" rows="4"
									cols="70" maxlength="250"><?php echo $grp_row['affiliated_comment']; ?></textarea> 
							</span>
						</div>
					</li>	
					<li>
						<label class="description" for="location">We are willing to volunteer in: </label>
						<span class="left" style="width:200px">
							<input name="limestone" class="checkbox" type="checkbox" 
								value="1" <?php if ($grp_row['location_limestone_county']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="limestone">Limestone County</label>
						</span>
						<span class="left" style="width:200px">
							<input name="neighbor" class="checkbox" type="checkbox" 
								value="1" <?php if ($grp_row['location_neighbor_county']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="neighbor">Neighboring Counties</label>
						</span>
						<span class="left" style="width:200px">
							<input name="anywhere" class="checkbox" type="checkbox" 
								value="1" <?php if ($grp_row['affiliated']==1) {echo 'checked="checked"';} ?>>
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
												type="text" value="<?php echo $grp_row['emer_con_first_name']; ?>">
										</span>
										<span style="margin-left:5px">
											<label class="description" for="emer_last_name">Last Name</label>
											<input name="emer_last_name" size="26" maxlength="30" 
												type="text" value="<?php echo $grp_row['emer_con_last_name']; ?>">
										</span>
									</td>
								</tr>
								<tr>
									<td>
										<span>
											<label class="description" for="emer_email">Email</label>
											<input name="emer_email" 
												type="text" size="26" maxlength="30" value="<?php echo $grp_row['emer_con_email']; ?>"> 
										</span>
										<span style="margin-left:5px">
											<label class="description" for="emerg_phone_header">Emergency Contact Phone</label>
											<input name="emer_phone" id="emer_phone" size="26" maxlength="15" type="text" 
											value="<?php echo $grp_row['emer_con_phone']; ?>">	
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
									<?php populate_skills($grpskill); ?>
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
								value=1 <?php if ($grp_row['special_skills']==1) {echo 'checked="checked"';} ?>>
							<label class="choice" for="special_skills_yes">Yes </label>
						</span>
						<span style="margin-left:10px">
							<input type="radio" id="special_skills_no" name="special_skills" 
								value=0 <?php if ($grp_row['special_skills']==0) {echo 'checked="checked"';} ?>>
							<label class="choice" for="special_skills_no">No</label>
						</span> 
					</li>
					<li>
						<div id="hide_special_skills_comment">
							<label class="description" for="special_skills_comment">Please list and/or explain them here.</label>
							<span>
								<textarea id="special_skills_comment" name="special_skills_comment" 
									rows="4" cols="60" maxlength="250"><?php echo $grp_row['special_skills_comment']; ?></textarea> 
							</span>
						</div> 
					</li>
				</ul>
				<div>
		 			<p><br></p>
		 		</div>
				<div id="activeinactive" align="center">
					<input type="radio" name="active_inactive" id="active" value="1" title="&nbsp;Active&nbsp;" <?php if($grp_row['active'] == 1) {echo 'checked';} ?>>
						<label for="active">&nbsp;Active&nbsp;</label></input>
					<input type="radio" name="active_inactive" id="inactive" value="0" title="Inactive" <?php if($grp_row['active'] == 0) {echo 'checked';} ?>>
						<label for="inactive">Inactive</label></input>
				</div>
				<ul>
					<li class="section_break"></li>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_edit_group">
						<input type="hidden" name="submit_grp_id" value="<?php echo $grp_row['grp_id']; ?>">					
						<input type="submit" name="submitAdminGrp" id="submitApproveGrp" class="button_text" value="Update">
						<input type="submit" name="submitAdminGrp" id="submitDeleteGrp" class="button_text" value="Delete">					
						<input type='reset' name='clearEditGroup' id='clearEditGroup' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
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