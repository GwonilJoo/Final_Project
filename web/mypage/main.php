<?
  session_start();
?>
<meta charset="utf-8">
<style media="screen">

div, ul, li { margin:0; padding:0; }

#blogMenu{
  float: left;
	margin:0px 5px 3px 5px;
	padding:0 0 3px 0;
	box-shadow: 0px 0px 15px rgba(0,0,0,.3);
	-moz-box-shadow: 0px 0px 15px rgba(0,0,0,.3);
	-webkit-box-shadow: 0px 0px 15px rgba(0,0,0,.3);
	-o-box-shadow: 0px 0px 15px rgba(0,0,0,.3);
	-moz-border-radius: 3px;
	-khtml-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	background-color:rgb(105,163,255);
}

#blogMenu ul li {
	float:left;
	list-style-type:none;
}

#blogMenu a {
	height:16px;
	color:#f1f1f1;
	font-family:arial;
	font-size:20px;
	padding:0 10px 0 10px;
	text-decoration:none;
}

#blogMenu a:hover {
	color:#D4F4FA;
	border-bottom:3px solid #FAED7D;
}

#blogMenu ul ul {
	display:none;
	position:absolute;
	background-color:rgb(105,163,255);
}

#blogMenu ul li:hover ul {
	display: block;
}

#blogMenu ul ul li {
	float:none;
}

iframe{
  border-width: 5px;
  border-color: rgb(105,163,255);
}

#log{
  float: right;
	margin:0px 5px 3px 5%;
	padding:0 0 3px 0;
	box-shadow: 0px 0px 15px rgba(0,0,0,.3);
	-moz-box-shadow: 0px 0px 15px rgba(0,0,0,.3);
	-webkit-box-shadow: 0px 0px 15px rgba(0,0,0,.3);
	-o-box-shadow: 0px 0px 15px rgba(0,0,0,.3);
	-moz-border-radius: 3px;
	-khtml-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
  background-color:rgb(105,163,255);
}

#log ul li {
	float:left;
	list-style-type:none;
}

#log li, a {
	height:25px;
	color:#f1f1f1;
	font-family:arial;
	font-size:20px;
	padding:0 10px 0 10px;
	text-decoration:none;
}

#log a:hover {
	color:#D4F4FA;
	border-bottom:3px solid #FAED7D;
}

</style>

<body>
  <div id="blogMenu">
  <ul>
    <!-- <li>
      <a target="iframe1" href="mypage/mypage.php">마이페이지</a>
      <ul>
        <li><a target="iframe1" href="mypage/mypage.php">수강 목록</a></li>
        <li><a target="iframe1" href="mypage/course_list.php">수강과목 등록</a></li>
        <li><a target="iframe1" href="mypage/rental.php">대여 목록</a></li>
        <li><a target="iframe1" href="mypage/buy.php">구매 목록</a></li>
        <li><a target="iframe1" href="mypage/sell.php">판매 목록</a></li>
      </ul>
    </li> -->
    <li><a target="iframe1" href="file.php">파일 업로드</a></li>
    <li><a target="iframe1" href="train_chart.php">학습</a></li>
  </ul>
  </div>
  <div id="log">
    <ul>
      <li><a href="../login/Login.php">로그아웃</a></li>
    </ul>
  </div>
  <div id="log">
    <ul>
      <li><?echo "{$_SESSION['id']}님&nbsp";?></li>
    </ul>
  </div>
  <div>
    <iframe name="iframe1" src="file.php" frameborder="1" width=98% height="500"></iframe>
  </div>
</body>
