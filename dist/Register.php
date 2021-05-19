<meta charset="utf-8">
<?php
$connect = mysqli_connect("211.47.119.192", "root", "pass", "Final_db");
#mysql_set_charset("utf8", $connect);

$sql = "insert into user values";
$sql = $sql."('{$_REQUEST['id']}', '{$_REQUEST['passwd']}', '{$_REQUEST['email']}')";

$result = mysqli_query($connect, $sql);

if(!$result){
  $res = "Fail to sign up!";
  echo "<script type=\"text/javascript\">alert(\"$res\"); document.location.href=\"Memform.html\";</script>";
}
else{
  $res = "Success to sign up!";
  echo "<script type=\"text/javascript\">alert(\"$res\");</script>";

  $foldername = "../Dataset/".$_REQUEST['id'];

  if(!is_dir($foldername)) {
    umask(0);
    mkdir($foldername, 0777, true);
  }
  echo "<script type=\"text/javascript\">document.location.href=\"Login.php\";</script>";
}

mysqli_close($connect);
exit;
?>