<?php

$to = $_POST['email'];
$from = "databasebackup@unitedwayathenslimestone.com"; //the email address you want it from (the address does not have to exist to work)
$headers = "From: $from";
$subject = "United Way of Athens/Limestone Thanks You!";
$message = "Replace this with your custom email message";
$mailsent = mail($to, $subject, $message, $headers);

?>