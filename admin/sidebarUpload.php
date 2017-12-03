<?php

session_start();

$uploaded = false;
$filename = $_FILES['file']['name']; //original name of uploaded file
$tmp_name = $_FILES['file']['tmp_name']; //where file is named/placed temporarily
$defaultName = $_POST['sBar']; //hidden value
//define('ROOT_PATH', dirname(__DIR__) . '/');
if (!defined('ROOT_PATH')) define('ROOT_PATH', dirname(__DIR__) . '/');
$dir = ROOT_PATH.'sidebarImgs/';
$filesAry = scandir($dir); //used to delete old file
$randNum = mt_rand(1000,9999); //generates 4 digit random number
$randNumString = strval($randNum); //4 digit random string

if (isset($filename)){
  if (!empty($filename)) {
    $fileExtBefore = (explode('.', $filename));
    $fileExt = strtolower(end($fileExtBefore));
    $allowedExt = array('jpg', 'jpeg', 'png', 'gif');

    //verify file is correct filetype
    if (in_array($fileExt, $allowedExt))
    {
      $randName = $defaultName . $randNumString; // e.g. sidebar1####
      $newName = $randName . '.' . $fileExt;

      //delete old file
      foreach ($filesAry as $file) {
        if(strpos($file, $defaultName) !== false) {
          $absPath = ROOT_PATH.'sidebarImgs/' . $file;
          unlink ($absPath);
        }
      }

      //put new file with appended random numbers to name into sidebarImgs dir
      $location = ROOT_PATH.'sidebarImgs/';
      if(move_uploaded_file($tmp_name, $location.$newName)) {
        //echo 'File uploaded successfully';
        $uploaded = true;
      }
    } else {
      //echo 'File type not supported';
      $uploaded = false;
    }
  }
} else {
  //echo 'Please choose a file';
}

if ($uploaded) {
  $_SESSION['note'] = 'data_saved';
}
else {
  $_SESSION['note'] = 'not_saved';
}

//redirect back to admin_sidebar.php
//DO NOT output anything before this or this call will not work
//also cannot use any plain HTML before this call
header('Location: admin_sidebar.php');
exit;
?>
