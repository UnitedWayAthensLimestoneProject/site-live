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
	// Current user groups are Administrators, emails, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	authorize_user(array("Administrators"));
	

	
	if (isset($_POST['form_id']) || isset($_GET['edit_email'])) {
		
		$searchform = $_POST['form_id'];
		
		if ($searchform == 'submit_form_search_for_email') {
			$searchforvol = 1;
			$searchfirstname = mysql_real_escape_string(trim($_POST['searchfirstname']));
			$searchlastname = mysql_real_escape_string(trim($_POST['searchlastname']));
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_email, #form_edit_email ').hide();
			$(' #form_search_by_email ').show();
			
			$('#form_search_by_email').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #editvoltable ');
					} else {
						error.insertAfter(element);
					}
				},
				messages: {
					email_id: {
						required: "<br>Select a row to edit."
					}
				}
			});
		});
EOD;
		} else if (($searchform == 'submit_form_search_by_email') || isset($_GET['edit_email'])) {
			$searchbyvol = 1;
			
			if(isset($_GET['edit_email']))
			{
				$searchvolid = $_GET['edit_email'];
			} else {
				$searchvolid = $_POST['email_id'];
			}
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_email, #form_search_by_email, #editvoltable ').hide();
			$(' #form_edit_email ').show();
			
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
			
			$('#form_edit_email').submit(function()
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
				
				$('#form_edit_email').validate( {
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
	
			$(' #form_search_by_email, #form_edit_email ').hide();
			$(' #form_search_for_email ').show();
			$(' #searchfirstname ').focus();
			
			$('#form_search_for_email').submit(function()
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
		header: 'Emails',
        show: { 
            toolbar: true,
            footer: true,
			header: true,
            toolbarEdit: true,
            toolbarAdd: true
        },
        searches: [                
            { field: 'email_display_name', caption: 'Name', type: 'text' },
            { field: 'email_address', caption: 'Email Address', type: 'text' },
            { field: 'email_action_description', caption: 'Action', type: 'text' },
        ],
        columns: [                
            { field: 'email_display_name', caption: 'Name', size: '20%', sortable: true, attr: 'align=center' },
            { field: 'email_address', caption: 'Email Address', size: '30%', sortable: true, attr: 'align=center' },
            { field: 'email_action_description', caption: 'Action', size: '50%', sortable: true, attr: 'align=center' },
         ],
        onAdd: function (event) {
			location.href = 'admin_new_email.php';
        },
        onEdit: function (event) {
			location.href = 'admin_emails.php?edit_email='+event.recid;
        },
        onDelete: function (event) {
            console.log('delete has default behaviour');
        },
        onSave: function (event) {
            w2alert('save');
        },
        records: [
		";
		
		try {
			$sql = "SELECT DISTINCT email_id, " .
				   "email_display_name, " .
				   "email_address, " .
				   "email_action, " .
				   "email_action_description " .
				   "FROM email_forms a, email_action b where a.email_action_id=b.email_action_id " .
				   "ORDER BY email_display_name";
		
			$result = mysql_query($sql)
				or handle_error("an error occurred while searching for emails", mysql_error());
			
			$num_of_rows = mysql_num_rows($result);

		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to search for emails.",
				"Error searching for emails: " . $exc->getMessage());
		}
		
		while ($row = mysql_fetch_array($result))
		{
			$javascript .= "{ recid: ".$row['email_id'].", email_display_name: '".$row['email_display_name']."', email_address: '".$row['email_address']."', email_action: '".$row['email_action']."', email_action_description: '".$row['email_action_description']."' },
			";
		}

$javascript .= "		
        ]
    });    
});";
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminEmail",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Email Administration</h2>
				<p>Allows Administrators to edit a email information.</p>
			</div>	
			
			<div id="editvoltable"></div>
			
			<center>
			<form name="form_search_for_email" id="form_search_for_email" method="post" style="margin:25px 10px" 
				action="admin_emails.php">
			</form>
			</center>
			
			<form name="form_search_by_email" id="form_search_by_email" method="post" style="margin:25px 10px" 
				action="admin_emails.php">
			</form>
			
			<form name="form_edit_email" id="form_edit_email" class="appnitro" method="POST" action="scripts/process_admin_email.php">
				<?php
					if ($searchbyvol == 1) {
						$searchbyvol = 0;
					
						$email_query = "SELECT * " .
								 	"  FROM email_forms " .
								 	" WHERE email_id = " . $searchvolid;
								 
						$email_data = mysql_query($email_query)
						 	or handle_error("an error occurred while searching for email", mysql_error());
						
					 	$email_row = mysql_fetch_array($email_data);
					 	
					 	try {
							$action_sql = "SELECT * FROM email_action";
						
							$action_result = mysql_query($action_sql)
								or handle_error("an error occurred while searching for skills associated with the opportunity", mysql_error());
								
							$num_of_rows = mysql_num_rows($action_result);
							
							
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for skills associated with the opportunity.",
								"Error searching for skills associated with the opportunity: " . $exc->getMessage());
						}
					 }
				?>
				<ul>
					<li style="width:650px">
						<span>
							<label class="description" for="email_display_name">Display Name</label>
							<input name="email_display_name" size="26" maxlength="30" type="text" value="<?php echo $email_row['email_display_name']; ?>">
						</span>
						<span>
							<label class="description" for="email_address">Email.</label>
							<input name="email_address" size="50" maxlength="100" type="email" class="text" value="<?php echo $email_row['email_address']; ?>">
						</span>
						<span>
							<label class="description" for="email_action_id">Action</label>
							
							<select name="email_action_id" required="required">
						<?php
							while($action = mysql_fetch_array($action_result)) {
								echo '<option value="'. $action['email_action_id'] . '"';
								if($email_row['email_action_id']==$action['email_action_id'])
									echo ' selected="selected"';
								echo '>' . $action['email_action_description']. "</option>\n";
							}
						?>
						</select>
						</span>
				</ul>
				<ul><li style="height:50px"></li></ul>
				<ul>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_email_form">
						<input type="hidden" name="submit_email_id" value="<?php echo $email_row['email_id']; ?>">					
						<input type="submit" name="submitAdminVol" id="submitApproveVol" class="button_text" value="Update">
						<input type="submit" name="submitAdminVol" id="submitDeleteVol" class="button_text" value="Delete">					
						<input type='reset' name='clearEditemail' id='clearEditemail' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
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