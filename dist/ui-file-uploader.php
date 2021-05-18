<?php session_start();?>
<script type="text/javascript"
src="https://code.jquery.com/jquery-2.1.0.min.js">
</script>
<!-- <script type="text/javascript" src="jquery.js"></script> -->
<script type="text/javascript" src="jquery.form.js"></script>
<script type="text/javascript" src="upload_progress.js"></script>
<script>
    function show_img(img_name, img_path) {
        //alert(img_name)
        $('.img_name').text(img_name);
        document.getElementById("data_img").src = img_path;
    }
</script>

<?php
function listFolderFiles($dir){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // 디렉토리가 비어있는지 확인합니다. 
    if (count($ffs) < 1)
        return;

    foreach($ffs as $ff){
        // 재귀함수 : 파일이 아닌 디렉토리가 있으면, 스스로 자신을 호출하여 반복적으로 실행합니다
        if(is_dir($dir.'/'.$ff)) {
            echo "<li>";
            $id = md5(uniqid(rand(), true));
            echo "<input type='checkbox' id=".$id." checked='checked'>";
            echo "<label for=".$id.">".$ff."</label>";
            echo "<ul>";
            listFolderFiles($dir.'/'.$ff);
            echo "</ul>";
            echo "</li>";
        }
        else{
            $img_path = $dir.'/'.$ff;
            echo "<li onclick='show_img(\"$ff\", \"$img_path\")' style=\"cursor:pointer;\">$ff</li>";
        }
    }
}
?>
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
    <link rel="stylesheet" type="text/css" href="progress_style.css">
    <style>
      .tree{
        color:#393939;
      }
      .tree, .tree ul{
        list-style: none;
        padding-left:17px;
      }
      .tree *:before{
        width:17px;
        height:17px;
        display:inline-block;
      }
      .tree label{
        cursor: pointer;
      }
      .tree label:before{
        content:'\f256';
        font-family: fontello;
      }
      .tree a{
        text-decoration: none;
        color:#393939;
      }
      .tree a:before{
        content:'\e800';
        font-family: fontello;
      }
      .tree input[type="checkbox"] {
        display: none;
      }
      .tree input[type="checkbox"]:checked~ul {
        display: none;
      }
      .tree input[type="checkbox"]:checked+label:before{
        content:'\f255';
        font-family: fontello;
      }
    </style>
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
                <h3>File Uploader</h3>
                <p class="text-subtitle text-muted">File uploader that makes user easier to upload their files</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">File Uploader</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">My Upload Files</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">업로드 해보장
                            </p>
                            <!-- File uploader with multiple files upload -->
                            <form action="upload_file.php"id="myForm" name="frmupload" method="post" enctype="multipart/form-data" >
                                <input type="file" id="upload_file" name="upload_file"/>
                                <input type="submit" name='submit_image' value="Submit Comment" onclick='upload_image();'/>
                            </form>
                            <div class='progress' id="progress_div">
                                <div class='bar' id='bar'></div>
                                <div class='percent' id='percent'>0%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">My Upload Files</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Using the basic table up, upload here to see how
                                <code>.multiple-files-filepond</code>-based basic file uploader look. You can use
                                <code>allowMultiple</code> or <code>multiple</code> attribute too to implement multiple upload.
                            </p>
                            <!-- File uploader with multiple files upload -->
                            <form name="uploadForm" id="uploadForm" method="post" action="../test/upload_process.php" 
                                enctype="multipart/form-data" onsubmit="return formSubmit(this);">
                                <label for="upfile">
                                    업로드
                                </label>
                                <input type="file" name="upfile" id="upfile">
                                <div class="row">
                                    <input type="Submit" class="btn btn-primary me-1 mb-1" value="upload file"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="basic-table">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Table with outer spacing</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body" style="height:550px;">
                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                <ul class="tree" style="overflow:auto; height:500px;">
                                    <?php 
                                        //echo ('../Dataset'.$_SESSION['id'].'/');
                                        listFolderFiles('../Dataset/'.$_SESSION['id'].'/');
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">My Upload Files</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body" style="height:550px;">
                            <p class="img_name">Empty</p>
                            <img id="data_img" src="" />
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
        // 업로드 할 수 있는 파일 확장자를 제한합니다.
        var extArray = new Array('hwp','xls','doc','xlsx','docx','pdf','jpg','gif','png','txt','ppt','pptx');
        var path = document.getElementById("upfile").value;

        if(path == "") {
            alert("파일을 선택해 주세요.");
            return false;
        }

        var pos = path.indexOf(".");
        if(pos < 0) {
            alert("확장자가 없는파일 입니다.");
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
            alert("업로드 할 수 없는 파일 확장자 입니다.");
            return false;
        }

        return true;
    }
</script>

    <script src="assets/js/main.js"></script>
</body>

</html>
