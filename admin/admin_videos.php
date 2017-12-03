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
	// Current user groups are Administrators, Volunteers, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	authorize_user(array("Administrators"));


	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "searchAll",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

   admin_menu();

?>

<div id="admin_form_container">
  <div class="form_description" align="center">
    <h2>Admin - Edit Videos on Media Tab</h2>
    <p></p>
  </div>

  <div class="adminDefaults">
<!-- stuff goes here -->

<?php

$query = "SELECT * FROM vids";
$result = mysql_query($query) or die(mysql_error());

$titles = array();
$urls = array();
$desc = array();

while ($row = mysql_fetch_assoc($result)) {
	array_push($titles, $row["title"]);
	array_push($urls, $row["youtubeURL"]);
	array_push($desc, $row["description"]);
}

//after coming back from vidToDB.php
//this displays notification to users
if (isset( $_SESSION['note'] ) && $_SESSION['note'] == 'data_saved') {
    echo "Successfully updated video.\n";
		unset( $_SESSION['note']);
}
elseif (isset( $_SESSION['note'] ) && $_SESSION['note'] == 'data_deleted') {
    echo "Successfully deleted video.\n";
		unset( $_SESSION['note']);
}
elseif (isset( $_SESSION['note'] ) && $_SESSION['note'] == 'not_deleted') {
    echo "Error: unable to delete video.\n";
		unset( $_SESSION['note']);
}
elseif (isset( $_SESSION['note'] ) && $_SESSION['note'] == 'not_saved') {
	echo "Error: unable to update video.\n";
	unset( $_SESSION['note']);
}
elseif (isset( $_SESSION['note'] )) {
	unset( $_SESSION['note']);
}
echo "<br>";

?>

<div class="vidSection">
  <h4 class="vidHeading">Video 1</h4>
  <form action="vidToDB.php" method="post">

    <p>
      <label>
        Video Title: <input type="text" class="vidLayout" name="title" value="<?php echo $titles[0]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Video URL: <input type="text" class="vidLayout" name="url" value="<?php echo $urls[0]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Description: <input type="text" class="vidLayout" name="desc" value="<?php echo $desc[0]; ?>"/>
      </label>
    </p>

    <input type="hidden" name="objId" value="1">
    <input type="submit" id="btnAdmin" name="save_btn" value="Save"/>
		<input type="submit" id="btnAdmin" name="delete_btn" value="Delete" onclick="return confirm('Are you sure you want to delete the selected video?')"/>
  </form>

  <hr class="vidLine"/>
</div>

<div class="vidSection">
  <h4 class="vidHeading">Video 2</h4>
  <form action="vidToDB.php" method="post">

    <p>
      <label>
        Video Title: <input type="text" class="vidLayout" name="title" value="<?php echo $titles[1]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Video URL: <input type="text" class="vidLayout" name="url" value="<?php echo $urls[1]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Description: <input type="text" class="vidLayout" name="desc" value="<?php echo $desc[1]; ?>"/>
      </label>
    </p>

    <input type="hidden" name="objId" value="2">
		<input type="submit" id="btnAdmin" name="save_btn" value="Save"/>
		<input type="submit" id="btnAdmin" name="delete_btn" value="Delete" onclick="return confirm('Are you sure you want to delete the selected video?')"/>
  </form>

  <hr class="vidLine"/>
</div>

<div class="vidSection">
  <h4 class="vidHeading">Video 3</h4>
  <form action="vidToDB.php" method="post">

    <p>
      <label>
        Video Title: <input type="text" class="vidLayout" name="title" value="<?php echo $titles[2]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Video URL: <input type="text" class="vidLayout" name="url" value="<?php echo $urls[2]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Description: <input type="text" class="vidLayout" name="desc" value="<?php echo $desc[2]; ?>"/>
      </label>
    </p>

    <input type="hidden" name="objId" value="3">
		<input type="submit" id="btnAdmin" name="save_btn" value="Save"/>
		<input type="submit" id="btnAdmin" name="delete_btn" value="Delete" onclick="return confirm('Are you sure you want to delete the selected video?')"/>
  </form>

  <hr class="vidLine"/>
</div>

<div class="vidSection">
  <h4 class="vidHeading">Video 4</h4>
  <form action="vidToDB.php" method="post">

    <p>
      <label>
        Video Title: <input type="text" class="vidLayout" name="title" value="<?php echo $titles[3]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Video URL: <input type="text" class="vidLayout" name="url" value="<?php echo $urls[3]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Description: <input type="text" class="vidLayout" name="desc" value="<?php echo $desc[3]; ?>"/>
      </label>
    </p>

    <input type="hidden" name="objId" value="4">
		<input type="submit" id="btnAdmin" name="save_btn" value="Save"/>
		<input type="submit" id="btnAdmin" name="delete_btn" value="Delete" onclick="return confirm('Are you sure you want to delete the selected video?')"/>
  </form>

  <hr class="vidLine"/>
</div>

