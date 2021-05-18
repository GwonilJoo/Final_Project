<?php
session_start();
if(isset($_POST['submit_image']))
{
  $uploadfile=$_FILES["upload_file"]["tmp_name"];
  $folder="../Dataset/".$_SESSION['id']."/";
  echo "<script type=\"text/javascript\">alert(\"$folder\");</script>";
  move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder.$_FILES["upload_file"]["name"]);
  chmod($folder.$_FILES["upload_file"]["name"],0777);

  include 'unzip.php';
  exit();
}

// if(isset($_POST['submit_image']))
// {
//   $foldername= "../Dataset/".$_SESSION['id']."/";
//   foreach($_FILES['upload_file']['tmp_name'] as $i => $name)
//   {
//       if(strlen($_FILES['upload_file']['tmp_name'][$i]) > 1)
//       {
//         move_uploaded_file($_FILES['upload_file']['tmp_name'][$i],$foldername."/".$name);
//       }
//   }
//   // echo '<script>alert("Folder is successfully uploaded")</script>';
//   exit();
// }
// else{
//   // echo '<script>alert("Upload folder name is empty")</script>';
//   exit();
// }
    
?>