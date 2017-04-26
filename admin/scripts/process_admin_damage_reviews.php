<?php
	
	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['action']);
	$damage_id = mysql_real_escape_string($_REQUEST['id']);
	
	if ($processType == 'approve') {
	
	try {
				
		$update_sql = "UPDATE damage SET admin_review = 1 WHERE damage_id = {$damage_id}";
				  
		mysql_query($update_sql)
				or handle_error("an error occurred while updating damage", mysql_error());
	
	} catch (Exception $exc) {
		handle_error("something went wrong while attempting to save agency damage.",
					 "Error saving damage: " . $exc->getMessage());
	}
	// Redirect to view damage page
	$msg = "The damage has been successfully approved and updated.";
	header("Location: /admin/admin_reviews_damage.php?success_message=" . $msg);
	exit();
	
	} else if ($processType == 'delete') {
	
	try {

		$delete_opp_query = "DELETE FROM damage_member_names WHERE damage_id = {$damage_id}";

		mysql_query($delete_opp_query)
				or handle_error("an error occurred while deleting the damage members", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete damage.",
						 "Error deleting damage: " . $exc->getMessage());
		}

	try {

		$delete_opp_query = "DELETE FROM damage WHERE damage_id = {$damage_id}";
			
		mysql_query($delete_opp_query)
				or handle_error("an error occurred while deleting the damage", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete damage.",
						 "Error deleting damage: " . $exc->getMessage());
		}
		
		// Redirect to view damage info
		$msg = "The damage has been successfully deleted.";
		header("Location: /admin/admin_reviews_damage.php?success_message=" . $msg);
		exit();
	}
		
	$msg = "Unable to Process.";
	header("Location: /admin/admin_reviews_damage.php?success_message=" . $msg);
		
	exit();
?>