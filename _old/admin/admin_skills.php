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
	
	if(isset($_POST['edit_skill_search'])) {
		$search = 1;
		$search_string = mysql_real_escape_string(trim($_POST['edit_skill_search']));
		
		$javascript = <<<EOD
	$(document).ready(function() {
		
		$( '#form_admin_skills_add, #form_admin_skills_edit, #form_edit_skills_search, #form_admin_skills_edit_selection' ).hide();
		$( '#form_list_skills_search_results' ).show();
		$( '#editskill' ).prop('checked', true);
		
		$( '#addskill' ).click(function() {
			$( '#form_edit_skills_search, #form_list_skills_search_results' ).hide();
			$( '#edit_skill_search' ).val('');
			$( '#form_admin_skills_add' ).show();
			$( '#add_skill_name' ).focus();
		});
		
		$( '#editskill' ).click(function() {
			$( '#form_admin_skills_add' ).hide();
			$( '#add_skill_name' ).val('');
			$( '#add_skill_group' ).val('');
			$( '#add_skill_comments' ).val('');
			$( '#form_edit_skills_search' ).show();
			$( '#edit_skill_search' ).focus();
		});
		
		$('#form_admin_skills_add').validate( {
			errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.appendTo( element.parent()); 
		        } else {
		          error.insertAfter(element);
		        } 
		    }
		});
		
		$('#form_edit_skills_search').validate( {
			errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.appendTo( element.parent()); 
		        } else {
		          error.insertAfter(element);
		        } 
		    }
		});
		
		$('#form_list_skills_search_results').validate( {
			errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.insertAfter( '#e_text' );
		        } else {
		          error.insertAfter(element);
		        } 
		    },
			messages: {
				edit_skill: {
					required: "<br>Select a row to edit."
				}
			}
		});
		
		
	}); // end ready
