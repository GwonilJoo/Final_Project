<meta charset="UTF-8">
<?php
    $connect = mysql_connect("localhost", "root", "apmsetup");
    mysql_set_charset("utf8", $connect);
    mysql_select_db("final_db", $connect);
    
    $sql = "SELECT file_id, name_ori, name_save FROM upload_file ORDER BY reg_time DESC";
    $result = mysql_query($sql, $connect);

    $fields = mysql_num_fields($result);
?>

<table border="1">
    <tr>
        <th>파일 아이디</th>
        <th>원래 파일명</th>
        <th>저장된 파일명</th>
    </tr>

<?php
    while($row = mysql_fetch_array($result)){
        echo "<tr>";
        echo "<td> $row[file_id] </td>";
        echo "<td><a href='download.php?file_id=".$row['file_id']."'>".$row['name_ori']."</a></td>";
        echo "<td> $row[name_save] </td>";
        echo "</tr>";
    }
    mysql_close();
?>
</table>


