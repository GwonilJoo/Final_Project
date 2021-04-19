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
  
}
?>