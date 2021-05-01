<?php 
	session_start();
	if(!$_POST['save_file']){
		echo("
		  <script>
			window.alert('model를 입력하세요.')
			history.go(-1)
		  </script>
		");
		exit;
	  }
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<title>Insert title here</title>

<!-- <style>
	div{
		float:left;
	}
</style> -->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

google.charts.load('current', {'packages':['corechart']});

//var loss_data = [['iter', 'Loss']]
var loss_data = [['iter', 'Loss']];
var acc_data = [['iter', 'Acc']];
var loss_iter = 1;
var acc_iter = 1;

function drawChart(target_data, chart_name) {
	var data, line_color;

	if(chart_name == "loss_chart"){
		loss_data.push([loss_iter, target_data]);
		loss_iter += 1;
		data = google.visualization.arrayToDataTable(loss_data);
		line_color = "blue";
	}
	else{
		acc_data.push([acc_iter, target_data]);
		acc_iter += 1;
		data = google.visualization.arrayToDataTable(acc_data);
		line_color = "red";
	}
	
	// console.log(loss_data);
	// console.log(i);

	var options = {
	  title: chart_name,
	  curveType: 'function',
	  legend: { position: 'bottom' },
	  series: {
            0: { color: line_color },
          }
	};

	var chart = new google.visualization.LineChart(document.getElementById(chart_name));

	chart.draw(data, options);
}

</script>

</head>
<body>
	<div id="loss_chart" style="width: 50%; height: 500px; float:left; border:5px solid gold;"></div>
	<div id="acc_chart" style="width: 50%; height: 500px; float: right; border:5px solid green;"></div>
	
	<div class="progress" style="clear:both;">
		<div class="progress-bar progress-bar-striped active step" role="progressbar"
			aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
	  		Step 0%
		</div>
	</div>
	<div class="progress" style="clear:both;">
		<div class="progress-bar progress-bar-striped active train" role="progressbar"
			aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
	  		Epoch 0%
		</div>
	</div>


	<form>
		<!-- 서버로 메시지를 보낼 텍스트 박스 -->
		<input id="textMessage" type="text">
		<!-- 전송 버튼 -->
		<input onclick="sendMessage()" value="Send" type="button">
		<!-- 접속 종료 버튼 -->
		<input onclick="disconnect()" value="Disconnect" type="button">
	</form>
	<br />
	<!-- 출력 area -->
	<textarea id="messageTextArea" rows="10" cols="50"></textarea>
</body>
</html>


<script type="text/javascript">

	// 웹 서버를 접속한다.
	var webSocket = new WebSocket("ws://localhost:9998");

	// 웹 서버와의 통신을 주고 받은 결과를 출력할 오브젝트를 가져옵니다.
	var messageTextArea = document.getElementById("messageTextArea");

	// 소켓 접속이 되면 호출되는 함수
	webSocket.onopen = function(message){
		messageTextArea.value += "Server connect...\n";

		alert('server connet');

		var msg = {
			model: '<?php echo $_POST['model']?>',
			epochs: '<?php echo $_POST['epochs']?>',
			batch_size: '<?php echo $_POST['batch_size']?>',
			save_file: '<?php echo $_POST['save_file']?>',
			random_seed: '<?php echo $_POST['random_seed']?>'
		};

		alert('server connet2');

        webSocket.send(JSON.stringify(msg));
	};

// 소켓 접속이 끝나면 호출되는 함수
webSocket.onclose = function(message){
messageTextArea.value += "Server Disconnect...\n";
};

// 소켓 통신 중에 에러가 발생되면 호출되는 함수
webSocket.onerror = function(message){
messageTextArea.value += "error...\n";
};

// 소켓 서버로 부터 메시지가 오면 호출되는 함수.
webSocket.onmessage = function(message){
	// 출력 area에 메시지를 표시한다.
	messageTextArea.value += "Recieve From Server => "+ JSON.parse(message.data).loss+ "\n";
	//messageTextArea.value += "Recieve From Server => " + "\n";

	var dict = JSON.parse(message.data);
	//var loss = JSON.parse(message.data).loss;
	//var acc = JSON.parse(message.data).acc;
	// messageTextArea.value += "Recieve From Server => "+ dict.loss+ "\n";
	// messageTextArea.value += "Recieve From Server => "+ dict.acc+ "\n";
	// messageTextArea.value += "Recieve From Server => "+ dict.epoch+ "\n";
	// messageTextArea.value += "Recieve From Server => "+ dict.epochs+ "\n";
	// messageTextArea.value += "Recieve From Server => "+ dict.step+ "\n";
	// messageTextArea.value += "Recieve From Server => "+ dict.total_step+ "\n";

	if(dict.type == "chart"){
		google.charts.setOnLoadCallback(drawChart(dict.loss, "loss_chart"));
		google.charts.setOnLoadCallback(drawChart(dict.acc, "acc_chart"));
		
		var pcg = parseInt(dict.epoch/dict.epochs*100);
		document.getElementsByClassName('train').item(0).setAttribute('aria-valuenow',pcg);
		document.getElementsByClassName('train').item(0).setAttribute('style','width:'+Number(pcg)+'%');
		document.getElementsByClassName('train')[0].innerText = "Epoch " + String(pcg) + "%";
	}
	else if(dict.type == "step"){
		var pcg = parseInt(dict.step/dict.total_step*100);
		document.getElementsByClassName('step').item(0).setAttribute('aria-valuenow',pcg);
		document.getElementsByClassName('step').item(0).setAttribute('style','width:'+Number(pcg)+'%');
		document.getElementsByClassName('step')[0].innerText = "Step" + String(pcg) + "%";

		// document.getElementsByClassName('step').item(0).setAttribute('aria-valuenow',pcg);
		// document.getElementsByClassName('step').item(0).setAttribute('style','width:'+Number(pcg)+'%');
		// document.getElementsByClassName('step')[0].innerText = "Step " + String(pcg) + "%";
	}
};


// 서버로 메시지를 전송하는 함수
function sendMessage(){
	var message = document.getElementById("textMessage");
	messageTextArea.value += "Send to Server => "+message.value+"\n";

	//웹소켓으로 textMessage객체의 값을 보낸다.
	webSocket.send(message.value);

	//textMessage객체의 값 초기화
	message.value = "";
}

function disconnect(){
webSocket.close();
}

</script>