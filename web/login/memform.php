<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h2>회원 가입</h2>
    <div style="height: 500; width: 98%; border:5px solid rgb(105,163,255);">
    <b></b>
    <form name="mem_form" action="register.php" method="post">
      <b></b>
      <table border="1" width="640" cellspacing="1" cellpadding="4" align=center>
        <tr>
          <td align="right">아이디</td>
          <td><input type="text" size="20" name="id" required></td>
        </tr>
        <tr>
          <td align="right">비밀번호</td>
          <td><input type="text" size="20" name="passwd" required></td>
        </tr>
        <tr>
          <td align="right">이메일</td>
          <td><input type="email" size="20" name="email"></td>
        </tr>
      </table>
      </div>
      <table border="0" width="640">
        <tr>
          <td align="center"><input type="submit" value="확인"></td>
        </tr>
      </table>
    </form>

  </body>
</html>
