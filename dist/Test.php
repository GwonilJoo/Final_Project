<?php
session_start();

function show_save_weight(){
    $connect = mysqli_connect("211.47.119.192", "root", "pass", "Final_db");
    // if($connect){
    //     echo "<script>window.alert('DB 연결 성공')</script>";
    // }
    // else{
    //     echo "<script>window.alert('DB 연결 실패')</script>";
    // }
    #mysqli_set_charset($connect, "utf8");
    $sql = "select * from save_weight where user_id='{$_SESSION['id']}';";
    $result = mysqli_query($connect, $sql);

    while ($row = mysqli_fetch_array($result)){
        $path = '../Dataset/'.$row['user_id'].'/'.$row['dataset'].'/saved/'.$row['save_name'];
        echo "<tr>";
        echo "<td>".$row['dataset']."</td>";
        echo "<td>".$row['save_name']."</td>";
        echo "<td><button class=\"badge bg-success\" onclick=\"draw_chart();\">Test</button></td>";
        echo "<td><button class=\"badge bg-success\"><a href=$path download>Download</a></button></td>";

        echo "<td>";
        echo "<form name=\"delete_save_weight\" action=\"delete_save_weight.php\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"delete_path\" value=$path>";
        echo "<button type=\"submit\" class=\"badge bg-danger\">Delete</button>";
        echo "</form></td>";
        echo "</tr>";
     }

    mysqli_close($connect);
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTable - Mazer Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <?php
                                if($_SESSION['id'] != null){
                                    echo "<a href=\"index.php\">";
                                }
                                else{
                                    echo "<a href=\"Login.php\">";
                                }
                            ?>
                            <img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-hexagon-fill"></i>
                                <span>Inference</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="form-element-select.php">Train</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="Test.php">Test</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>MyDirectory</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item ">
                                    <a href="ui-file-uploader.php">File Uploader</a>
                                </li>
                            </ul>
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
                            <h3>DataTable</h3>
                            <p class="text-subtitle text-muted">For user to check they list</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">DataTable</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            Simple Datatable
                        </div>
                        <div class="card-body">
                            <table class="table table-hover" id="table1">
                                <thead>
                                    <tr>
                                        <th>Dataset</th>
                                        <th>Save weight</th>
                                        <th>Test</th>
                                        <th>Download</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php show_save_weight(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12">
                        <h6>Testing</h6>
                        <div class="progress" style="clear:both; height:30px;">
                            <div class="progress-bar progress-bar-striped active step" role="progressbar"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                0%
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Total Accuracy</h4>
                                </div>
                                <div class="card-body">
                                    <div id="total_chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Accuracy per Class</h4>
                                </div>
                                <div class="card-body">
                                    <div id="loss_chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
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

    <script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

    <script src="assets/js/main.js"></script>
</body>

</html>

<script type="text/javascript">

google.charts.load('current', {'packages':['corechart', 'gauge']});

function total_result(chart_name){
    var data, line_color;

    var loss_null_data = [['Label', 'Accuracy'], 
                            ['Accuracy', 83.8]];

    data = google.visualization.arrayToDataTable(loss_null_data);
    line_color = "blue";

    var options = {
        width: 250, height: 250,
        redFrom: 90, redTo: 100,
        yellowFrom:75, yellowTo: 90,
        minorTicks: 5
    };

    var chart = new google.visualization.Gauge(document.getElementById(chart_name));

    chart.draw(data, options);
}


function classify_result(chart_name){
    var data, line_color;

    var loss_null_data = [['Class', 'Accuracy'], 
                            ['dog', 84.4], 
                            ['cat', 87.7],
                            ['bird', 77.7]];

    data = google.visualization.arrayToDataTable(loss_null_data);
    line_color = "blue";

    var options = {
        legend: { position: 'bottom' },
        vAxis: {
            ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById(chart_name));

    chart.draw(data, options);
}


function draw_chart(){
    google.charts.setOnLoadCallback(function () {
        total_result("total_chart");
        classify_result("loss_chart");
    });
}
</script>