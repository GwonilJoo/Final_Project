<?php
$data1 = shell_exec("unzip ../Dataset/gwonil/pictures.zip");
$data2 = shell_exec("chmod 777 'Saved Pictures'");
echo "<pre> $data1 </pre>";
?>