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
	
	if (isset($_POST['edit_user_name_search']) || isset($_POST['edit_user_username_search'])) {
		if (isset($_POST['edit_user_name_search'])) {
			$search = 1;
			$search_string = mysql_real_escape_string(trim($_POST['edit_user_name_search']));
		} else {
			$search = 2;
			$search_string = mysql_real_escape_string(trim($_POST['edit_user_username_search']));
		}
		
		$javascript = <<<EOD
	$(document).ready(function() {
	
		$(' #form_admin_user_add, #search_by_radio_buttons, #form_edit_users_name_search, #form_edit_users_username_search, #form_admin_users_edit_selection, #search_by_radio_buttons2, #form_change_password_name_search, #form_change_password_username_search, #form_list_change_password_users_search_results, #form_admin_change_users_password ').hide();
		$( '#form_list_users_search_results' ).show();
		$( '#edituser' ).prop('checked', true);
		
		$( '#adduser, #changepw' ).attr('disabled', true);
	
		$('#form_list_users_search_results').validate( {
			errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.insertAfter( '#e_text' );
		        } else {
		          error.insertAfter(element);
		        } 
		    },
			messages: {
				edit_user: {
					required: "<br>Select a user to edit."
				}
			}
		});
	});
EOD;

		} else if(isset($_POST['edit_user'])) {
		
		$modify = 1;
		$edit_id = $_POST['edit_user'];

		$javascript = <<<EOD
	$(document).ready(function() {
		
		$(' #form_admin_user_add, #search_by_radio_buttons, #form_edit_users_name_search, #form_edit_users_username_search, #form_list_users_search_results, #search_by_radio_buttons2, #form_change_password_name_search, #form_change_password_username_search, #form_list_change_password_users_search_results, #form_admin_change_users_password ').hide();
		$( '#form_admin_users_edit_selection' ).show();
		$( 'input#edit_user_active_yes, input#edit_user_active_no' ).button();
		$( 'div#active_inactive' ).buttonset();
		$( '#edituser' ).prop('checked', true);
		
		$( '#adduser, #changepw' ).attr('disabled', true);
		
		if ($( '#edit_user_active_yes' ).attr('checked') == 'checked') {
			$( '#edit_user_active_yes' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
			$( '#edit_user_active_no' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
		} else {
			$( '#edit_user_active_yes' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
			$( '#edit_user_active_no' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
		};
		
		$( '#edit_user_active_yes' ).click(function() {
			$( '#edit_user_active_yes' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
			$( '#edit_user_active_no' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
		});
		
		$( '#edit_user_active_no' ).click(function() {
			$( '#edit_user_active_yes' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
			$( '#edit_user_active_no' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
		});
		
	}); // end ready
EOD;

	} else if (isset($_POST['edit_password_name_search']) || isset($_POST['edit_password_username_search'])) {
		if (isset($_POST['edit_password_name_search'])) {
			$search = 3;
			$search_string = mysql_real_escape_string(trim($_POST['edit_password_name_search']));
		} else {
			$search = 4;
			$search_string = mysql_real_escape_string(trim($_POST['edit_password_username_search']));
		}
		
		$javascript = <<<EOD
	$(document).ready(function() {
	
		$( '#form_admin_user_add, #search_by_radio_buttons, #form_edit_users_name_search, #form_edit_users_username_search, #form_list_users_search_results, #form_admin_users_edit_selection, #search_by_radio_buttons2, #form_change_password_name_search, #form_change_password_username_search, #form_admin_change_users_password' ).hide();
		$( '#form_list_change_password_users_search_results' ).show();
		$( '#changepw' ).prop('checked', true);
		
		$(' #adduser, #edituser ').attr('disabled', true);
	
		$('#form_list_change_password_users_search_results').validate( {
			errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.insertAfter( '#e2_text' );
		        } else {
		          error.insertAfter(element);
		        } 
		    },
			messages: {
				edit_pw_user: {
					required: "<br>Select a user to edit."
				}
			}
		});
	});
EOD;
	
	} else if(isset($_POST['edit_user_pw'])) {
		
		$modifypassword = 1;
		$change_pw_id = $_POST['edit_user_pw'];

		$javascript = <<<EOD
	$(document).ready(function() {
		
		$(' #form_admin_user_add, #search_by_radio_buttons, #form_edit_users_name_search, #form_edit_users_username_search, #form_list_users_search_results, #form_admin_users_edit_selection, #search_by_radio_buttons2, #form_change_password_name_search, #form_change_password_username_search, #form_list_change_password_users_search_results, #form_admin_change_users_password ').hide();
		$(' #form_admin_change_users_password ').show();
		$(' input#edit_user_active_yes, input#edit_user_active_no ').button();
		$(' div#active_inactive ').buttonset();
		$(' #changepw ').prop('checked', true);
		$(' #change_user_pw ').focus();
		
		$( '#adduser, #edituser' ).attr('disabled', true);
		
		if ($( '#edit_user_active_yes' ).attr('checked') == 'checked') {
			$( '#edit_user_active_yes' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
			$( '#edit_user_active_no' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
		} else {
			$( '#edit_user_active_yes' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
			$( '#edit_user_active_no' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
		};
		
		$( '#edit_user_active_yes' ).click(function() {
			$( '#edit_user_active_yes' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
			$( '#edit_user_active_no' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
		});
		
		$( '#edit_user_active_no' ).click(function() {
			$( '#edit_user_active_yes' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
			$( '#edit_user_active_no' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
		});
		
		$( '#form_admin_change_users_password' ).validate({
			rules: {
				change_user_pw: {
					required: true,
					minlength: 3
				},
				confirm_change_pw: {
					required: true,
					minlength: 3,
					equalTo: "#change_user_pw"
				}
			},
			messages: {
				change_user_pw: {
					required: "Please enter a password.",
					minlength: jQuery.format("Passwords must be at least {0} characters.")
				},
				confirm_change_pw: {
					required: "Please re-enter the password.",
					minlength: jQuery.format("Passwords must be at least {0} characters."),
					equalTo: "Your passwords do not match."
				}
			}
		});
		
	}); // end ready
EOD;

	} else {
	
		$search1 = 0;
		$search2 = 0;
		$search3 = 0;
		$search4 = 0;
		$modify = 0;
		$modifypassword = 0;
		$search_string = "";
		
		$javascript = <<<EOD
	$(document).ready(function() {
	
		$( '#form_admin_user_add, #search_by_radio_buttons, #form_edit_users_name_search, #form_edit_users_username_search, #form_list_users_search_results, #form_admin_users_edit_selection, #search_by_radio_buttons2, #form_change_password_name_search, #form_change_password_username_search, #form_list_change_password_users_search_results, #form_admin_change_users_password' ).hide();
		
		$( '#adduser' ).click(function() {
			$( '#messages, #success, #search_by_radio_buttons, #form_edit_users_name_search, #form_edit_users_username_search, #form_list_users_search_results, #search_by_radio_buttons2, #form_change_password_name_search, #form_change_password_username_search, #form_list_change_password_users_search_results, #form_admin_change_users_password' ).hide();
			$( '#edit_user_name_search' ).val('');
			$( '#submitAddUser' ).attr('disabled', true);
			$( '#form_admin_user_add' ).show();
			$( '#add_name' ).focus();
		});
		
		$( '#edituser' ).click(function() {
			$( '#messages, #success, #form_admin_user_add, #search_by_radio_buttons2, #form_change_password_search, #form_change_password_name_search, #form_change_password_username_search, #form_list_change_password_users_search_results, #form_admin_change_users_password' ).hide();
			$( '#search_by_name, #search_by_username' ).prop('checked', false);
			$( '#add_name' ).val('');
			$( '#add_user_name' ).val('');
			$( '#add_user_pw' ).val('');
			$( '#confirm_pw' ).val('');
			$( '#add_user_email' ).val('');
			$( '#search_by_radio_buttons' ).show();
		});
		
		$( '#changepw' ).click(function() {
			$( '#messages, #success, #form_admin_user_add, #search_by_radio_buttons, #form_edit_users_name_search, #form_edit_users_username_search, #form_list_users_search_results, #form_change_password_search' ).hide();
			$( '#password_search_by_name, #password_search_by_username' ).prop('checked', false);
			$( '#add_name' ).val('');
			$( '#add_user_name' ).val('');
			$( '#add_user_pw' ).val('');
			$( '#confirm_pw' ).val('');
			$( '#add_user_email' ).val('');
			$( '#search_by_radio_buttons2' ).show();
		});
		
		$( '#groupID' ).change(function() {
			if ($( '#groupID' ).val() != '') {
				$( '#submitAddUser' ).attr('disabled', false);
		        $( "#submitAddUser" ).focus();
			} else {
				$( '#submitAddUser' ).attr('disabled', true);
				$( '#groupID' ).focus();
			}
		});
		
		$( '#form_admin_user_add' ).validate({
			rules: {
				add_user_pw: {
					required: true,
					minlength: 3
				},
				confirm_pw: {
					required: true,
					minlength: 3,
					equalTo: "#add_user_pw"
				}
			},
			messages: {
				add_user_pw: {
					required: "Please enter a password.",
					minlength: jQuery.format("Passwords must be at least {0} characters.")
				},
				confirm_pw: {
					required: "Please re-enter the password.",
					minlength: jQuery.format("Passwords must be at least {0} characters."),
					equalTo: "Your passwords do not match."
				}
			}
		});
		
		$( '#search_by_name' ).click(function() {
			$( '#form_edit_users_username_search' ).hide();
			$( '#edit_user_username_search' ).val('');
			$( '#form_edit_users_name_search' ).show();
			$( '#edit_user_name_search' ).focus();
		});
		
		$( '#search_by_username' ).click(function() {
			$( '#form_edit_users_name_search' ).hide();
			$( '#edit_user_name_search' ).val('');
			$( '#form_edit_users_username_search' ).show();
			$( '#edit_user_username_search' ).focus();
		});
		
		$( '#password_search_by_name' ).click(function() {
			$( '#form_change_password_username_search' ).hide();
			$( '#edit_password_username_search' ).val('');
			$( '#form_change_password_name_search' ).show();
			$( '#edit_password_name_search' ).focus();
		});
		
		$( '#password_search_by_username' ).click(function() {
			$( '#form_change_password_name_search' ).hide();
			$( '#edit_password_name_search' ).val('');
			$( '#form_change_password_username_search' ).show();
			$( '#edit_password_username_search' ).focus();
		});

		$(' #form_edit_users_name_search' ).validate();
		
		$(' #form_edit_users_username_search' ).validate();
		
		$(' #form_change_password_name_search ').validate();
		
		$(' #form_change_password_username_search ').validate();
		
	});
EOD;

	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminUsers",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);
			   
	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>User Administration</h2>
				<p>Gives Administrators the ability to add/edit website users.</p>
			</div>
			<div align="center">
				<input type="radio" name="usersInput" id="adduser" value="add"> Add New Website User
	 			<input type="radio" name="usersInput" id="edituser" value="edit" style="margin-left:20px"> Edit Existing Website User
	 			<input type="radio" name="usersInput" id="changepw" value="change" style="margin-left:20px"> Change A User's Password
			</div>
			
			<form name="form_admin_user_add" id="form_admin_user_add" method="post" action="scripts/process_admin_users.php" style="margin-top:50px">						
				<p align="center">Please enter the requested user information below:<br><br></p>
				<div align="center">
		 			<label class="user_form" for="add_name">Name: </label>
		 			<input type="text" name="add_name" id="add_name" class="center_text required" title="Please enter the individual's name"><br><br>
		 			<label class="user_form" for="add_user_name">Username: </label>
		 			<input type="text" name="add_user_name" id="add_user_name" class="center_text required" title="Please enter a username"><br><br>
		 			<label class="user_form" for="add_user_pw">Password: </label>
		 			<input type="password" name="add_user_pw" id="add_user_pw" class="center_text required" title="Please enter a password"><br><br>
		 			<label class="user_form" for="confirm_pw">Confirm Password: </label>
		 			<input type="password" name="confirm_pw" id="confirm_pw" class="center_text required" title="Please re-enter the password"><br><br>
		 			<label class="user_form" for="add_user_email">Email Address: </label>
		 			<input type="text" name="add_user_email" id="add_user_email" class="center_text email" title="Please enter a valid email address"><br><br>
		 			<label  class="user_form" for="groupID">User Group: </label>
		 			<?php
			 			$sql = ("SELECT group_id, group_name " .
			 				    "  FROM groups " .
			 				    "ORDER BY group_name");
			 					
			 			$result = mysql_query($sql)
			 				or die ("Unable to make the query: " . mysql_error());
			 				
			 			echo "<select autofocus name='groupID' id='groupID' class='text' style='width:175px'>";
			 			echo "<option value=''>Select a user group</option>";
		 				while ($row = mysql_fetch_array($result)) {
			 				echo "<option value='" . $row['group_id'] . "'>" . $row['group_name'] . "</option>";
			 			}
						echo "</select>";
				 	?>
		 		</div>
		 		<div>
		 			<p><br></p>
		 		</div>
		 		<div align="center">
		 			<ul>
		 				<li class="buttons">
						    <input type="hidden" name="form_id" value="submit_form_admin_user_add">
							<input type="submit" name="submitAddUser" id="submitAddUser" class="button_text" value="Create User">
							<input type="reset" name="clearAddUser" id="clearAddUser" class="button_text" value="Clear Form">
						</li>
		 			</ul>
		 		</div>
			</form>
			
			<div id="search_by_radio_buttons" align="center" style="margin-top:50px">
				<label class="user_search_form">Search By : </label>
				<input type="radio" name="search_by" id="search_by_name" value="search_by_name" title="User's Name">
				<label class="user_search_form" style="text-align:left"> Name</label><br>
				<label class="user_search_form">&nbsp;</label>
				<input type="radio" name="search_by" id="search_by_username" value="search_by_username" title="Username used to log in">
				<label class="user_search_form" style="text-align:left"> Username</label><br><br><br>
			</div>
			<form name="form_edit_users_name_search" id="form_edit_users_name_search" method="post" style="margin: 0 25px 10px" action="admin_users.php">
				<div id="search_for_name" align="center">		
		 			<label class="user_search_form" for="edit_user_name_search">Name: </label>
		 			<input type="text" name="edit_user_name_search" id="edit_user_name_search" class="center_text required"
		 				   title="Please enter the user's name"><br><br>
				</div>
				<ul>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_edit_users_name_search">
						<input type="submit" name="submitSearchUsersName" id="submitSearchUsersName" class="button_text" value="Search">
						<input type="reset" name="clearSearchUsersName" id="clearSearchUsersName" class="button_text" value="Cancel" onclick="window.location = window.location.pathname">
					</li>
				</ul>
			</form>
			
			<form name="form_edit_users_username_search" id="form_edit_users_username_search" method="post" style="margin: 0 25px 10px" action="admin_users.php">
				<div id="search_for_username" align="center">
		 			<label class="user_search_form" for="edit_user_username_search">Username: </label>
		 			<input type="text" name="edit_user_username_search" id="edit_user_username_search" class="center_text required"
		 				   title="Please enter the user's username (used to log in)"><br><br>
				</div>
				<ul>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_edit_users_username_search">
						<input type="submit" name="submitSearchUsersUsername" id="submitSearchUsersUsername" class="button_text" value="Search">
						<input type="reset" name="clearSearchUsersUsername" id="clearSearchUsersUsername" class="button_text" value="Cancel" onclick="window.location = window.location.pathname">
					</li>
				</ul>
			</form>
			
			<form name="form_list_users_search_results" id="form_list_users_search_results" method="post" style="margin:50px 0 25px 10px" action="admin_users.php">
				<?php
					if ($search == 1) {
						try {
							$sql = "SELECT * " .
								   "  FROM users u, user_groups ug, groups g " .
								   " WHERE name LIKE '%{$search_string}%' " .
								   "   AND username != 'SysAdmin4UnitedWay' " .
								   "   AND ug.user_id = u.user_id " .
								   "   AND g.group_id = ug.group_id " .
								   "ORDER BY name";
							
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for users", mysql_error());
					
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for user's name.",
					 			"Error searching for user: " . $exc->getMessage());
					 	}
					 }
					 if ($search == 2) {
						try {
							$sql = "SELECT * " .
								   "  FROM users u, user_groups ug, groups g " .
								   " WHERE u.username LIKE '%{$search_string}%' " .
								   "   AND u.username != 'SysAdmin4UnitedWay' " .
								   "   AND ug.user_id = u.user_id " .
								   "   AND g.group_id = ug.group_id " .
								   "ORDER BY u.name";
							
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for users", mysql_error());
					
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for user's username.",
					 			"Error searching for user: " . $exc->getMessage());
					 	}
					 }
					echo "				<center>";
					echo "				<table id='e_text' border=1 style='border: 1px solid #000; text-align:center; margin-top:15px'>";
					echo "					<th width='10px' border=1 style='border: 1px solid #000; background:#CCC'></th>";
					echo "					<th width='100px' border=1 style='border: 1px solid #000; background:#CCC'>Name</th>";
					echo "					<th width='100px' border=1 style='border: 1px solid #000; background:#CCC'>Username</th>";
					echo "					<th width='125px' border=1 style='border: 1px solid #000; background:#CCC'>Email Address</th>";
					echo "					<th width='100px' border=1 style='border: 1px solid #000; background:#CCC'>Group</th>";
					echo "					<th width='75px' border=1 style='border: 1px solid #000; background:#CCC'>Active?</th>";

					while ($row = mysql_fetch_array($result))
					{
						echo "					<tr>";
						echo "						<td border=1 style='border: 1px solid #000'><input type='radio' name='edit_user' id='edit_user' class='required' value='" . $row['user_id'] . "'</td>";
						echo "						<td border=1 style='border: 1px solid #000'>" . $row['name'] . "</td>";
						echo "						<td border=1 style='border: 1px solid #000'>" . $row['username'] . "</td>";
						echo "						<td border=1 style='border: 1px solid #000'>" . $row['email'] . "</td>";
						echo "						<td border=1 style='border: 1px solid #000'>" . $row['group_name'] . "</td>";
						echo "						<td border=1 style='border: 1px solid #000'>" . $row['active'] . "</td>";
						echo "					</tr>";
					}
					echo "				</table>";
					echo "				</center>";
					echo "				<ul>";
					echo "					<li class='buttons'>";
			    	echo "						<input type='hidden' name='form_id' value='submit_form_admin_users_edit'>";
					echo "						<input type='submit' name='submitEditUser' id='submitEditUser' class='button_text' value=' Edit '>";
					echo "						<input type='reset' name='clearEditUser' id='clearEditUser' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>";
					echo "					</li>";
					echo "				</ul>";
					
				?>
				
			</form>

			<form name="form_admin_users_edit_selection" id="form_admin_users_edit_selection" method="post" action="scripts/process_admin_users.php" style="margin-top:50px">
				<?php
					if ($modify == 1) {
						try {
							$sql = "SELECT u.user_id, " .
								   "	   u.name, " .
								   "	   u.username, " .
								   "	   u.email, " .
								   "       u.active, " .
								   "       g.group_id " .
								   "  FROM users u " . 
								   "INNER JOIN user_groups g " .
								   "    ON u.user_id = {$edit_id} " .
								   "   AND g.user_id = u.user_id " .
								   "ORDER BY u.name";
							
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for user", mysql_error());
					
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for user.",
					 			"Error searching for user: " . $exc->getMessage());
					 	}
					 	$row = mysql_fetch_array($result);
					 	$selected_group_id = $row['group_id'];
					 }
				?>
		 		<div align="center">
		 			<input type="hidden" name="edit_user_id" id="edit_user_id" value="<?php echo $row['user_id']; ?>">
		 			<label class="user_form" for="edit_name"> Name: </label>
		 			<input type="text" name="edit_name" id="edit_name" class="center_text required" 
		 				   title="Please enter the individual's name" value="<?php echo $row['name']; ?>"><br><br>
		 			<label class="user_form" for="edit_user_name">Username: </label>
		 			<input type="text" name="edit_user_name" id="edit_user_name" class="center_text required"
		 				   title="Please enter a username" value="<?php echo $row['username']; ?>"><br><br>
		 			<label class="user_form" for="edit_user_email">Email Address: </label>
		 			<input type="text" name="edit_user_email" id="edit_user_email" class="center_text email"
		 				   title="Please enter a valid email address" value="<?php echo $row['email']; ?>"><br><br>
		 			<label  class="user_form" for="groupID">User Group: </label>
		 			<?php
			 			$sql = ("SELECT group_id, " .
			 					"		group_name " .
			 				    "  FROM groups " .
			 				    "ORDER BY group_name");
			 					
			 			$result = mysql_query($sql)
			 				or die ("Unable to make the query: " . mysql_error());
			 		?>
		 			<select autofocus name='groupID' id='groupID' class='text' style='width:175px'>
		 			<?php 
		 				while ($row2 = mysql_fetch_array($result)) {
		 			?>
			 			<option value="<?php echo $row2['group_id']; ?>" <?php if ($row2['group_id'] == $selected_group_id) { echo 'selected';} ?>>
			 					<?php echo $row2['group_name']; ?></option>
			 		<?php }; ?>
					</select>
					</div>
				<div>
		 			<p><br></p>
		 		</div>
				<div id="active_inactive" align="center">
					<input type="radio" name="edit_user_active" id="edit_user_active_yes" value="1" title="Active" <?php if($row['active'] == 1) {echo 'checked';} ?>>
						<label for="edit_user_active_yes"> Active </label></input>
					<input type="radio" name="edit_user_active" id="edit_user_active_no" value="0" title="Inactive" <?php if($row['active'] == 0) {echo 'checked';} ?>>
						<label for="edit_user_active_no">Inactive</label></input><br>
				</div>
		 		<ul>
		 			<li class="buttons">
				    	<input type="hidden" name="form_id" value="submit_form_admin_users_edit_selection">
						<input id="submitEditUser" class="button_text" type="submit" name="submitEditUser" value=" Save ">
						<input id="clearEditUser" class="button_text" type="reset" name="clearEditUser" value="Cancel" onclick="window.location = window.location.pathname">
		 			</li>
				</ul>
			</form>
			
			<div id="search_by_radio_buttons2" align="center" style="margin-top:50px">
				<label class="user_search_form2">Search By : </label>
				<input type="radio" name="search_by2" id="password_search_by_name" value="password_search_by_name" title="User's Name">
				<label class="user_search_form" style="text-align:left"> Name</label><br>
				<label class="user_search_form">&nbsp;</label>
				<input type="radio" name="search_by2" id="password_search_by_username" value="password_search_by_username" title="Username used to log in">
				<label class="user_search_form" style="text-align:left"> Username</label><br><br><br>
			</div>
			
			<form name="form_change_password_name_search" id="form_change_password_name_search" method="post" style="margin: 0 25px 10px" action="admin_users.php">
				<div id="search_for_name" align="center">		
		 			<label class="password_user_search_form" for="edit_password_name_search">Name: </label>
		 			<input type="text" name="edit_password_name_search" id="edit_password_name_search" class="center_text required"
		 				   title="Please enter the user's name"><br><br>
				</div>
				<ul>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_change_password_name_search">
						<input type="submit" name="submitSearchUsersNamePassword" id="submitSearchUsersNamePassword" class="button_text" value="Search">
						<input type="reset" name="clearSearchUsersNamePassword" id="clearSearchUsersNamePassword" class="button_text" value="Cancel" onclick="window.location = window.location.pathname">
					</li>
				</ul>
			</form>
			
			<form name="form_change_password_username_search" id="form_change_password_username_search" method="post" style="margin: 0 25px 10px" action="admin_users.php">
				<div id="password_search_for_username" align="center">
		 			<label class="user_search_form" for="edit_password_username_search">Username: </label>
		 			<input type="text" name="edit_password_username_search" id="edit_password_username_search" class="center_text required"
		 				   title="Please enter the user's username (used to log in)"><br><br>
				</div>
				<ul>
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_form_change_password_username_search">
						<input type="submit" name="submitSearchUsersUsernamePassword" id="submitSearchUsersUsernamePassword" class="button_text" value="Search">
						<input type="reset" name="clearSearchUsersUsernamePassword" id="clearSearchUsersUsernamePassword" class="button_text" value="Cancel" onclick="window.location = window.location.pathname">
					</li>
				</ul>
			</form>
			
			<form name="form_list_change_password_users_search_results" id="form_list_change_password_users_search_results" method="post" style="margin:50px 0 25px 10px" action="admin_users.php">
				<?php
					if ($search == 3) {
						try {
							$sql = "SELECT * " .
								   "  FROM users u, user_groups ug, groups g " .
								   " WHERE name LIKE '%{$search_string}%' " .
								   "   AND username != 'SysAdmin4UnitedWay' " .
								   "   AND ug.user_id = u.user_id " .
								   "   AND g.group_id = ug.group_id " .
								   "ORDER BY name";
							
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for users", mysql_error());
					
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for user's name.",
					 			"Error searching for user: " . $exc->getMessage());
					 	}
					 }
					 if ($search == 4) {
						try {
							$sql = "SELECT * " .
								   "  FROM users u, user_groups ug, groups g " .
								   " WHERE u.username LIKE '%{$search_string}%' " .
								   "   AND u.username != 'SysAdmin4UnitedWay' " .
								   "   AND ug.user_id = u.user_id " .
								   "   AND g.group_id = ug.group_id " .
								   "ORDER BY u.name";
							
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for users", mysql_error());
					
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for user's username.",
					 			"Error searching for user: " . $exc->getMessage());
					 	}
					 }
					echo "				<center>";
					echo "				<table id='e2_text' border=1 style='border: 1px solid #000; text-align:center; margin-top:15px'>";
					echo "					<th width='10px' border=1 style='border: 1px solid #000; background:#CCC'></th>";
					echo "					<th width='100px' border=1 style='border: 1px solid #000; background:#CCC'>Name</th>";
					echo "					<th width='100px' border=1 style='border: 1px solid #000; background:#CCC'>Username</th>";
					echo "					<th width='125px' border=1 style='border: 1px solid #000; background:#CCC'>Email Address</th>";
					echo "					<th width='100px' border=1 style='border: 1px solid #000; background:#CCC'>Group</th>";
					echo "					<th width='75px' border=1 style='border: 1px solid #000; background:#CCC'>Active?</th>";

					while ($row = mysql_fetch_array($result))
					{
						echo "					<tr>";
						echo "						<td border=1 style='border: 1px solid #000'><input type='radio' name='edit_user_pw' id='edit_user_pw' class='required' value='" . $row['user_id'] . "'</td>";
						echo "						<td border=1 style='border: 1px solid #000'>" . $row['name'] . "</td>";
						echo "						<td border=1 style='border: 1px solid #000'>" . $row['username'] . "</td>";
						echo "						<td border=1 style='border: 1px solid #000'>" . $row['email'] . "</td>";
						echo "						<td border=1 style='border: 1px solid #000'>" . $row['group_name'] . "</td>";
						echo "						<td border=1 style='border: 1px solid #000'>" . $row['active'] . "</td>";
						echo "					</tr>";
					}
					echo "				</table>";
					echo "				</center>";
					echo "				<ul>";
					echo "					<li class='buttons'>";
			    	echo "						<input type='hidden' name='form_id' value='submit_form_list_change_password_users_search_results'>";
					echo "						<input type='submit' name='submitChangePassword' id='submitChangePassword' class='button_text' value='Change'>";
					echo "						<input type='reset' name='clearChangePassword' id='clearChangePassword' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>";
					echo "					</li>";
					echo "				</ul>";
					
				?>
				
			</form>

			<form name="form_admin_change_users_password" id="form_admin_change_users_password" method="post" action="scripts/process_admin_users_password.php" style="margin-top:50px">
				<?php
					if ($modifypassword == 1) {
						try {
							$sql = "SELECT u.user_id, " .
								   "	   u.name, " .
								   "	   u.username, " .
								   "	   u.email, " .
								   "       u.active, " .
								   "       g.group_id " .
								   "  FROM users u " . 
								   "INNER JOIN user_groups g " .
								   "    ON u.user_id = {$change_pw_id} " .
								   "   AND g.user_id = u.user_id " .
								   "ORDER BY u.name";
							
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for user", mysql_error());
					
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for user.",
					 			"Error searching for user: " . $exc->getMessage());
					 	}
					 	$row = mysql_fetch_array($result);
					 	$selected_group_id = $row['group_id'];
					 }
				?>
		 		<div align="center">
		 			<input type="hidden" name="change_pw_user_id" id="change_pw_user_id" value="<?php echo $row['user_id']; ?>">
		 			<input type="hidden" name="change_pw_username" id="change_pw_username" value="<?php echo $row['username']; ?>">
		 			<label class="user_form" for="change_pw_name"> Name: </label>
		 			<input type="text" name="change_pw_name" id="change_pw_name" class="center_text required" disabled="disabled"
		 				   title="Please enter the individual's name" value="<?php echo $row['name']; ?>"><br><br>
		 			<label class="user_form" for="change_pw_user_name">Username: </label>
		 			<input type="text" name="change_pw_user_name" id="change_pw_user_name" class="center_text required" disabled="disabled"
		 				   title="Please enter a username" value="<?php echo $row['username']; ?>"><br><br>
		 			<label class="user_form" for="change_pw_user_email">Email Address: </label>
		 			<input type="text" name="change_pw_user_email" id="change_pw_user_email" class="center_text email" disabled="disabled"
		 				   title="Please enter a valid email address" value="<?php echo $row['email']; ?>"><br><br>
		 			<label  class="user_form" for="change_pw_groupID">User Group: </label>
		 			<?php
			 			$sql = ("SELECT group_id, " .
			 					"		group_name " .
			 				    "  FROM groups " .
			 				    "ORDER BY group_name");
			 					
			 			$result = mysql_query($sql)
			 				or die ("Unable to make the query: " . mysql_error());
			 		?>
		 			<select autofocus name='change_pw_groupID' id='change_pw_groupID' class='text' style='width:175px' disabled="disabled">
		 			<?php 
		 				while ($row2 = mysql_fetch_array($result)) {
		 			?>
			 			<option value="<?php echo $row2['group_id']; ?>" <?php if ($row2['group_id'] == $selected_group_id) { echo 'selected';} ?>>
			 					<?php echo $row2['group_name']; ?></option>
			 		<?php }; ?>
					</select>
                     <br>
                    <br>
                    <br>
                    <label class="user_form" for="change_user_pw">New password: </label>
                    <input type="password" name="change_user_pw" id="change_user_pw" class="center_text required" title="Please enter a password"><br><br>
                    <label class="user_form" for="confirm_change_pw">Confirm Password: </label>
                    <input type="password" name="confirm_change_pw" id="confirm_change_pw" class="center_text required" title="Please re-enter the password">
		 		</div>
				<div>
		 			<p><br></p>
		 		</div>
				<div id="active_inactive" align="center">
					<input type="radio" name="change_pw_user_active" id="change_pw_user_active_yes" value="1" title="Active" <?php if($row['active'] == 1) {echo 'checked';} ?> disabled="disabled">
						<label for="change_pw_user_active_yes"> Active </label></input>
					<input type="radio" name="change_pw_user_active" id="change_pw_user_active_no" value="0" title="Inactive" <?php if($row['active'] == 0) {echo 'checked';} ?> disabled="disabled">
						<label for="change_pw_user_active_no">Inactive</label></input><br>
				</div>
		 		<ul>
		 			<li class="buttons">
				    	<input type="hidden" name="form_id" value="submit_form_admin_change_users_password">
						<input id="submitChangePassword" class="button_text" type="submit" name="submitChangePassword" value=" Save ">
						<input id="clearChangePassword" class="button_text" type="reset" name="clearChangePassword" value="Cancel" onclick="window.location = window.location.pathname">
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