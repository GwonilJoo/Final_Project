<?php
session_start();

if(!$_SESSION['id']){
    echo "<script>alert(\"Please Login...\"); location.href = \"Login.php\";</script>";
}

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
        $save_path = '../Dataset/'.$row['user_id'].'/'.$row['dataset'].'/saved/'.$row['save_name'];
        $test_path = '../Dataset/'.$row['user_id'].'/'.$row['dataset'];
        $model_name = $row['model'];
        echo "<tr>";
        echo "<td>".$row['model']."</td>";
        echo "<td>".$row['dataset']."</td>";
        echo "<td>".$row['save_name']."</td>";
        //$save_path, $test_path, $model_name
        //echo '<td><button class="badge bg-success" onclick="draw_chart(\''.$save_path.'\', \''.$test_path.'\', \''.$model_name.'\');">Test</button></td>';
        echo "<td>";
        echo "<form name=\"inference\" action=\"inference.php\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"save_path\" value=$save_path>";
        echo "<input type=\"hidden\" name=\"test_path\" value=$test_path>";
        echo "<input type=\"hidden\" name=\"model_name\" value=$model_name>";
        echo "<button type=\"submit\" class=\"badge bg-success\">Test</button>";
        echo "</form></td>";

        echo "<td><button class=\"badge bg-success\"><a href=$save_path download>Download</a></button></td>";

        echo "<td>";
        echo "<form name=\"delete_save_weight\" action=\"delete_save_weight.php\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"delete_path\" value=$save_path>";
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
                                <span>Train&Test</span>
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
                            <h3>Test</h3>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            Save file list
                        </div>
                        <div class="card-body">
                            <table class="table table-hover" id="table1">
                                <thead>
                                    <tr>
                                        <th>Model</th>
                                        <th>Dataset</th>
                                        <th>Save weight</th>
                                        <th>Test</th>
                                        <th>Download</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php show_save_weight(); ?>
                                    <tr>
                                        <td>faster rcnn</td>
                                        <td>COCO</td>
                                        <td>pretrained.pth</td>
                                        <td>
                                            <form name="inference_other" action="inference_detect.php" method="post">
                                                <input type="hidden" name="model_name" value="faster_rcnn">
                                                <button type="submit" class="badge bg-success">Test</button>
                                            </form>
                                        </td>
                                        <td>
                                            <button class="badge bg-danger">Download</button>
                                        </td>
                                        <td>
                                            <button class="badge bg-danger">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>keypoint</td>
                                        <td>COCO</td>
                                        <td>pretrained.pth</td>
                                        <td>
                                            <form name="inference_other" action="inference_other.php" method="post">
                                                <input type="hidden" name="model_name" value="keypoint">
                                                <button type="submit" class="badge bg-success">Test</button>
                                            </form>
                                        </td>
                                        <td>
                                            <button class="badge bg-danger">Download</button>
                                        </td>
                                        <td>
                                            <button class="badge bg-danger">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>segmentation</td>
                                        <td>COCO</td>
                                        <td>pretrained.pth</td>
                                        <td>
                                            <form name="inference_other" action="inference_other.php" method="post">
                                                <input type="hidden" name="model_name" value="segmentation">
                                                <button type="submit" class="badge bg-success">Test</button>
                                            </form>
                                        </td>
                                        <td>
                                            <button class="badge bg-danger">Download</button>
                                        </td>
                                        <td>
                                            <button class="badge bg-danger">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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