<?php
	
	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['action']);
	$disaster_id = mysql_real_escape_string($_REQUEST['id']);
	
	if ($processType == 'approve') {
	
	try {
				
		$update_sql = "UPDATE disaster SET admin_review = 1 WHERE disaster_id = {$disaster_id}";
				  
		mysql_query($update_sql)
				or handle_error("an error occurred while updating disaster", mysql_error());
	
	} catch (Exception $exc) {
		handle_error("something went wrong while attempting to save agency disaster.",
					 "Error saving disaster: " . $exc->getMessage());
	}
	// Redirect to view disaster page
	$msg = "The disaster has been successfully approved and updated.";
	header("Location: /admin/admin_reviews_disaster.php?success_message=" . $msg);
	exit();
	
	} else if ($processType == 'delete') {
	
	try {

		$delete_opp_query = "DELETE FROM disaster_member_names WHERE disaster_id = {$disaster_id}";

		mysql_query($delete_opp_query)
				or handle_error("an error occurred while deleting the disaster members", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete disaster.",
						 "Error deleting disaster: " . $exc->getMessage());
		}
		
	try {

		$delete_opp_query = "DELETE FROM disaster WHERE disaster_id = {$disaster_id}";
			
		mysql_query($delete_opp_query)
				or handle_error("an error occurred while deleting the disaster", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete disaster.",
						 "Error deleting disaster: " . $exc->getMessage());
		}
		
		// Redirect to view disaster info
		$msg = "The disaster has been successfully deleted.";
		header("Location: /admin/admin_reviews_disaster.php?success_message=" . $msg);
		exit();
	}
		
	$msg = "Unable to Process.";
	header("Location: /admin/admin_reviews_disaster.php?success_message=" . $msg);
		
	exit();
?>