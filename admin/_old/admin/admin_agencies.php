<?php

	require_once 'scripts/authorize.php';
	require_once 'scripts/database_connection.php';
	require_once 'scripts/view.php';

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
	
	if (isset($_POST['edit_agency_id'])) {
		$search = 1;
		$search_string = $_POST['edit_agency_id'];
		
		$javascript = <<<EOD
	$(document).ready(function() {
	
		$( '#form_admin_agencies_add, #form_edit_agencies_search' ).hide();
		$( 'input#edit_agency_active_yes, input#edit_agency_active_no' ).button();
		$( 'div#active_inactive' ).buttonset();
		$( '#form_admin_agencies_edit' ).show();
		
		$( '#editagency' ).prop('checked', true);
		$( '#addagency' ).attr('disabled', true);
		
		if ($( '#edit_agency_active_yes' ).attr('checked') == 'checked') {
			$( '#edit_agency_active_yes' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
			$( '#edit_agency_active_no' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
		} else {
			$( '#edit_agency_active_yes' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
			$( '#edit_agency_active_no' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
		};
		
		$( '#edit_agency_active_yes' ).click(function() {
			$( '#edit_agency_active_yes' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
			$( '#edit_agency_active_no' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
		});
		
		$( '#edit_agency_active_no' ).click(function() {
			$( '#edit_agency_active_yes' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
			$( '#edit_agency_active_no' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
		});
		
		$( '#add_agency_phone' ).mask('(999) 999-9999');
		$( '#edit_agency_phone' ).mask('(999) 999-9999');
		
		$( '#form_admin_agencies_edit' ).validate();
		
	});
EOD;
		
	} else {
	
		$javascript = <<<EOD
	$(document).ready(function() {
	
		$( '#form_admin_agencies_add, #form_edit_agencies_search, #form_admin_agencies_edit' ).hide();
		
		$( '#addagency' ).click(function() {
			$( '#messages, #success, #form_edit_agencies_search, #form_admin_agencies_edit' ).hide();
			$( '#edit_user_name_search' ).val('');
			$( '#submitEditAgency' ).attr('disabled', true);
			$( '#form_admin_agencies_add' ).show();
			$( '#add_agency_name' ).focus();
		});
		
		$( '#editagency' ).click(function() {
			$( '#messages, #success, #form_admin_agencies_add, #form_admin_agencies_edit' ).hide();
			$( '#submitEditAgencySearch' ).attr('disabled', true);
			$( '#add_agency_name' ).val('');
			$( '#add_agency_address' ).val('');
			$( '#add_agency_city' ).val('');
			$( '#add_agency_state' ).val('AL');
			$( '#add_agency_zipcode' ).val('');
			$( '#form_edit_agencies_search' ).show();
		});
		
		$( '#edit_agency_id' ).change(function() {
			if ($( '#edit_agency_id' ).val() != '') {
				
				$( '#submitEditAgencySearch' ).attr('disabled', false);
			} else {
				$( '#submitEditAgencySearch' ).attr('disabled', true);
			}
		});
		
		$( '#add_agency_phone' ).mask('(999) 999-9999');
		$( '#edit_agency_phone' ).mask('(999) 999-9999');
		
		$( '#form_admin_agencies_add' ).validate();
			
	}); // end ready
EOD;

	}

	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminAgencies",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>United Way Partner Agencies Administration</h2>
				<p>Gives Administrators the ability to edit agencies.</p>
			</div>
			<div align="center">
				<input type="radio" name="agencyInput" id="addagency" value="add"> Add New Agency
	 			<input type="radio" name="agencyInput" id="editagency" value="edit" style="margin-left:20px"> Edit Existing Agency
			</div>			
			
			<form name="form_admin_agencies_add" id="form_admin_agencies_add" method="post" action="scripts/process_admin_agencies.php" style="margin-top:50px">	
		 		<div align="center">
		 			<label class="user_form" for="add_agency_name">Agency Name: </label>
		 			<input type="text" name="add_agency_name" id="add_agency_name" class="text required"
		 				   title="Please enter agency's name."><br><br>
		 			<label class="user_form" for="add_agency_address">Address: </label>
		 			<input type="text" name="add_agency_address" id="add_agency_address" class="text required"
		 				   title="Please enter agency's street address."><br><br>
		 			<label class="user_form" for="add_agency_city">City: </label>
		 			<input type="text" name="add_agency_city" id="add_agency_city" class="text required"
		 				   title="Please enter agency's city."><br><br>
		 			<label class="user_form" for="add_agency_state">State: </label>
		 			<input type="text" name="add_agency_state" id="add_agency_state" class="text required"
		 				   title="Please enter agency's state." value="AL" maxlength="2"><br><br>
		 			<label class="user_form" for="add_agency_zipcode">Zip Code: </label>
		 			<input type="text" name="add_agency_zipcode" id="add_agency_zipcode" class="text required"
		 				   title="Please enter agency's zip code."><br><br>
		 			<label class="user_form" for="add_agency_phone">Phone: </label>
		 			<input type="text" name="add_agency_phone" id="add_agency_phone" class="text required"
		 				   title="Please enter agency's phone number."><br><br>
		 		</div>
		 		<div>
		 			<p><br></p>
		 		</div>
		 		<ul>
		 			<li class="buttons">
				    	<input type="hidden" name="form_id" value="submit_form_admin_agencies_add">
						<input type="submit" name="submitAddAgency" id="submitAddAgency" class="button_text" value="Save Agency">
						<input type="reset" name="clearAddAgency" id="clearAddAgency" class="button_text" value="Clear Form">
		 			</li>
				</ul>
			</form>
			
			
			<form name="form_edit_agencies_search" id="form_edit_agencies_search" method="post" style="margin:50px 0 25px 10px" action="admin_agencies.php">				
				<div align="center">
		 			<label class="user_form" for="edit_agency_id">Agency Name: </label>
		 			<?php
	 					$sql = ("SELECT agy_id, agy_name, active " .
	 						    "  FROM agency " .
			 				    "ORDER BY agy_name");
			 					
			 			$result = mysql_query($sql)
			 				or die ("Unable to make the query: " . mysql_error());
			 					
						echo "<select autofocus name='edit_agency_id' id='edit_agency_id' style='width:200px'>";
						echo "<option value=''>Select an agency</option>";
	 					while ($row = mysql_fetch_array($result)) {
		 					echo "<option value='" . $row['agy_id'] . "'>" . $row['agy_name'];
							if($row['active'] == 1) {
							echo " Active" . "</option>";}
							else {
							echo " Inactive" . "</option>";}
							
		 				}
		 				echo "</select><br><br>";
		 			?>
				</div>
		 		<div>
		 			<p><br></p>
		 		</div>
				<ul>
		 			<li class="buttons">
				    	<input type="hidden" name="form_id" value="submit_form_edit_agencies_search">
						<input type="submit" name="submitEditAgencySearch" id="submitEditAgencySearch" class="button_text" value="Edit Agency">
						<input type="reset" name="clearEditAgencySearch" id="clearEditAgencySearch" class="button_text" value=" Cancel " onclick="window.location = window.location.pathname">
		 			</li>
				</ul>
			</form>
			
			<form name="form_admin_agencies_edit" id="form_admin_agencies_edit" method="post" action="scripts/process_admin_agencies.php" style="margin:50px 0 25px 10px">
				<?php
					if ($search == 1) {
						try {
							$sql = "SELECT * " .
								   "  FROM agency " .
								   " WHERE agy_id = '{$search_string}'";
								   
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for agency", mysql_error());
					
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for agency.",
					 			"Error searching for agency: " . $exc->getMessage());
					 	}
					 	$row = mysql_fetch_array($result);
					}
				?>
				<div align="center">
		 			<input type="hidden" name="edit_agency_id" id="edit_agency_id" value="<?php echo $row['agy_id']; ?>">
		 			<label class="user_form" for="edit_agency_name">Agency Name: </label>
		 			<input type="text" name="edit_agency_name" id="edit_agency_name" class="text required"
		 				   title="Please enter the partner agency's name." value="<?php echo $row['agy_name']; ?>"><br><br>
		 			<label class="user_form" for="edit_agency_address">Address: </label>
		 			<input type="text" name="edit_agency_address" id="edit_agency_address" class="text required"
		 				   title="Please enter the partner agency's street address." value="<?php echo $row['agy_street_address']; ?>"><br><br>
		 			<label class="user_form" for="edit_agency_city">City: </label>
		 			<input type="text" name="edit_agency_city" id="edit_agency_city" class="text required"
		 				   title="Please enter the partner agency's city." value="<?php echo $row['agy_city']; ?>"><br><br>
		 			<label class="user_form" for="edit_agency_state">State: </label>
		 			<input type="text" name="edit_agency_state" id="edit_agency_state" class="text required"
		 				   title="Please enter the partner agency's state." value="<?php echo $row['agy_state']; ?>" maxlength="2"><br><br>
		 			<label class="user_form" for="edit_agency_zipcode">Zip Code: </label>
		 			<input type="text" name="edit_agency_zipcode" id="edit_agency_zipcode" class="text required"
		 				   title="Please enter the partner agency's zip code." value="<?php echo $row['agy_zip_code']; ?>"><br><br>
		 			<label class="user_form" for="edit_agency_phone">Phone: </label>
		 			<input type="text" name="edit_agency_phone" id="edit_agency_phone" class="text required"
		 				   title="Please enter agency's phone number." value="<?php echo $row['agy_phone']; ?>"><br><br>
		 		</div>
				<div>
		 			<p><br></p>
		 		</div>
				<div id="active_inactive" align="center">
					<input type="radio" name="edit_agency_active" id="edit_agency_active_yes" value="1" title="Active" <?php if($row['active'] == 1) {echo 'checked';} ?>>
						<label for="edit_agency_active_yes"> Active </label></input>
					<input type="radio" name="edit_agency_active" id="edit_agency_active_no" value="0" title="Inactive" <?php if($row['active'] == 0) {echo 'checked';} ?>>
						<label for="edit_agency_active_no">Inactive</label></input><br>
				</div>
		 		<div>
		 			<p><br></p>
		 		</div>
		 		<ul>
		 			<li class="buttons">
				    	<input type="hidden" name="form_id" value="submit_form_admin_agencies_edit">
						<input type="hidden" name="submit_agy_id" value="<?php echo $row['agy_id']; ?>">
						<input type="submit" name="submitEditAgency" id="submitEditAgency" class="button_text" value="Save Agency">
						<input type="submit" name="submitEditAgency" id="submitDeleteOpp" class="button_text" value="Delete">
						<input type="reset" name="clearEditAgency" id="clearEditAgency" class="button_text" value=" Cancel " onclick="window.location = window.location.pathname">
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