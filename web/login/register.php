<meta charset="utf-8">
<?php
$connect = mysqli_connect("localhost", "root", "apmsetup", "final_db");
mysql_set_charset("utf8", $connect);

$sql = "insert into user values";
$sql = $sql."('{$_REQUEST['id']}', '{$_REQUEST['passwd']}', '{$_REQUEST['email']}')";

$result = mysqli_query($connect, $sql);
$res;

if(!$result){
  $res = "회원가입 실패!";
}
else{
  $res = "회원가입 성공!";
}

echo "<script type=\"text/javascript\">alert(\"$res\"); document.location.href=\"Login.php\";</script>";
exit;
?>
