<?php 
	session_start();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    // 궈닐이 코드
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

    function drawInitChart(chart_name) {
        var data, line_color;

        var loss_null_data = [['iter', 'Loss'], [0, 0]];
        var acc_null_data = [['iter', 'Acc'], [0, 0]];

        if(chart_name == "loss_chart"){
            data = google.visualization.arrayToDataTable(loss_null_data);
            line_color = "blue";
        }
        else{
            data = google.visualization.arrayToDataTable(acc_null_data);
            line_color = "red";
        }

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

    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(function () {
        drawInitChart("loss_chart");
    });
    google.charts.setOnLoadCallback(function () {
        drawInitChart("acc_chart");
    });
    
    // function drawVisualization() {
    //     var data = new google.visualization.DataTable();
    //     var data2 = google.visualization.arrayToDataTable([]);

    //     // Declare columns
    //     data.addColumn('date', 'Day');
    //     data.addColumn('number', 'Person');

    //     // Add data.
    //     //data.addRows(countArrayFinal);

    //     // Create and draw the visualization.
    //     new google.visualization.LineChart(document.getElementById('loss_chart')).draw(data, {
    //         title: 'Performance',
    //         vAxis : {
    //             maxValue : 4000
    //         }
    //     });
    // }

    // // // google.load("visualization", "1", {packages:["corechart"]});
    // // google.charts.load('current', {'packages':['corechart']});
    // // google.setOnLoadCallback(drawVisualization);
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apexcharts - Mazer Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/apexcharts/apexcharts.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
        //var loss_data = [['iter', 'Loss']]
        
    </script>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item  ">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Forms &amp; Tables</li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-hexagon-fill"></i>
                                <span>Form Elements</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="form-element-input.html">Input</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="form-element-input-group.html">Input Group</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="form-element-select.html">Select</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="form-element-radio.html">Radio</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="form-element-checkbox.html">Checkbox</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="form-element-textarea.html">Textarea</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item active has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>Charts</span>
                            </a>
                            <ul class="submenu active">
                                <li class="submenu-item ">
                                    <a href="ui-chart-chartjs.html">ChartJS</a>
                                </li>
                                <li class="submenu-item active">
                                    <a href="ui-chart-apexcharts.html">Apexcharts</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  ">
                            <a href="ui-file-uploader.html" class='sidebar-link'>
                                <i class="bi bi-cloud-arrow-up-fill"></i>
                                <span>File Uploader</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Apexcharts</h3>
                            <p class="text-subtitle text-muted">A chart for user </p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Apexcharts</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Line Area Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="area"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Radial Gradient Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="radialGradient"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Loss Chart</h4>
                                </div>
                                <div class="card-body">
                                    <!-- <div id="line"></div> -->
                                    <div id="loss_chart" style="height: 400px; border:5px solid blue;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Acc Chart</h4>
                                </div>
                                <div class="card-body">
                                    <!-- <div id="bar"></div> -->
                                    <div id="acc_chart" style="height: 400px; border:5px solid red"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <h6>Step</h6>
                            <div class="progress" style="clear:both; height:30px;">
                                <div class="progress-bar progress-bar-striped active step" role="progressbar"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                    0%
                                </div>
                            </div>
                            <br>
                            <h6>Epoch</h6>
                            <div class="progress" style="clear:both; height:30px;">
                                <div class="progress-bar progress-bar-striped active train" role="progressbar"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                    0%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Radial Gradient Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="candle"></div>
                                </div>
                            </div>
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
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://ahmadsaugi.com">A. Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendors/dayjs/dayjs.min.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/ui-apexchart.js"></script>

    <script src="assets/js/main.js"></script>

</body>

</html>

<script type="text/javascript">
        // websocket
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
        
        if(dict.type == "chart"){
            messageTextArea.value += "Recieve From Server => loss: "+ dict.loss+ "\n";
            messageTextArea.value += "Recieve From Server => acc: "+ dict.acc+ "\n";
            messageTextArea.value += "Recieve From Server => epoch: "+ dict.epoch+ "\n";
            messageTextArea.value += "Recieve From Server => epochs: "+ dict.epochs+ "\n";
            
            google.charts.setOnLoadCallback(function(){
                drawChart(dict.loss, "loss_chart");
            });
            google.charts.setOnLoadCallback(function(){
                drawChart(dict.acc, "acc_chart");
            });
            
            var pcg = parseInt(dict.epoch/dict.epochs*100);
            document.getElementsByClassName('train').item(0).setAttribute('aria-valuenow',pcg);
            document.getElementsByClassName('train').item(0).setAttribute('style','width:'+Number(pcg)+'%');
            document.getElementsByClassName('train')[0].innerText = String(pcg) + "%";
        }
        else if(dict.type == "step"){
            // google.charts.setOnLoadCallback(function(){
            //     drawChart(dict.loss, "loss_chart");
            // });
            // google.charts.setOnLoadCallback(function(){
            //     drawChart(dict.acc, "acc_chart");
            // });
            messageTextArea.value += "Recieve From Server => step: "+ dict.step+ "\n";
            messageTextArea.value += "Recieve From Server => total_step: "+ dict.total_step+ "\n";

            var pcg = parseInt(dict.step/dict.total_step*100);
            document.getElementsByClassName('step').item(0).setAttribute('aria-valuenow',pcg);
            document.getElementsByClassName('step').item(0).setAttribute('style','width:'+Number(pcg)+'%');
            document.getElementsByClassName('step')[0].innerText = String(pcg) + "%";

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