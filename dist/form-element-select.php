<?php 
    session_start();

    function listFolder($dir){
        $ffs = scandir($dir);
    
        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);
    
        // 디렉토리가 비어있는지 확인합니다. 
        if (count($ffs) < 1)
            return;
    
        foreach($ffs as $ff){
            echo "<option value='$dir$ff'>$ff</option>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select - Mazer Admin Dashboard</title>

    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="assets/vendors/choices.js/choices.min.css" />

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

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
                            <h3>Select</h3>
                            <p class="text-subtitle text-muted">Customize the native &laquo;select&raquo; with custom
                                CSS that
                                changes the element’s initial appearance..</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Select</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- My select start-->
                <form action="ui-chart-apexcharts.php" method="post">
                    <section class="bootstrap-select">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Your Model Setting</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <h6>Field</h6>
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="basicSelect", name='model'>
                                                            <option value='resnet'>Image Classification</option>
                                                            <option value='faset-rcnn'>Object Detection</option>
                                                            <option value='mask-rcnn'>Segmentation</option>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <h6>Dataset</h6>
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="basicSelect", name='dataset'>
                                                            <?php listFolder('../Dataset/'.$_SESSION['id'].'/');?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <h6>Number of Epochs</h6>
                                                    <fieldset class="form-group">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="basicInput"
                                                                placeholder="1 to 10000" name="epochs">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <h6>Batch size</h6>
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="basicSelect", name="batch_size">
                                                            <option value=1>1</option>
                                                            <option value=2>2</option>
                                                            <option value=4>4</option>
                                                            <option value=8>8</option>
                                                            <option value=16>16</option>
                                                            <option value=32>32</option>
                                                            <option value=100>100</option>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <h6>Save file name</h6>
                                                    <fieldset class="form-group">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="basicInput"
                                                                placeholder="Input save file name", name="save_file">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <h6>Random Seed</h6>
                                                    <fieldset class="form-group">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="basicInput"
                                                                placeholder="random seed", name="random_seed">
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <input type="Submit" class="btn btn-primary me-1 mb-1" value="select model" name="start train" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
                <!-- My select end-->

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

    <!-- Include Choices JavaScript -->
    <script src="assets/vendors/choices.js/choices.min.js"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>