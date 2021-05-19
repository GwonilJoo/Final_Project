<?php
session_start();
if(isset($_POST['submit_image']))
{
  $uploadfile=$_FILES["upload_file"]["tmp_name"];
  $folder="../Learning/tmp/";

  $string = explode( '.', $_FILES["upload_file"]["name"]);
  $ex = $string[count($string)-1];
  $file = $folder."input.".$ex;
  
  // echo "<script type=\"text/javascript\">alert(\"$file\");</script>";
  move_uploaded_file($_FILES["upload_file"]["tmp_name"], $file);
  umask(0);
  chmod($file,0777);

  echo '<img src="'.$file.'">';
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