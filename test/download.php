<?php
    $file_id = $_REQUEST['file_id'];
    $connect = mysql_connect("localhost", "root", "apmsetup");
    mysql_set_charset("utf8", $connect);
    mysql_select_db("final_db", $connect);

    $sql = "select file_id, name_ori, name_save from upload_file where file_id='$file_id'";
    $result = mysql_query($sql, $connect);
    $row = mysql_fetch_array($result);

    $name_ori = $row['name_ori'];
    $name_save = $row['name_save'];

    $fileDir = "data/";
    $fullPath = $fileDir."/".$name_save;
    $length = filesize($fullPath);

    header("Content-Type: application/octet-stream");
    header("Content-Length: $length");
    header("Content-Disposition: attachment; filename=".iconv('utf-8','euc-kr',$name_ori));
    header("Content-Transfer-Encoding: binary");

    $fh = fopen($fullPath, "r");
    fpassthru($fh);

    mysql_close();
    exit;
?>
<meta charset="UTF-8">