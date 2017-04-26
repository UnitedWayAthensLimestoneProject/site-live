<?php
	
	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['action']);
	$vol_id = mysql_real_escape_string($_REQUEST['id']);
	
	if ($processType == 'approve') {
	
	try {
				
		$update_sql = "UPDATE volunteers SET admin_review=1, active=1 WHERE vol_id = {$vol_id}";
				  
		mysql_query($update_sql)
				or handle_error("an error occurred while updating volunteer", mysql_error());
	
	} catch (Exception $exc) {
		handle_error("something went wrong while attempting to save agency volunteer.",
					 "Error saving volunteer: " . $exc->getMessage());
	}
	// Redirect to view volunteer page
	$msg = "The volunteer has been successfully approved and updated.";
	header("Location: /admin/admin_reviews_vols.php?success_message=" . $msg);
	exit();
	
	} else if ($processType == 'delete') {
	
	try {

		$delete_opp_query = "DELETE FROM vol_skill WHERE vol_id = {$vol_id}";

		mysql_query($delete_opp_query)
				or handle_error("an error occurred while deleting the volunteer skills ", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete volunteer.",
						 "Error deleting volunteer: " . $exc->getMessage());
		}
		
	try {

		$delete_opp_query = "DELETE FROM volunteers WHERE vol_id = {$vol_id}";
			
		mysql_query($delete_opp_query)
				or handle_error("an error occurred while deleting the volunteer", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete volunteer.",
						 "Error deleting volunteer: " . $exc->getMessage());
		}
		
		// Redirect to view volunteer info
		$msg = "The volunteer has been successfully deleted.";
		header("Location: /admin/admin_reviews_vols.php?success_message=" . $msg);
		exit();
	}
		
	$msg = "Unable to Process.";
	header("Location: /admin/admin_reviews_vols.php?success_message=" . $msg);
		
	exit();
?>