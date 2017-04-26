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
	// Current user groups are Administrators, donations, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	authorize_user(array("Administrators"));
	

	
	if (isset($_POST['form_id']) || isset($_GET['edit_donation'])) {
		
		$searchform = $_POST['form_id'];
		
		if ($searchform == 'submit_form_search_for_donation') {
			$searchforvol = 1;
			$searchfirstname = mysql_real_escape_string(trim($_POST['searchfirstname']));
			$searchlastname = mysql_real_escape_string(trim($_POST['searchlastname']));
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_donation, #form_edit_donation ').hide();
			$(' #form_search_by_donation ').show();
			
			$('#form_search_by_donation').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #editvoltable ');
					} else {
						error.insertAfter(element);
					}
				},
				messages: {
					donation_id: {
						required: "<br>Select a row to edit."
					}
				}
			});
		});
EOD;
		} else if (($searchform == 'submit_form_search_by_donation') || isset($_GET['edit_donation'])) {
			$searchbyvol = 1;
			
			if(isset($_GET['edit_donation']))
			{
				$searchvolid = $_GET['edit_donation'];
			} else {
				$searchvolid = $_POST['donation_id'];
			}
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_donation, #form_search_by_donation, #editvoltable ').hide();
			$(' #form_edit_donation ').show();
			
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
			
			$('#form_edit_donation').submit(function()
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
				
				$('#form_edit_donation').validate( {
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
	
			$(' #form_search_by_donation, #form_edit_donation ').hide();
			$(' #form_search_for_donation ').show();
			$(' #searchfirstname ').focus();
			
			$('#form_search_for_donation').submit(function()
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
		header: 'Donations',
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
			location.href = 'admin_new_donation.php';
        },
        onEdit: function (event) {
			location.href = 'admin_donation.php?edit_donation='+event.recid;
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
			$sql = "SELECT DISTINCT donation_id, " .
				   "				first_name, " .
				   "				last_name, " .
				   "				email, " .
				   "				home_phone, " .
				   "				cell_phone " .
				   "		   FROM donation " .
				   "		  WHERE " . $where .
				   "	   ORDER BY first_name, " .
				   "	 		    last_name";
		
			$result = mysql_query($sql)
				or handle_error("an error occurred while searching for donations", mysql_error());
			
			$num_of_rows = mysql_num_rows($result);

		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to search for donations.",
				"Error searching for donations: " . $exc->getMessage());
		}
		
		while ($row = mysql_fetch_array($result))
		{
			$javascript .= "{ recid: ".$row['donation_id'].", first_name: '".$row['first_name']."', last_name: '".$row['last_name']."', email_address: '".$row['email']."', home_phone: '".$row['home_phone']."', cell_phone: '".$row['cell_phone']."' },
			";
		}

$javascript .= "		
        ]
    });    
});";
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminDonation",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Donation Administration</h2>
				<p>Allows Administrators to edit a donation's information.<br>(NOTE: donations that have not been approved by admin review, will not be listed below.)</p>
			</div>	
			
			<div id="editvoltable"></div>
			
			<center>
			<form name="form_search_for_donation" id="form_search_for_donation" method="post" style="margin:25px 10px" 
				action="admin_donation.php">
			</form>
			</center>
			
			<form name="form_search_by_donation" id="form_search_by_donation" method="post" style="margin:25px 10px" 
				action="admin_donation.php">
			</form>
			
			<form name="form_edit_donation" id="form_edit_donation" class="appnitro" method="POST" action="scripts/process_admin_donation.php">
				<?php
					if ($searchbyvol == 1) {
						$searchbyvol = 0;
					
						$donation_query = "SELECT * " .
								 	"  FROM donation " .
								 	" WHERE donation_id = " . $searchvolid;
								 
						$donation_data = mysql_query($donation_query)
						 	or handle_error("an error occurred while searching for donation", mysql_error());
						
					 	$donation_row = mysql_fetch_array($donation_data);

						}
				?>
				<ul>
					<li style="width:650px">

	<ul>
	
	<li style ="width: 900px">
		<span>
			<label class="description" for="first_name">First Name</label>
			<input name="first_name" size ="26" maxlength="30" type ="text" class ="text required" value="<?php echo($donation_row['first_name']); ?>"/>
		</span>
		<span>
			<label class ="description" for ="middle_initial">M.I.</label>
			<input name="middle_initial" size ="1" maxlength="1" type ="text" class ="center_text" value="<?php echo($donation_row['middle_initial']); ?>"/>
		</span>
		<span>
			<label class ="description" for ="last_name"> Last Name</label>
			<input name ="last_name" size="26" maxlength ="30" type ="text" class= "text required" value="<?php echo($donation_row['last_name']); ?>"/>
			</span>
		<span style = "margin-left:10px">
			<label class = "description" for ="dob"> Date Of Birth </label>
			<input id ="dob" name ="dob" type="date" class ="text required" value="<?php echo($donation_row['date_of_birth']); ?>"/>
		</span>
		<span class = "clear">
			<label class ="description" for ="email"> Email Address</label>
			<input name="email" id = "email" type ="email" size ="40" maxlength ="100" class ="text email" placeholder="email@address.com" value="<?php echo($donation_row['email']); ?>" />
		</span>
		<span style ="margin-left:10px">
			<label class="description" for="home_phone_header">Home Phone </label>
			<input name ="home_phone" id="home_phone" size="15" maxlength="15" type ="text" class="text_phone" placeholder="###-###-####" value="<?php echo($donation_row['home_phone']); ?>"/>
		</span>
		<span style ="margin-left:10px">
			<label class ="description" for ="cell_phone">Cell Phone </label>
			<input name ="cell_phone" id="cell_phone" size="15" maxlength="15" type ="text" class="text_phone" placeholder="###-###-####" value="<?php echo($donation_row['cell_phone']); ?>"/>
		</span>
	</li>

	<div class="form_description">
		<p>&#160;</p>
		</div>
	<br>


