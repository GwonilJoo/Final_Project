<meta charset="utf-8">
<?php
if(!$_POST['id']){
  echo("
    <script>
      window.alert('id를 입력하세요.')
      history.go(-1)
    </script>
  ");
  exit;
}
else if(!$_POST['passwd']){
  echo("
    <script>
      window.alert('passwd를 입력하세요.')
      history.go(-1)
    </script>
  ");
  exit;
}
else{
  echo"??";
  $connect = mysqli_connect("localhost", "root", "", "Final_db");
  if($connect){
    echo "DB connect ok<br>";

    #mysqli_set_charset($connect, "utf8");
    $sql = "insert into user values('gwonil', 'rnjsdlf', 'gwonil3256@gmail.com');";
    $result = mysqli_multi_query($connect, $sql);

    echo "$result";

    echo "레코드 삽입 성공";
  }
  else{
    echo "DB connect failed";
  }
  
  mysqli_close($connect);
}
?>