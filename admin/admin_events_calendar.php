<?php
	
	//Need to build a database to connect this to
	require_once("db_connection.php");
	
	//Query Database for any current entries
	
	$query = "SELECT * FROM calendar";
	$event_set = mysqli_query($connection, $query);


	if (isset ($_POST['submit']))
	{
		$datetimedb = mysql_prep($_POST["datetime"]);
		$locationdb = mysql_prep($_POST["location"]);
		$eventdb = mysql_prep($_POST["event"]);
		
		
	}

	
	function mysql_prep($string)
	{
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}



	
	function update_events()
	{
		global $connection;
		$query= "UPDATE calendar SET";
		$query= "date = '{$date}', " ;
		$query= "event = '{$event}', " ;
		$query= "location = '{$location}'," ;
		$result = mysqli_query($connection,$query);

	}

	function insert_events()
	{
		global $connection;
		$query= "INSERT INTO calendar (date, event, location) VALUES (";
		$query= " '{$date}' , '{$event}' , '{$location}' ";
		$query= ")";
		$result= mysqli_query($connection,$query);
	}

	function delete_events($event)
	{
		$query= "DELETE FROM calendar";
		$query= "WHERE id = {$event}";
	}
	
	
	$date = "YYYY-DD-MM HH-MM-SS";
	$time = "Time";
	$event = "Event Name";
	$location = "Location";
	



?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>



<div class="admin_form_container">

	<div class="form_description" align="center">
				<h2>Event Administration</h2>
			</div>	
			
			<div id="editvoltable"></div>
			
	<form action = "admin_events_calendar.php" method= "post">
	
		<?php if (mysqli_num_rows($event_set) > 0)
				{
					while($row = mysqli_fetch_assoc($event_set))
					{?>
						<input type = "datetime" name = "datetime" value="<?php echo htmlspecialchars($row['date']); ?>"    onblur="if (this.value == '') {this.value = '<?php echo htmlspecialchars($row['date']); ?>';}"
 						onfocus="if (this.value == '<?php echo htmlspecialchars($row['date']); ?>') {this.value = '';}" maxlength="40" required>
 						<input type = "text" name = "event" value="<?php echo htmlspecialchars($row['event']); ?>"    onblur="if (this.value == '') {this.value = '<?php echo htmlspecialchars($row['event']); ?>';}"
 						onfocus="if (this.value == '<?php echo htmlspecialchars($event); ?>') {this.value = '';}" maxlength="100" required>
 						
						<input type = "text" name = "location" value="<?php echo htmlspecialchars($row['location']); ?>"    onblur="if (this.value == '') {this.value = '<?php echo htmlspecialchars($row['location']); ?>';}"
 						onfocus="if (this.value == '<?php echo htmlspecialchars($location); ?>') {this.value = '';}" maxlength="150" required> &nbsp;&nbsp; <input type="checkbox" name = "delete"value="<?php echo htmlspecialchars($row['id']); ?>"><br><br>
 						<?php
					}
					?>
					
					<input type="submit" value = "Update"> &nbsp;&nbsp;
					<select>
						<option></option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select> &nbsp;&nbsp; Add Event
					
					<?php
				}
		else 
		{
			
			?>
		
		</form>	
		
		
		<input type = "datetime" name = "date" value="<?php echo htmlspecialchars($date); ?>"    onblur="if (this.value == '') {this.value = '<?php echo htmlspecialchars($date); ?>';}"
 						onfocus="if (this.value == '<?php echo htmlspecialchars($date); ?>') {this.value = '';}" maxlength="10" required>
 		<input type = "text" name = "event" value="<?php echo htmlspecialchars($event); ?>"    onblur="if (this.value == '') {this.value = '<?php echo htmlspecialchars($event); ?>';}"
 						onfocus="if (this.value == '<?php echo htmlspecialchars($event); ?>') {this.value = '';}" maxlength="100" required>
 			
		<input type = "text" name = "location" value="<?php echo htmlspecialchars($location); ?>"    onblur="if (this.value == '') {this.value = '<?php echo htmlspecialchars($location); ?>';}"
 						onfocus="if (this.value == '<?php echo htmlspecialchars($location); ?>') {this.value = '';}" maxlength="150" required><input type="checkbox" name = "delete"value="<?php echo htmlspecialchars($row['id']); ?>"><br><br>
 						
 		<input type="submit" value = "Update"> &nbsp;&nbsp;
					<select>
						<option></option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select> &nbsp;&nbsp; Add Event					
	</form>
	<?php
			
		}
		?>
	
		
</div>
	
	

<body>
</body>
</html>