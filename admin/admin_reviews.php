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
		
		if ($searchform == 'submit_form_list_volunteers') {
			$searchforvol = 1;
			$searchvolid = $_POST['vol_id'];
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_list_volunteers ').hide();
			$(' #form_process_volunteer ').show();
			
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
			
			$('#form_process_volunteer').submit(function()
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
				
				
			$('#form_process_volunteer').validate( {
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
	
			$(' #form_process_volunteer ').hide();
			$(' #form_list_volunteers ').show();
		
			$('#form_list_volunteers').validate( {
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
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminReviews",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
	
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Admin Review of New Volunteer Registrations</h2>
				<p>Allows Administrators to review a volunteer's information prior to being<br>
					available in search results.  Also allows for deletion of invalid volunteers.</p>
			</div>	
			
			<form name="form_list_volunteers" id="form_list_volunteers" method="post" style="margin:25px 10px" 
				action="admin_reviews.php">
				<?php
					
					try {
						$count_sql = "SELECT vol_id " .
									 "  FROM volunteers " .
									 " WHERE admin_review = 0";
									 
						$count_result = mysql_query($count_sql)
							or handle_error("an error occurred while searching for volunteers requiring an admin review", mysql_error());
						
						$count_records = mysql_num_rows($count_result);
						
					} catch (Exception $exc) {
						handle_error("something went wrong while attempting to search for volunteers that require an admin review.",
							"Error searching for volunteers that require an admin review: " . $exc->getMessage());
					}
					
					if ($count_records > 0) {
						
						$disabled = "";
						
						try {
							$sql = "SELECT DISTINCT vol_id, " .
								   "				first_name, " .
								   "				last_name, " .
								   "				email_address, " .
								   "				home_phone, " .
								   "				cell_phone " .
								   "		   FROM volunteers " .
								   "		  WHERE admin_review = 0 " .
								   "	   ORDER BY first_name, " .
								   "	 		    last_name";
						
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for volunteers", mysql_error());
				
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for volunteers.",
								"Error searching for volunteers: " . $exc->getMessage());
						}
						
						echo "				<center>";
						echo "				<table class='editvoltable' id='editvoltable' width='90%'>";
						echo "					<th style='width:4px'></th>";
						echo "					<th>First Name</th>";
						echo "					<th>Last Name</th>";
						echo "					<th>Email</th>";
						echo "					<th>Home Phone</th>";
						echo "					<th>Cell Phone</th>";

						while ($row = mysql_fetch_array($result))
						{
							echo "					<tr>";
							echo "						<td style='width:4px'><input type='radio' name='vol_id' id='vol_id' class='required' value='" . $row['vol_id'] . "'</td>";
							echo "						<td>" . $row['first_name'] . "</td>";
							echo "						<td>" . $row['last_name'] . "</td>";
							echo "						<td>" . $row['email_address'] . "</td>";
							echo "						<td>" . $row['home_phone'] . "</td>";
							echo "						<td>" . $row['cell_phone'] . "</td>";
							echo "					</tr>";
						}
						echo "				</table>";
						echo "				</center>";
						
						echo "				<ul>";
						echo "					<li class='buttons'>";
						echo "						<input type='hidden' name='form_id' value='submit_form_list_volunteers'>";
						echo "						<input type='submit' name='submitListVolunteers' id='submitListVolunteers' class='button_text' value='View Volunteer Info' " . $disabled . ">";
						echo "					</li>";
						echo "				</ul>";
					
					} else {
						echo "				<br><h3 align='center' style='color:#FF0000'>There are no Volunteers requiring an admin review.</h3><br>";
						$disabled = "disabled";
					}	
				?>
			</form>
			
			<form name="form_process_volunteer" id="form_process_volunteer" class="appnitro" method="POST" action="scripts/process_admin_reviews.php">
				<?php
					if ($searchforvol == 1) {
						$searchforvol = 0;
					
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
					<li style="width:650px">
						<span>
							<label class="description" for="first_name">First Name</label>
							<input name="first_name" size="26" maxlength="30" type="text" class="text required" value="<?php echo $vol_row['first_name']; ?>">
						</span>
						<span>
							<label class="description" for="middle_initial">M.I.</label>
							<input name="middle_initial" size="2" maxlength="2" type="text" class="center_text" value="<?php echo $vol_row['middle_initial']; ?>">
						</span>
						<span>
							<label class="description" for="last_name">Last Name</label>
							<input name="last_name" size="26" maxlength="30" type="text" class="text required" value="<?php echo $vol_row['last_name']; ?>">
						</span>
						<span style="margin-left:10px">
							<label class="description" for="dob">Date Of Birth</label>
							<input id="dob" name="dob" class="text required" size="20" value="<?php echo date_format(date_create($vol_row['date_of_birth']),'m/d/Y'); ?>">
						</span>
						<span class="clear">
							<label class="description" for="email">Email Address</label>
							<input name="email" id="email" type="text" size="40" maxlength="40" class="text email" value="<?php echo $vol_row['email_address']; ?>"> 
						</span> 
						<span style="margin-left:10px" id="phone">
							<label class="description" for="home_phone_header">Home Phone </label>
							<input name="home_phone" id="home_phone" size="22" maxlength="15" type="text" class="text_phone" value="<?php echo $vol_row['home_phone']; ?>">
						</span>
						<span style="margin-left:10px" id="phone">
							<label class="description" for="cell_phone_header">Cell Phone </label>
							<input name="cell_phone" id="cell_phone" size="22" maxlength="15" type="text" class="text_phone" value="<?php echo $vol_row['cell_phone']; ?>">
						</span>
					</li>
					<li>
						<span>
							<label class="description" for="address">Home Address</label>
							<input name="street_address1" size="87" maxlength="30" type="text" class="text" value="<?php echo $vol_row['street_address1']; ?>">
							<label for="street_address1">Street Address (line 1)</label>
						</span>
						<span class="clear">
							<input name="street_address2" size="87" maxlength="30" type="text" class="text" value="<?php echo $vol_row['street_address2']; ?>">
							<label for="street_address2">Street Address (line 2)</label>
						</span>
						<span class="clear">
							<input name="city" size="45" maxlength="30" type="text" class="text required" value="<?php echo $vol_row['city']; ?>">
							<label for="city">City</label>
						</span>
						<span>
							<input name="state" size="2" maxlength="2" type="text" value="AL" class="center_text required" value="<?php echo $vol_row['state']; ?>">
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
												type="text" class="text required" value="<?php echo $vol_row['emer_con_first_name']; ?>">
										</span>
										<span style="margin-left:5px">
											<label class="description" for="emer_last_name">Last Name</label>
											<input name="emer_last_name" size="26" maxlength="30" 
												type="text" class="text required" value="<?php echo $vol_row['emer_con_last_name']; ?>">
										</span>
									</td>
								</tr>
								<tr>
									<td>
										<span>
											<label class="description" for="emer_relationship">Relationship</label>
											<input name="emer_relationship" class="text required" 
												type="text" size="26" maxlength="30" value="<?php echo $vol_row['emer_con_relationship']; ?>"> 
										</span>
										<span style="margin-left:5px">
											<label class="description" for="emerg_phone_header">Emergency Contact Phone</label>
											<input name="emer_phone" id="emer_phone" size="26" maxlength="15" type="text" 
												class="text required" value="<?php echo $vol_row['emer_con_phone']; ?>">
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
						<input type="hidden" name="form_id" value="submit_form_process_volunteer">
						<input type="hidden" name="submit_vol_id" value="<?php echo $vol_row['vol_id']; ?>">
						<input type="submit" name="submitProcessVol" id="submitApproveVol" class="button_text" value="Approve">
						<input type="submit" name="submitProcessVol" id="submitDeleteVol" class="button_text" value="Delete">
						<input type='reset' name='clearProcessVolunteer' id='clearProcessVolunteer' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
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