<h3> Donation Items </h3>
<li>
<label class = "description" for="item_type"> Type of Items</label>
<span class ="left" style ="width:400px">
<input type="checkbox" name="household_items" value="1" title = "*PLEASE SELECT ITEM TYPE" required/ <?php if($donation_row['household_items']==1){ echo('checked="checked"'); } ?>> House Hold Items (Example: Full size bed, Gas Stove, or Chair)
</span>
</li>
<li>
<span class ="left" style ="width:350px">
<input type="checkbox" name="baby_items" value="1" title = "*PLEASE SELECT ITEM TYPE" <?php if($donation_row['baby_items']==1){ echo('checked="checked"'); } ?>/> Baby Items (Example:Diapers, Formula, Bottles)
</span>
</li>
<li>
<span class ="left" style ="width:350px">
<input type="checkbox" name="misc_items" value="1" title = "*PLEASE SELECT ITEM TYPE" <?php if($donation_row['misc_items']==1){ echo('checked="checked"'); } ?>/> Miscellaneous Items (Any thing that may be useful)
</span>
</li>
<li>
<span class ="left" style ="width:350px">
<input type="checkbox" name="bulk_items" value="1" title = "*PLEASE SELECT ITEM TYPE" <?php if($donation_row['bulk_items']==1){ echo('checked="checked"'); } ?>/> Bulk Items (Any thing that you have bulk quantity of)
</span>

</li>

<li>
<span>
<label class = "description" for="item_desc"> Description of Items</label>
<textarea id="item_desc" name="item_desc" rows= "4" cols="50"><?php echo($donation_row['item_desc']); ?></textarea>
</span>
</li>



<li>
<label class = "description" for="item_condition"> Condition of Items</label>
<span>
<input type="radio" id="new" name="item_condition" value="new" title = "*PLEASE TELL US THE CONDITION OF THE ITEMS" required <?php if($donation_row['item_condition']=="new"){ echo('checked="checked"'); } ?>/>New
</span>
<span>
<input type="radio" id="used" name="item_condition" value="used" title = "*PLEASE TELL US THE CONDITION OF THE ITEMS"  <?php if($donation_row['item_condition']=="used"){ echo('checked="checked"'); } ?>/>Used
</span>
</li>

