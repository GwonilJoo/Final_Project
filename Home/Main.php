<?php
    session_start();
?>
<meta charset="utf-8">
<style media="screen">

div, ul, li { margin:0; padding:0; float:none;}

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

#blogMenu a:hover {
	color:#D4F4FA;
	border-bottom:3px solid #FAED7D;
}

#blogMenu ul ul {
	display:none;
	position:absolute;
	background-color:rgb(105,163,255);
}

#blogMenu a {
	height:16px;
	color:#f1f1f1;
	font-family:arial;
	font-size:20px;
	padding:0 10px 0 10px;
	text-decoration:none;
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
            <li><a target="iframe1" href="MyDir.php">MyDir</a></li>
            <li><a target="iframe1" href="UploadDataset.php">UploadDataset</a></li>
            <li><a target="iframe1" href="ClickTrain.php">ClickTrain</a></li>
        </ul>
    </div>
    <div id="log">
        <ul>
            <li><a href="../Login/Login.php">Logout</a></li>
        </ul>
    </div>
    <div id="log">
        <ul>
            <li><?php echo "{$_SESSION['id']}";?></li>  
        </ul>
    </div>
    <br>
    <div>
        <iframe name="iframe1" src="UploadDataset.php" frameborder="1" width=98% height=500></iframe>
    </div>
</body>