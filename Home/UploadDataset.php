<?php session_start();?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Upload Folder using PHP </title>
</head>
<body>
<form action="#" method="post" enctype="multipart/form-data">
Type Folder Name:<input type="text" name="foldername" /><br/><br/>
Select Folder to Upload: <input type="file" name="files[]" id="files" multiple directory="" webkitdirectory="" moxdirectory="" /><br/><br/>
<input type="Submit" value="Upload" name="upload" />
</form>
</body>
</html>

<?php
if(isset($_POST['upload']))
{
  if($_POST['foldername'] != "")
  {
    $foldername= "../../dataset/".$_SESSION['id']."/".$_POST['foldername']; // gwonil은 유저 이름. mysql에서 가져오기
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
    echo '<script>alert("Folder is successfully uploaded")</script>';
  }
  else
      echo '<script>alert("Upload folder name is empty")</script>';
}
?>
