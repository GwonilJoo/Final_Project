<?php
$cmd = "rm -f ".$_POST['delete_path'];
echo $cmd;
$data1 = shell_exec($cmd);
echo "<pre> $data1 </pre>";

// $string = explode( '/', $_POST['delete_path']);
// $user_id = $string[2];
// $dataset = $string[3];
// $save_name = $string[5];

// echo "$user_id<br>";
// echo "$dataset<br>";
// echo "$save_name<br>";

// $connect = mysqli_connect("211.47.119.192", "root", "pass", "Final_db");
// #mysql_set_charset("utf8", $connect);

// $sql = "delete from save_weight where user_id='{$user_id}' and dataset='{$dataset}' and save_name='{$save_name}';";
// echo "$sql<br>";
// $result = mysqli_query($connect, $sql);

// if(!$result){
//   $res = "실패!";
// }
// else{
//   $res = "성공!";
// }

// unlink($_POST['delete_path']);

// echo $res;

// mysqli_close($connect);
// exit;
?>