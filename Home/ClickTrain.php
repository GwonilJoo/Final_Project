<?php session_start();?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Upload Folder using PHP </title>
</head>
<body>

<form action="Chart.php" method="post">
    Select model<br>
    <select name='model'>
        <option value='resnet' selected>Image classification</option>
        <option value='yolo'>object_detection</option>
        <option value='mask'>image_segmentation</option>
    </select>
    <br>
    <input type="Submit" value="select_model" name="start train" />
</form>

</body>
</html>