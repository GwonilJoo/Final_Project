<meta charset="utf-8">
<?php
$connect = mysql_connect("localhost", "root", "apmsetup");
mysql_set_charset("utf8", $connect);
mysql_select_db("project_db", $connect);

$sql = "insert into student values";
$sql = $sql."('{$_REQUEST['student_num']}', '{$_REQUEST['name']}',";
$sql = $sql."'{$_REQUEST['email']}', '{$_REQUEST['tel']}')";

$result = mysql_query($sql, $connect);
$res;

if(!$result){
  $res = "회원가입 실패!";
}
else{
  $res = "회원가입 성공!";
}

echo "<script type=\"text/javascript\">alert(\"$res\"); document.location.href=\"login.php\";</script>";
exit;
?>
