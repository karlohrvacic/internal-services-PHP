<!DOCTYPE html>
<html lang="hr">
  <head>
    <title>Upload Foldera</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
	<div class="container-fluid main">
		<div class="infobox p-3">
			<form action="" method="post" enctype="multipart/form-data" >
				<div class="mb-3">
					<label for="exampleFormControlInput1" class="form-label" >Upiši ime foldera:</label>
					<input type="text" class="form-control" name="foldername" id="exampleFormControlInput1">
				</div>
				<label for="formFileLg" class="form-label">Odaberi folder za upload:</label>
			  <input class="form-control form-control-lg" id="formFile files" type="file" name="files[]" i multiple directory="" webkitdirectory="" moxdirectory="">
			  <input class="form-control" type="text" name="PIN">
                <input type="Submit" value="Upload" name="upload" class="btn btn-primary m-2" />
			</form>
			<a href="index.html"><button class="btn btn-outline-secondary">povratak na izbornik</button></a>
		</div>
  </body>
</html>
<?php
	if(isset($_POST['upload'])){
        if ($_POST['PIN'] == '4543'){
            if($_POST['foldername'] != ""){
                $foldername=$_POST['foldername'];
                $foldername = "files/" . $foldername;
                if(!is_dir($foldername)) mkdir($foldername);
                foreach($_FILES['files']['name'] as $i => $name){
                    if(strlen($_FILES['files']['name'][$i]) > 1){
                        move_uploaded_file($_FILES['files']['tmp_name'][$i],$foldername."/".$name);
                    }
                }
                echo "Folder is successfully uploaded";
            }
            else
                echo "Upload folder name is empty";
        }
        else {
            echo "Wrong password";
        }
    }

?>
