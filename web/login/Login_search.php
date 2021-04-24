<?
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
  $connect = mysqli_connect("localhost", "root", "apmsetup", "final_db");

  mysqli_set_charset($connect, "utf8");
  $sql = "select * from user where id='{$_POST['id']}' and passwd='{$_POST['passwd']}';";
  $result = mysqli_query($connect, $sql);
  $info = mysqli_fetch_array($result);

  if($info['id'] == NULL){
    echo("
      <script>
        window.alert('로그인 실패! 아이디와 비밀번호를 확인해주세요.')
        history.go(-1)
      </script>
    ");
    exit;
  }
  else{
    session_start();
    $_SESSION['id'] = $info[id];
    $_SESSION['passwd'] = $info[passwd];

    echo $_SESSION['id'];
    echo "<br>";
    echo $_SESSION['passwd'];

    echo("<script type=\"text/javascript\">
            document.location.href=\"../mypage/main.php\";
          </script>
        ");
  }

  mysqli_close($connect);
}
?>
<meta charset="utf-8">