<div class="vidSection">
  <h4 class="vidHeading">Video 5</h4>
  <form action="vidToDB.php" method="post">

    <p>
      <label>
        Video Title: <input type="text" class="vidLayout" name="title" value="<?php echo $titles[4]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Video URL: <input type="text" class="vidLayout" name="url" value="<?php echo $urls[4]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Description: <input type="text" class="vidLayout" name="desc" value="<?php echo $desc[4]; ?>"/>
      </label>
    </p>

    <input type="hidden" name="objId" value="5">
		<input type="submit" id="btnAdmin" name="save_btn" value="Save"/>
		<input type="submit" id="btnAdmin" name="delete_btn" value="Delete" onclick="return confirm('Are you sure you want to delete the selected video?')"/>
  </form>

  <hr class="vidLine"/>
</div>

<div class="vidSection">
  <h4 class="vidHeading">Video 6</h4>
  <form action="vidToDB.php" method="post">

    <p>
      <label>
        Video Title: <input type="text" class="vidLayout" name="title" value="<?php echo $titles[5]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Video URL: <input type="text" class="vidLayout" name="url" value="<?php echo $urls[5]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Description: <input type="text" class="vidLayout" name="desc" value="<?php echo $desc[5]; ?>"/>
      </label>
    </p>

    <input type="hidden" name="objId" value="6">
		<input type="submit" id="btnAdmin" name="save_btn" value="Save"/>
		<input type="submit" id="btnAdmin" name="delete_btn" value="Delete" onclick="return confirm('Are you sure you want to delete the selected video?')"/>
  </form>

  <hr class="vidLine"/>
</div>

<div class="vidSection">
  <h4 class="vidHeading">Video 7</h4>
  <form action="vidToDB.php" method="post">

    <p>
      <label>
        Video Title: <input type="text" class="vidLayout" name="title" value="<?php echo $titles[6]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Video URL: <input type="text" class="vidLayout" name="url" value="<?php echo $urls[6]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Description: <input type="text" class="vidLayout" name="desc" value="<?php echo $desc[6]; ?>"/>
      </label>
    </p>

    <input type="hidden" name="objId" value="7">
		<input type="submit" id="btnAdmin" name="save_btn" value="Save"/>
		<input type="submit" id="btnAdmin" name="delete_btn" value="Delete" onclick="return confirm('Are you sure you want to delete the selected video?')"/>
  </form>

  <hr class="vidLine"/>
</div>

<div class="vidSection">
  <h4 class="vidHeading">Video 8</h4>
  <form action="vidToDB.php" method="post">

    <p>
      <label>
        Video Title: <input type="text" class="vidLayout" name="title" value="<?php echo $titles[7]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Video URL: <input type="text" class="vidLayout" name="url" value="<?php echo $urls[7]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Description: <input type="text" class="vidLayout" name="desc" value="<?php echo $desc[7]; ?>"/>
      </label>
    </p>

    <input type="hidden" name="objId" value="8">
		<input type="submit" id="btnAdmin" name="save_btn" value="Save"/>
		<input type="submit" id="btnAdmin" name="delete_btn" value="Delete" onclick="return confirm('Are you sure you want to delete the selected video?')"/>
  </form>

  <hr class="vidLine"/>
</div>

<div class="vidSection">
  <h4 class="vidHeading">Video 9</h4>
  <form action="vidToDB.php" method="post">

    <p>
      <label>
        Video Title: <input type="text" class="vidLayout" name="title" value="<?php echo $titles[8]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Video URL: <input type="text" class="vidLayout" name="url" value="<?php echo $urls[8]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Description: <input type="text" class="vidLayout" name="desc" value="<?php echo $desc[8]; ?>"/>
      </label>
    </p>

    <input type="hidden" name="objId" value="9">
		<input type="submit" id="btnAdmin" name="save_btn" value="Save"/>
		<input type="submit" id="btnAdmin" name="delete_btn" value="Delete" onclick="return confirm('Are you sure you want to delete the selected video?')"/>
  </form>

  <hr class="vidLine"/>
</div>

<div class="vidSection">
  <h4 class="vidHeading">Video 10</h4>
  <form action="vidToDB.php" method="post">

    <p>
      <label>
        Video Title: <input type="text" class="vidLayout" name="title" value="<?php echo $titles[9]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Video URL: <input type="text" class="vidLayout" name="url" value="<?php echo $urls[9]; ?>"/>
      </label>
    </p>

    <p>
      <label>
        Description: <input type="text" class="vidLayout" name="desc" value="<?php echo $desc[9]; ?>"/>
      </label>
    </p>

    <input type="hidden" name="objId" value="10">
		<input type="submit" id="btnAdmin" name="save_btn" value="Save"/>
		<input type="submit" id="btnAdmin" name="delete_btn" value="Delete" onclick="return confirm('Are you sure you want to delete the selected video?')"/>
  </form>
</div>
<!-- End content -->

  </div>
</div>
<div class="footer">
  Designed by Athens State University
</div>
</body>
</html>
