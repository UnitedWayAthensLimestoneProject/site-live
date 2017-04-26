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
		
		if ($searchform == 'submit_form_list_groups') {
			$searchforgrp = 1;
			$searchgrpid = $_POST['grp_id'];
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_list_groups ').hide();
			$(' #form_process_group ').show();
			
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
			
			$('#form_process_group').submit(function()
			{
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
				else
				{
					return true;
				}
			});
				
				
			$('#form_process_group').validate( {
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
					$( "#email" ).focus();
				}
			});
	    });
EOD;
		}
	} else {
	
		$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_process_group ').hide();
			$(' #form_list_groups ').show();
		
			$('#form_list_groups').validate( {
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
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminReviewGroups",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
	
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Admin Review of New Group Applications</h2>
				<p>Allows Administrators to review a group&#8217;s information prior to being<br>
					available in search results.  Also allows for deletion of invalid groups.</p>
			</div>	
			
			<form name="form_list_groups" id="form_list_groups" method="post" style="margin:25px 10px" 
				action="admin_reviews_groups.php">
				<?php
					
					try {
						$count_grp_sql = "SELECT grp_id " .
									 "  FROM grp_t " .
									 " WHERE admin_review = 0";
									 
						$count_grp_result = mysql_query($count_grp_sql)
							or handle_error("an error occurred while searching for groups requiring an admin review", mysql_error());
						
						$count_grp_records = mysql_num_rows($count_grp_result);
						
					} catch (Exception $exc) {
						handle_error("something went wrong while attempting to search for groups that require an admin review.",
							"Error searching for groups that require an admin review: " . $exc->getMessage());
					}
					
					if ($count_grp_records > 0) {
						
						$disabled = "";
						
						try {
							$sql = "SELECT DISTINCT grp_id, " .
								   "				group_name, " .
								   "				contact, " .
								   "				email_address, " .
								   "				phone_num, " .
								   "				cell_phone " .
								   "		   FROM grp_t " .
								   "		  WHERE admin_review = 0 " .
								   "	   ORDER BY group_name, " .
								   "	 		    contact ";
						
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for groups", mysql_error());
				
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for groups.",
								"Error searching for groups: " . $exc->getMessage());
						}
						
						echo "				<center>";
						echo "				<table class='editgrptable' id='editgrptable' width='90%'>";
						echo "					<th style='width:4px'></th>";
						echo "					<th>Group Name</th>";
						echo "					<th>Point of Contact</th>";
						echo "					<th>Email</th>";
						echo "					<th>Phone</th>";
						echo "					<th>Cell Phone</th>";

						while ($row = mysql_fetch_array($result))
						{
							echo "					<tr>";
							echo "						<td style='width:4px'><input type='radio' name='grp_id' id='grp_id' class='required' value='" . $row['grp_id'] . "'</td>";
							echo "						<td>" . $row['group_name'] . "</td>";
							echo "						<td>" . $row['contact'] . "</td>";
							echo "						<td>" . $row['email_address'] . "</td>";
							echo "						<td>" . $row['phone_num'] . "</td>";
							echo "						<td>" . $row['cell_phone'] . "</td>";
							echo "					</tr>";
						}
						echo "				</table>";
						echo "				</center>";
						
						echo "				<ul>";
						echo "					<li class='buttons'>";
						echo "						<input type='hidden' name='form_id' value='submit_form_list_groups'>";
						echo "						<input type='submit' name='submitListGroups' id='submitListGroups' class='button_text' value='View Group Info' " . $disabled . ">";
						echo "					</li>";
						echo "				</ul>";
					
					} else {
						echo "				<br><h3 align='center' style='color:#FF0000'>There are no Groups requiring an admin review.</h3><br>";
						$disabled = "disabled";
					}	
				?>
			</form>
			
<form name="form_process_group" id="form_process_group" class="appnitro" method="POST" action="scripts/process_admin_groups_reviews.php">
				<?php
					if ($searchforgrp == 1) {
						$searchforgrp = 0;
					
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
					<li style="width:650px">
						<li>
							<label class="description" for="type_of_work">The group is willing to volunteer for: (Please check all the apply. </label>
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
						<span class="clear">
							<label class="description" for="group_name">Group Name</label>
							<input name="group_name" size="26" maxlength="30" type="text" class="text required" value="<?php echo $grp_row['group_name']; ?>">
						</span>
						<span>
							<label class="description" for="contact">Point of Contact</label>
							<input name="contact" size="26" maxlength="30" type="text" class="text required" value="<?php echo $grp_row['contact']; ?>">
						</span>
						<span style="margin-left:10px">
							<label class="description" for="dob">Date Of Birth</label>
							<input id="dob" name="dob" class="text required" size="20" value="<?php echo date_format(date_create($grp_row['date_of_birth']),'m/d/Y'); ?>">
						</span>
						<span class="clear">
							<label class="description" for="email">Email Address</label>
							<input name="email" id="email" type="text" size="40" maxlength="40" class="text email" value="<?php echo $grp_row['email_address']; ?>"> 
						</span> 
						<span style="margin-left:10px" id="phone">
							<label class="description" for="phone_num_header">Phone </label>
							<input name="phone_num" id="phone_num" size="22" maxlength="15" type="text" class="text_phone" value="<?php echo $grp_row['phone_num']; ?>">
						</span>
						<span style="margin-left:10px" id="phone">
							<label class="description" for="cell_phone_header">Cell Phone </label>
							<input name="cell_phone" id="cell_phone" size="22" maxlength="15" type="text" class="text_phone" value="<?php echo $grp_row['cell_phone']; ?>">
						</span>
					</li>
					<li>
						<span>
							<label class="description" for="address">Mailing Address</label>
							<input name="street_address" size="87" maxlength="30" type="text" class="text" value="<?php echo $grp_row['street_address']; ?>">
							<label for="street_address">Street Address (line 1)</label>
						</span>
						<span class="clear">
							<input name="city" size="45" maxlength="30" type="text" class="text required" value="<?php echo $grp_row['city']; ?>">
							<label for="city">City</label>
						</span>
						<span>
							<input name="state" size="2" maxlength="2" type="text" value="AL" class="center_text required" value="<?php echo $grp_row['state']; ?>">
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
												type="text" class="text required" value="<?php echo $grp_row['emer_con_first_name']; ?>">
										</span>
										<span style="margin-left:5px">
											<label class="description" for="emer_last_name">Last Name</label>
											<input name="emer_last_name" size="26" maxlength="30" 
												type="text" class="text required" value="<?php echo $grp_row['emer_con_last_name']; ?>">
										</span>
									</td>
								</tr>
								<tr>
									<td>
										<span>
											<label class="description" for="emer_email">Email</label>
											<input name="emer_email" class="text email" 
												type="text" size="26" maxlength="30" value="<?php echo $grp_row['emer_con_email']; ?>"> 
										</span>
										<span style="margin-left:5px">
											<label class="description" for="emerg_phone_header">Emergency Contact Phone</label>
											<input name="emer_phone" id="emer_phone" size="26" maxlength="15" type="text" 
												class="text required" value="<?php echo $grp_row['emer_con_phone']; ?>">
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
						<input type="hidden" name="form_id" value="submit_form_process_group">
						<input type="hidden" name="submit_grp_id" value="<?php echo $grp_row['grp_id']; ?>">
						<input type="submit" name="submitProcessGrp" id="submitApproveGrp" class="button_text" value="Approve">
						<input type="submit" name="submitProcessGrp" id="submitDeleteGrp" class="button_text" value="Delete">
						<input type='reset' name='clearProcessGroup' id='clearProcessGroup' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
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