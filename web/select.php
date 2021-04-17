<!DOCTYPE html>
<html>
<head>
<title>Select model using PHP</title>
</head>
<body>
<form action="#" method="post">
    Select model<br>
    <select name='model'>
        <option value='resnet' selected>Image classification</option>
        <option value='yolo'>object_detection</option>
        <option value='mask'>image_segmentation</option>
    </select>

    <input type="Submit" value="select_model" name="select_model" />
</form>
</body>
</html>

<?php
if(isset($_POST['select_model']))
{
    echo $_POST['model'];
}
?>