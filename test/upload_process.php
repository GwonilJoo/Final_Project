<meta charset="UTF-8">

<?php

    $connect = mysql_connect("localhost", "root", "apmsetup");
    mysql_set_charset("utf8", $connect);
    mysql_select_db("final_db", $connect);

    if(isset($_FILES['upfile']) && $_FILES['upfile']['name'] != "") {

        $file = $_FILES['upfile'];
        $upload_directory = 'data/';
        $ext_str = "hwp,xls,doc,xlsx,docx,pdf,jpg,gif,png,txt,ppt,pptx,zip";
        $allowed_extensions = explode(',', $ext_str);

        $max_file_size = 5242880;
        $ext = substr($file['name'], strrpos($file['name'], '.') + 1);

        // 확장자 체크
        if(!in_array($ext, $allowed_extensions)) {
            echo "업로드할 수 없는 확장자 입니다.";
        }

        // 파일 크기 체크
        if($file['size'] >= $max_file_size) {
            echo "5MB 까지만 업로드 가능합니다.";
        }

        $path = md5(microtime()) . '.' . $ext;
        if(move_uploaded_file($file['tmp_name'], $upload_directory.$path)) {
            $file_id = md5(uniqid(rand(), true));
            $name_orig = $file['name'];
            $name_save = $path;
    
            echo $file_id."<br>";
            echo $name_orig."<br>";
            echo $name_save."<br>";
            $date = date("Y-m-d H:i:s");
            echo $date."<br>";

            #$query = "INSERT INTO upload_file (file_id, name_orig, name_save, reg_time) VALUES(?,?,?,now())";
            #$query = "INSERT INTO upload_file VALUES ($file_id,$name_orig,$name_save,$date)";
            #$query = "INSERT INTO upload_file VALUES ('1','2','3','0000-00-00 00:00:00')";


            // $stmt = mysqli_prepare($db_conn, $query);
            // if($statement == false) {
            //     die("<pre>".mysqli_error($conn).PHP_EOL.$query."</pre>");
            // }
            // $bind = mysqli_stmt_bind_param($stmt, "sss", "$file_id", "$name_orig", "$name_save");
            // $exec = mysqli_stmt_execute($stmt);

            // mysqli_stmt_close($stmt);

            $sql = "insert into upload_file values ('$file_id', '$name_orig', '$name_save', '$date');";
            echo $sql."<br>";
            $result = mysql_query($sql, $connect);

            if(!$result){
                echo"<h3>파일 업로드 실패!!<h3>";
                exit;
            }
            else{
                echo"<h3>파일 업로드 성공</h3>";
                echo '<a href="file_list.php">업로드 파일 목록</a>';
            }
        }

    } 
    else {
        echo "<h3>파일이 업로드 되지 않았습니다.</h3>";
        echo '<a href="javascript:history.go(-1);">이전 페이지</a>';
    }

    mysql_close();

?>