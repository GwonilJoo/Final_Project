<?php session_start();?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Upload Folder using PHP </title>

<style media="screen">

div { width: 50%; height: 30px; float:left; border:5px solid gold;}
</style>

</head>
<body>
<form action="Chart.php" method="post">
    <fieldset>
        <legend>모델 설정</legend>
        <table>
            <tr>
                <td>분야</td>
                <td>
                    <select name='model'>
                        <option value='resnet' selected>Image classification</option>
                        <option value='yolo'>object_detection</option>
                        <option value='mask'>image_segmentation</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>에폭</td>
                <td>
                    <input type="text" value=1 name="epochs">
                </td>
            </tr>
            <tr>
                <td>배치 사이즈</td>
                <td>
                    <select name='batch_size'>
                        <option value=1 selected>1</option>
                        <option value=2>2</option>
                        <option value=4>4</option>
                        <option value=8>8</option>
                        <option value=16>16</option>
                        <option value=32>32</option>
                        <option value=100>100</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>모델 이름</td>
                <td>
                    <input type="text" value='model' name="save_file">
                </td>
            </tr>
            <tr>
                <td>랜덤 시드</td>
                <td>
                    <input type="text" value=1 name="random_seed">
                </td>
            </tr>
        </table>
        <input type="Submit" value="select_model"/>
    </fieldset>
</form>

</body>
</html>