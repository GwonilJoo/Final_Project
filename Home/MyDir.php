<?php
    session_start();
    
    // echo "{$_SESSION['id']}";
    // echo "{$_SESSION['passwd']}";

    function ListFolder(){

    }

    $dir = "../Dataset/";
    $dir = $dir.$_SESSION['id'];
    $cnt = 0;

    $dir_handle=opendir($dir);

    while(($file=readdir($dir_handle)) !== false){
        $fname = $file;

        if($fname == "." || $fname == ".."){
            continue;
        }

        echo $fname."<br>";
        $cnt++;
    }

    closedir($dir_handle);

?>