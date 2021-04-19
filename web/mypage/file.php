<!DOCTYPE html>
<html>
<head>
<title>Upload Folder using PHP </title>
</head>
<body>
<form action="#" method="post" enctype="multipart/form-data">
Type Folder Name:<input type="text" name="foldername" /><br/><br/>
Select Folder to Upload: <input type="file" name="files[]" id="files" multiple directory="" webkitdirectory="" moxdirectory="" /><br/><br/>
<input type="Submit" value="Upload" name="upload" />
</form>

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
if(isset($_POST['upload']))
{
  if($_POST['foldername'] != "")
  {
    $foldername= "../user/"."Jimin"."/".$_POST['foldername']; // gwonil은 유저 이름. mysql에서 가져오기
    #$foldername= $_POST['foldername']; // gwonil은 유저 이름. mysql에서 가져오기
    echo $foldername;
    if(!is_dir($foldername)) mkdir($foldername, 0777, true);
    foreach($_FILES['files']['name'] as $i => $name)
  {
        if(strlen($_FILES['files']['name'][$i]) > 1)
        {  
          move_uploaded_file($_FILES['files']['tmp_name'][$i],$foldername."/".$name);
        }
    }
    echo "Folder is successfully uploaded";
  }
  else
      echo "Upload folder name is empty";
}

if(isset($_POST['select_model']))
{
    echo $_POST['model'];
}
?>