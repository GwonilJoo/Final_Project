<?php 
session_start();

if($_POST['save_path']){
    $_SESSION['save_path'] = $_POST['save_path'];
}
if($_POST['test_path']){
    $_SESSION['test_path'] = $_POST['test_path'];
}
if($_POST['model_name']){
    $_SESSION['model_name'] = $_POST['model_name'];
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
<!-- <script type="text/javascript" src="jquery.js"></script> -->
<script type="text/javascript" src="jquery.form.js"></script>
<!-- <script type="text/javascript" src="upload_progress.js"></script> -->
<script>
    function show_img(img_name, img_path) {
        //alert(img_name)
        $('.img_name').text(img_name);
        document.getElementById("data_img").src = img_path;
    }
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Uploader - Mazer Admin Dashboard</title>
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
    <link rel="stylesheet" href="assets/vendors/toastify/toastify.css">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    

    <!-- for tree -->
    <link rel="stylesheet" href="tree_fontello/css/fontello.css">

    <!-- for progress -->
    <!-- <link rel="stylesheet" type="text/css" href="progress_style.css"> -->

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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6>Testing</h6>
                    </div>
                    <div class="card-body">
                        <input type="button" class="btn btn-primary rounded-pill" name='infer_image' value="Test your model" onclick='try_test();'/>
                        <br>
                        <br>
                        <div class="progress" style="clear:both; height:30px;">
                            <div class="progress-bar progress-bar-striped active step" role="progressbar"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                0%
                            </div>
                        </div>
                    </div>
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
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Inference</h5>
                    </div>
                    <div class="col-12 col-xl-12">
                        <div class="card-body">
                            <!-- File uploader with multiple files upload -->

                            <form action="upload_tmp_file.php" id="myForm" name="frmupload" method="post" enctype="multipart/form-data" > 

                            <div class="card-content">
                                <fieldset>
                                    <div class="input-group">
                                        <input style="margin-right:15px;" class="form-control" type="file" id="upload_file" name="upload_file"/>
                                        <input type="submit" class="btn btn-primary rounded-pill" name='submit_image' value="Submit" onclick='upload_image();'/>
                                        <input type="button" class="btn btn-primary rounded-pill" name='infer_image' value="Predict" onclick='try_infer();'/>
                                    </div>
                                </fieldset>
                            </div>

                            </form>

                            <div class='progress progress-primary mb-4"' id="progress_div" style="display:block; width:100%; height:23px;">
                                <div class="progress-bar progress-bar-striped" id="bar" role="progressbar" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><div id='percent'>0%</div></div>
                            </div>
                            <div id='pred'></div>
                            <div>
                                <img id="output" src="">
                            </div>

                            <!-- <div class='progress' id="progress_div" style="display:block; width:500px; height:23px;">
                                <div class='bar' id='bar'></div>
                                <div class='percent' id='percent'>0%</div>
                            </div> -->
                            
                        </div>
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
    
<!-- filepond validation -->
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

<!-- image editor -->
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-filter/dist/filepond-plugin-image-filter.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>

<!-- toastify -->
<script src="assets/vendors/toastify/toastify.js"></script>

<!-- filepond -->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script>
    // // register desired plugins...
	// FilePond.registerPlugin(
    //     // validates the size of the file...
    //     FilePondPluginFileValidateSize,
    //     // validates the file type...
    //     FilePondPluginFileValidateType,

    //     // calculates & dds cropping info based on the input image dimensions and the set crop ratio...
    //     FilePondPluginImageCrop,
    //     // preview the image file type...
    //     FilePondPluginImagePreview,
    //     // filter the image file
    //     FilePondPluginImageFilter,
    //     // corrects mobile image orientation...
    //     FilePondPluginImageExifOrientation,
    //     // calculates & adds resize information...
    //     FilePondPluginImageResize,
    // );
    
    // Filepond: Basic
    FilePond.create( document.querySelector('.basic-filepond'), { 
        allowImagePreview: false,
        allowMultiple: false,
        allowFileEncode: false,
        required: false
    });


    function formSubmit(f) {
        // ????????? ??? ??? ?????? ?????? ???????????? ???????????????.
        var extArray = new Array('hwp','xls','doc','xlsx','docx','pdf','jpg','gif','png','txt','ppt','pptx');
        var path = document.getElementById("upfile").value;

        if(path == "") {
            alert("????????? ????????? ?????????.");
            return false;
        }

        var pos = path.indexOf(".");
        if(pos < 0) {
            alert("???????????? ???????????? ?????????.");
            return false;
        }

        var ext = path.slice(path.indexOf(".") + 1).toLowerCase();
        var checkExt = false;
        for(var i = 0; i < extArray.length; i++) {
            if(ext == extArray[i]) {
                checkExt = true;
                break;
            }
        }

        if(checkExt == false) {
            alert("????????? ??? ??? ?????? ?????? ????????? ?????????.");
            return false;
        }

        return true;
    }
</script>

<script src="assets/js/main.js"></script>

<script type="text/javascript">

google.charts.load('current', {'packages':['corechart', 'gauge']});

function total_result(chart_name, acc){
    var data, line_color;

    var loss_null_data = [['Label', 'Accuracy'], 
                            ['Accuracy', acc]];

    console.log(loss_null_data);

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


function classify_result(chart_name, result){
    var data, line_color;

    console.log(result);

    var acc_data = [['Class', 'Accuracy']];

    // for(var i=0;i<result.length;i++){
    //     acc_data.push(result[i][0])
    // }

    acc_data = acc_data.concat(result);

    console.log(acc_data);

    data = google.visualization.arrayToDataTable(acc_data);
    line_color = "blue";
 
    data.insertRows(0, [[' ', null]]);
    data.addRow([' ', null]);


    var options = {
        legend: { position: 'bottom' },
        

        vAxis: {
            ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]
        }
        
    };

    var chart = new google.visualization.ColumnChart(document.getElementById(chart_name));

    chart.draw(data, options);
}


</script>

<!-- ?????? -->
<script type="text/javascript">
    // websocket
function try_test(){
        // ??? ????????? ????????????.
    var webSocket = new WebSocket("ws://211.47.119.192:9996");

    // ??? ???????????? ????????? ?????? ?????? ????????? ????????? ??????????????? ???????????????.
    //var messageTextArea = document.getElementById("messageTextArea");

    // ?????? ????????? ?????? ???????????? ??????
    webSocket.onopen = function(message){
        //messageTextArea.value += "Server connect...\n";
        alert('server connet');
        var msg = {
            type: 'test',
            model: '<?php echo $_SESSION['model_name']?>',
            save_file: '<?php echo $_SESSION['save_path']?>',
            data_dir: '<?php echo $_SESSION['test_path']?>'
        };

        webSocket.send(JSON.stringify(msg));
    };

    // ?????? ????????? ????????? ???????????? ??????
    webSocket.onclose = function(message){
        //messageTextArea.value += "Server Disconnect...\n";
        console.log("Server Disconnect...");
    };

    // ?????? ?????? ?????? ????????? ???????????? ???????????? ??????
    webSocket.onerror = function(message){
        //messageTextArea.value += "error...\n";
        console.log("Server Disconnect...");
    };

    // ?????? ????????? ?????? ???????????? ?????? ???????????? ??????.
    webSocket.onmessage = function(message){
        // ?????? area??? ???????????? ????????????.
        //messageTextArea.value += "Recieve From Server => "+ JSON.parse(message.data).loss+ "\n";
        //messageTextArea.value += "Recieve From Server => " + "\n";

        var dict = JSON.parse(message.data);
        
        if(dict.type == "acc"){            
            google.charts.setOnLoadCallback(function () {
                total_result("total_chart", dict.total_acc);
                classify_result("loss_chart", dict.result);
            });
        }
        else if(dict.type == "step"){
            var pcg = parseInt(dict.step/dict.total_step*100);
            document.getElementsByClassName('step').item(0).setAttribute('aria-valuenow',pcg);
            document.getElementsByClassName('step').item(0).setAttribute('style','width:'+Number(pcg)+'%');
            document.getElementsByClassName('step')[0].innerText = String(pcg) + "%";

            // document.getElementsByClassName('step').item(0).setAttribute('aria-valuenow',pcg);
            // document.getElementsByClassName('step').item(0).setAttribute('style','width:'+Number(pcg)+'%');
            // document.getElementsByClassName('step')[0].innerText = "Step " + String(pcg) + "%";
        }
    };

}

// ????????? ???????????? ???????????? ??????

// function draw_chart(save_path, test_path, model_name){
//     alert("test start");

//     g_save_path = save_path;
//     g_test_path = test_path;
//     g_model_name = model_name;

//     var msg = {
//         type: 'test',
//         model: model_name,
//         save_file: save_path,
//         data_dir: test_path
//     };

//     webSocket.send(JSON.stringify(msg));
// }

function try_infer(){
    webSocket = new WebSocket("ws://211.47.119.192:9996");
    webSocket.onopen = function(message){
        //messageTextArea.value += "Server connect...\n";
        alert("Start to predict!");
        
        var msg = {
            type: 'infer',
            model: '<?php echo $_SESSION['model_name']?>',
            save_file: '<?php echo $_SESSION['save_path']?>',
            data_dir: '<?php echo $_SESSION['test_path']?>'
        };

        webSocket.send(JSON.stringify(msg));
    };
    webSocket.onmessage = function(message){
        var dict = JSON.parse(message.data);
        document.getElementById('pred').innerText = dict.pred;
    };
}

function disconnect(){
    webSocket.close();
}

function upload_image() 
{
  var bar = $('#bar');
  var percent = $('#percent');
  $('#myForm').ajaxForm({
    beforeSubmit: function() {
      document.getElementById("progress_div").style.display="block";
      var percentVal = '0%';
      bar.width(percentVal)
      percent.html(percentVal);
    },

    uploadProgress: function(event, position, total, percentComplete) {
      var percentVal = percentComplete + '%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    
	success: function() {
      var percentVal = '100%';
      bar.width(percentVal)
      percent.html(percentVal);
    },

    complete: function(xhr) {
      if(xhr.responseText)
      {
        console.log(xhr.responseText);
        document.getElementById("output").innerHTML=xhr.responseText;

        var tmpDate = new Date(); 
        $("#output").attr("src", "../Learning/tmp/input.jpg?"+tmpDate.getTime());
      }
    }
  }); 
}
</script>
</body>

</html>
