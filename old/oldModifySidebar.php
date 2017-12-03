<!DOCTYPE html>
<!-- CainASG21_Code.php
PHP project - Fibonacci
-->
<html lang="en-US">
<head>
<title>Modify Sidebar</title>
<meta charset = "utf-8" />
</head>
<body>

<h1>Modify Sidebar</h1>

<form action='' method='POST' enctype='multipart/form-data'>
<input type='file' name='userFile'><br>
<input type='submit' name='upload_btn' value='Process'>
</form>

<?php
$info = pathinfo($_FILES['userFile']['name']);
$ext = $info['extension']; 
$newname = "sidebar9.".$ext;

$target = 'images/sidebar_big/'.$newname;
move_uploaded_file($_FILES['userFile']['tmp_name'], $target);
?>

</body>
</html>