EOD;

	} else if(isset($_POST['edit_skill'])) {
		
		$modify = 1;
		$edit_id = $_POST['edit_skill'];

		$javascript = <<<EOD
	$(document).ready(function() {
		
		$( '#form_admin_skills_add, #form_admin_skills_edit, #form_edit_skills_search, #form_list_skills_search_results' ).hide();
		$( '#form_admin_skills_edit_selection' ).show();
		$( 'input#edit_skill_enabled_yes, input#edit_skill_enabled_no' ).button();
		$( 'div#enabled_disabled' ).buttonset();
		$( '#editskill' ).prop('checked', true);
		
		if ($( '#edit_skill_enabled_yes' ).attr('checked') == 'checked') {
			$( '#edit_skill_enabled_yes' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
			$( '#edit_skill_enabled_no' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
		} else {
			$( '#edit_skill_enabled_yes' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
			$( '#edit_skill_enabled_no' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
		};
		
		$( '#edit_skill_enabled_yes' ).click(function() {
			$( '#edit_skill_enabled_yes' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
			$( '#edit_skill_enabled_no' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
		});
		
		$( '#edit_skill_enabled_no' ).click(function() {
			$( '#edit_skill_enabled_yes' ).button( {
				icons : { secondary : 'ui-icon-bullet' }
			});
			$( '#edit_skill_enabled_no' ).button( {
				icons : { secondary : 'ui-icon-check' }
			});
		});
		
		$( '#addskill' ).click(function() {
			$( '#form_edit_skills_search, #form_admin_skills_edit_selection' ).hide();
			$( '#edit_skill_search' ).val('');
			$( '#form_admin_skills_add' ).show();
			$( '#add_skill_name' ).focus();
		});
		
		$( '#editskill' ).click(function() {
			$( '#form_admin_skills_add' ).hide();
			$( '#add_skill_name' ).val('');
			$( '#add_skill_group' ).val('');
			$( '#add_skill_comments' ).val('');
			$( '#form_edit_skills_search' ).show();
			$( '#edit_skill_search' ).focus();
		});
	}); // end ready
EOD;

	} else {
	
		$search = 0;
		$modify = 0;
		$search_string = "";
	
		// Add any page specific javascript here.
		$javascript = <<<EOD
	$(document).ready(function() {
		
		$( '#form_admin_skills_add, #form_edit_skills_search, #form_admin_skills_edit, #form_list_skills_search_results, #form_admin_skills_edit_selection' ).hide();
		
		$( '#addskill' ).click(function() {
			$( '#messages, #success, #error, #form_edit_skills_search' ).hide();
			$( '#edit_skill_search' ).val('');
			$( '#form_admin_skills_add' ).show();
			$( '#add_skill_name' ).focus();
		});
		
		$( '#editskill' ).click(function() {
			$( '#messages, #success, #error, #form_admin_skills_add' ).hide();
			$( '#add_skill_name' ).val('');
			$( '#add_skill_group' ).val('');
			$( '#add_skill_comments' ).val('');
			$( '#form_edit_skills_search' ).show();
			$( '#edit_skill_search' ).focus();
		});
		
		$('#form_admin_skills_add').validate( {
			errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.appendTo( element.parent()); 
		        } else {
		          error.insertAfter(element);
		        } 
		    }
		});
		
		$('#form_edit_skills_search').validate( {
			errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.appendTo( element.parent()); 
		        } else {
		          error.insertAfter(element);
		        } 
		    }
		});
		
		$('#form_list_skills_search_results').validate( {
			errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.appendTo( element.parent()); 
		        } else {
		          error.insertAfter(element);
		        } 
		    }
		});
		
	}); // end ready
EOD;
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminSkills",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Skills Administration</h2>
				<p>Gives Administrators the ability to add/edit skills.</p>
			</div>
			<div align="center">
				<input type="radio" name="skillsInput" id="addskill" value="add"> Add New Skill
	 			<input type="radio" name="skillsInput" id="editskill" value="edit" style="margin-left:20px"> Edit Existing Skill
			</div>			
			
			<form name="form_admin_skills_add" id="form_admin_skills_add" method="post" action="scripts/process_admin_skills.php" style="margin-top:50px">	
		 		<div align="center">
		 			<label for="add_skill_name">&nbsp;Skill Name: </label>
		 			<input type="text" name="add_skill_name" id="add_skill_name" class="text required" title="Please enter a skill name"><br><br>
		 			<label for="add_skill_group">Skill Group: </label>
		 			<input type="text" name="add_skill_group" id="add_skill_group" class="text required" title="Please enter a skill group"><br>
		 		</div>
		 		<div>
		 			<p><br></p>
		 		</div>
		 		<div style="width:250px; margin-left:auto; margin-right:auto">
					<label for="add_skill_comments" class="label">Comments</label><br>
					<textarea name="add_skill_comments" cols="35" rows="4" id="add_skill_comments"></textarea>
				</div>
		 		<ul>
		 			<li class="buttons">
				    	<input type="hidden" name="form_id" value="submit_form_admin_skills_add">
						<input type="submit" name="submitAddSkill" id="submitAddSkill" class="button_text" value="Save Skill">
						<input type="reset" name="clearAddSkill" id="clearAddSkill" class="button_text" value="Clear Form">
		 			</li>
				</ul>
			</form>
			
			<form name="form_edit_skills_search" id="form_edit_skills_search" method="post" style="margin:50px 0 25px 10px" action="admin_skills.php">
				<div align="center">
		 			<label for="edit_skill_search">Enter a Skill Name: </label><br>
		 			<input type="text" name="edit_skill_search" id="edit_skill_search" class="center_text required" value="<?php echo $search_string ?>" title="Please enter a skill name" size="40"><br><br>
				</div>
				<ul>
		 			<li class="buttons">
				    	<input type="hidden" name="form_id" value="submit_form_edit_skills_search">
						<input type="submit" name="submitSearchSkills" id="submitSearchSkills" class="button_text" value="Search">
						<input type="reset" name="clearSearchSkills" id="clearSearchSkills" class="button_text" value="Cancel" onclick="window.location = window.location.pathname">
		 			</li>
				</ul>
			</form>
			
			<form name="form_list_skills_search_results" id="form_list_skills_search_results" method="post" style="margin:50px 0 25px 10px" action="admin_skills.php">
				<?php
					if ($search == 1) {
						try {
							$skill_search = mysql_real_escape_string(trim($_REQUEST['edit_skill_search']));
							
							$sql = "SELECT * FROM skill WHERE skill_name LIKE '%{$skill_search}%' ORDER BY skill_name";
							
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for skills", mysql_error());
					
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for skill name.",
					 			"Error searching for skill: " . $exc->getMessage());
					 	}
					 	
						echo "				<center>";
						echo "				<table id='e_text' border=1 style='border: 1px solid #000; text-align:center; margin-top:15px'>";
						echo "					<th width='10px' border=1 style='border: 1px solid #000; background:#CCC'></th>";
						echo "					<th width='100px' border=1 style='border: 1px solid #000; background:#CCC'>Skill</th>";
						echo "					<th width='100px' border=1 style='border: 1px solid #000; background:#CCC'>Group</th>";
						echo "					<th width='100px' border=1 style='border: 1px solid #000; background:#CCC'>Comments</th>";
						echo "					<th width='75px' border=1 style='border: 1px solid #000; background:#CCC'>Enabled?</th>";

						while ($row = mysql_fetch_array($result))
						{
							echo "					<tr>";
							echo "						<td border=1 style='border: 1px solid #000'><input type='radio' name='edit_skill' id='edit_skill' class='required' value='" . $row['skill_id'] . "'</td>";
							echo "						<td border=1 style='border: 1px solid #000'>" . $row['skill_name'] . "</td>";
							echo "						<td border=1 style='border: 1px solid #000'>" . $row['skill_group'] . "</td>";
							echo "						<td border=1 style='border: 1px solid #000'>" . $row['skill_comments'] . "</td>";
							echo "						<td border=1 style='border: 1px solid #000'>" . $row['enabled'] . "</td>";
							echo "					</tr>";
						}
						echo "				</table>";
						echo "				</center>";
						echo "				<ul>";
						echo "					<li class='buttons'>";
				    	echo "						<input type='hidden' name='form_id' value='submit_form_admin_skills_edit'>";
						echo "						<input id='submitEditSkill' class='button_text' type='submit' name='submitEditSkill' value=' Edit '>";
						echo "						<input id='clearEditSkill' class='button_text' type='reset' name='clearEditSkill' value='Cancel' onclick='window.location = window.location.pathname'>";
						echo "					</li>";
						echo "				</ul>";
					}
				?>
				
			</form>
			
			<form name="form_admin_skills_edit_selection" id="form_admin_skills_edit_selection" method="post" action="scripts/process_admin_skills.php" style="margin-top:50px">
				<?php
					if ($modify == 1) {
						try {
							$sql = "SELECT * FROM skill WHERE skill_id = '{$edit_id}'";
							
							$result = mysql_query($sql)
								or handle_error("an error occurred while searching for skills", mysql_error());
					
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for skill name.",
					 			"Error searching for skill: " . $exc->getMessage());
					 	}
					 	$row = mysql_fetch_array($result);
					 	
					 }
				?>
		 		<div align="center">
		 			<input type="hidden" name="edit_skill_id" id="edit_skill_id" value="<?php echo $row['skill_id']; ?>">
		 			<label for="edit_skill_name">&nbsp;Skill Name: </label>
		 			<input type="text" name="edit_skill_name" id="edit_skill_name" class="text required" title="Skill Name" value="<?php echo $row['skill_name']; ?>"><br><br>
		 			<label for="edit_skill_group">Skill Group: </label>
		 			<input type="text" name="edit_skill_group" id="edit_skill_group" class="text required" title="Skill Group" value="<?php echo $row['skill_group']; ?>"><br>
		 		</div>
		 		<div>
		 			<p><br></p>
		 		</div>
		 		<div style="width:250px; margin-left:auto; margin-right:auto">
					<label for="edit_skill_comments" class="label">Comments</label><br>
					<textarea name="edit_skill_comments" cols="35" rows="4" id="edit_skill_comments"><?php echo $row['skill_comments']; ?></textarea>
				</div>
				<div>
		 			<p><br></p>
		 		</div>
				<div id="enabled_disabled" align="center">
					<input type="radio" name="edit_skill_enabled" id="edit_skill_enabled_yes" value="1" title="Enabled" <?php if($row['enabled'] == 1) {echo 'checked';} ?>>
						<label for="edit_skill_enabled_yes">Enabled</label></input>
					<input type="radio" name="edit_skill_enabled" id="edit_skill_enabled_no" value="0" title="Disabled" <?php if($row['enabled'] == 0) {echo 'checked';} ?>>
						<label for="edit_skill_enabled_no">Disabled</label></input>
				</div>
		 		<ul>
		 			<li class="buttons">
				    	<input type="hidden" name="form_id" value="submit_form_admin_skills_edit_selection">
						<input id="submitEditSkill" class="button_text" type="submit" name="submitEditSkill" value=" Save ">
						<input id="clearEditSkill" class="button_text" type="reset" name="clearEditSkill" value="Cancel" onclick="window.location = window.location.pathname">
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