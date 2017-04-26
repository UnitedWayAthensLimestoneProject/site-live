<?php
session_start(); // Session starts here.
?>
<!DOCTYPE HTML>
<html>
 <head>
 <title>Disaster Relief Form - United Way of Athens/Limstone County</title>
 <link rel="stylesheet" href="style.css" />
 </head>
 <body>
 <div class="container">
 <div class="main">
 <h2>Disaster Relief Form Part 1 of 4</h2>
 
 <span id="error">

 <?php
 if (!empty($_SESSION['error'])) {
 echo $_SESSION['error'];
 unset($_SESSION['error']);
 }
 ?>
 </span>

 <form action="page2_form.php" method="post">
 <label>First Name :<span>*</span></label>
 <input name="first_name" type="text" required>
 <label>Last Name :<span>*</span></label>
 <input name="last_name" type="text" required>
 <label>Email :<span>*</span></label>
 <input name="email" type="email" placeholder="Ex-anderson@gmail.com" required><br><br>
 <label>Date Of Birth :</label>
 <input type="date" id ="dob" name ="dob" required><br><br>
 <label>Home Phone :<span>*</span></label>
 <input name="home_phone" type="text" placeholder="###-###-####">
 <label>Cell Phone :<span>*</span></label>
 <input name="cell_phone" type="text" placeholder="###-###-####">

<hr>
 <label class ="description" for "interview"> Do you have an interview with a United Way employee? </label>

		<input  type ="radio" id ="interview_yes" name ="interview" value="1" title ="*PLEASE LET US KNOW IF YOU HAVE AN INTERVIEW "/>
		<label class ="choice" for ="interview_yes">Yes</label>

		<input type="radio" id="interview_no" name="interview" value="0"  />
		<label class="choice" for="interview_no">No</label><br><br>

		<label>If Yes:</label><br><br>
		<label class="description" for="interview_date">Interview Date :</label>
		<input type="date" name ="date_of_interview" id="date_of_interview"/><br><br>

		<label class ="description" for="event_date">Event Date :  </label>
		<input type="date" name ="date_of_event" id="date_of_event"/><br><br>

 <input type="reset" value="Reset" />
 <input type="submit" value="Next" />
 </form>
 </div>
 </div>
 </body>
</html>