<?php
if(isset($_POST['submit']))
{
	/*$target_dir = "images/";
	$target_file = $target_dir.basename($_FILES["file"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }*/
	$file = $_POST['file'];
	$width = 320;
	if(isset($_POST['width']) && $_POST['width'] != '')
		$width = (int)$_POST['width'];
	$height = 320;
	if(isset($_POST['height']) && $_POST['height'] != '')
		$height = (int)$_POST['height'];
	$padding = 0.00;
	if(isset($_POST['padding']) && $_POST['padding'] != '')
		$padding = (float)$_POST['padding'];
	$output = exec('python text_recognition.py -east frozen_east_text_detection.pb -w '.$width.' -e '.$height.' -p '.$padding.' -i images/'.$file.' > '.explode(".",$file)[0].'_output.txt',$msg,$return);
	$fp = fopen(explode(".",$file)[0].'_output.txt','r');
	$output = fread($fp,filesize(explode(".",$file)[0].'_output.txt'));
	fclose($fp);
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Text Recognition</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
  <div class="container">
  <br>
  <h2 class="text-center">Text Recognition</h2><br>
	<?php if(isset($output)) echo '<div class="alert alert-success"><h3>Detected Text: '.$output.'<h3></div>'; ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="ipFile">Choose Image File</label>
            <input type="file" class="form-control" placeholder="Input File" id="ipFile" name="file" required>
        </div>
        <div class="form-group">
            <label for="width">Width</label>
            <input type="number" class="form-control" id="width" name="width" placeholder="Width" oninput="xyz()">
        </div>
        <div class="form-group">
            <label for="height">Height</label>
            <input type="number" class="form-control" id="height" name="height" placeholder="Height" oninput="xyz()">
        </div>
        <div class="form-group">
            <label for="padding">Padding</label>
            <input type="text" class="form-control" id="padding" name="padding" placeholder="Padding" oninput="xyz()">
        </div>
        <button type="submit" name="submit" class="btn btn-primary float-right" id="sub">Extract</button>
    </form>
</div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
function xyz()
{
	if(Number(document.getElementById("width").value)%32 != 0) {
		document.getElementById("sub").disabled = true;
	}
	else if(Number(document.getElementById("height").value)%32 != 0) {
		document.getElementById("sub").disabled = true;
	}
	else if(Number(document.getElementById("padding").value)<0 || Number(document.getElementById("padding").value) > 1) {
		document.getElementById("sub").disabled = true;
	}
	else
		document.getElementById("sub").disabled = false;
}
</script>
</body>
</html>