<li>
<div id ="hide_used_goods">
			<label class="description" for="used_item_condition">Condition of used items: </label>
			<span>
			<input type="radio" name= "used_item_condition" value="excellent"  <?php if($donation_row['used_item_condition']=="excellent"){ echo('checked="checked"'); } ?>/> Excellent
			</span>
			<span>
			<input type ="radio" name="used_item_condition" value="good" <?php if($donation_row['used_item_condition']=="good"){ echo('checked="checked"'); } ?>/> Good
			</span>
			<input type ="radio" name="used_item_condition" value="fair" <?php if($donation_row['used_item_condition']=="fair"){ echo('checked="checked"'); } ?>/> Fair
			<span>
			<input type ="radio" name="used_item_condition" value="poor" <?php if($donation_row['used_item_condition']=="poor"){ echo('checked="checked"'); } ?>/> Poor
			</span>
			</div>
</li>

<br>
<div class="form_description">
		<p>&#160;</p>
		</div>
<li>
<label class="description" for="can_deliver">Are you able to deliver your items if needed?  </label>
<span>
<input type ="radio" name="can_deliver" value="1" title = "*PLEASE LET US KNOW IF YOU CAN DELIVER THE ITEMS" required  <?php if($donation_row['can_deliver']==1){ echo('checked="checked"'); } ?>/> Yes
</span>
<span>
<input type ="radio" name="can_deliver" value="0" title = "*PLEASE LET US KNOW IF YOU CAN DELIVER THE ITEMS" <?php if($donation_row['can_deliver']==0){ echo('checked="checked"'); } ?>/> No
</span>
</li>

<li>
<label class = "description" for="can_store">Are you able to store your items if needed?  </label>
<span>
<input type="radio" name="can_store" value="1" title ="*PLEASE LET US KNOW IF YOU CAN STORE ITEMS" required  <?php if($donation_row['can_store']==1){ echo('checked="checked"'); } ?>/> Yes
</span>
<span>
<input type="radio" name="can_store" value="0" title ="*PLEASE LET US KNOW IF YOU CAN STORE ITEMS"  <?php if($donation_row['can_store']==0){ echo('checked="checked"'); } ?>/> No
</span>
</li>
</tr>
<tr>
</table>
<li>
		<span>
			<label class = "description" for="address2"> If you are storing the items, please state the address of stored items below</label>
			<input name="address_stored_items_st1" size ="80" maxlength ="30" type ="text" class ="text"  value="<?php echo($donation_row['address_stored_items_st1']); ?>"/>
			<label for ="address_stored_items_st1"> Street Address (line 1)</label>
		</span>
		<span class ="clear">
			<input name= "address_stored_items_st2" size="80" maxlength ="30" type ="text" class ="text" value="<?php echo($donation_row['address_stored_items_st2']); ?>"/>
			<label for ="address_stored_items_st2">Street Address (line 2) </label>
			</span>
		<span class ="clear">
			<input name ="address_stored_items_city" size ="25" maxlength ="30" type ="text" class ="text" value="<?php echo($donation_row['address_stored_items_city']); ?>"/>
			<label for ="address_stored_items_city"> City </label>
		</span>
		<span>
		<input name="address_stored_items_state" size="2" maxlength ="2" type ="text" value="AL" class ="center_text required" value="<?php echo($donation_row['address_stored_items_state']); ?>"/>
		<label for ="address_stored_items_state">State</label>
		</span>
		<span>
			<input name ="address_stored_items_zip" size ="5" maxlength ="15" type ="text" class ="text" placeholder="#####" value="<?php echo($donation_row['address_stored_items_zip']); ?>"/>
				<label for ="address_stored_items_zip"/> Postal&#47; Zip Code </label>
		</span>
		</li>
<h2 id="val_label" align="center" > &nbsp; <br><br> </h2>

	
		</ul>
				<ul>
					<li class="section_break"></li>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_edit_donation">
						<input type="hidden" name="submit_donation_id" value="<?php echo $donation_row['donation_id']; ?>">					
						<input type="submit" name="submitAdminVol" id="submitApproveVol" class="button_text" value="Update">
						<input type="submit" name="submitAdminVol" id="submitDeleteVol" class="button_text" value="Delete">					
						<input type='reset' name='clearEditdonation' id='clearEditdonation' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
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