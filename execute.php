<?php
$file = $_POST['file'];
$width = 128;
if(isset($_POST['width']))
	$width = $_POST['width'];
$height = 192;
if(isset($_POST['height']))
	$width = $_POST['height'];
$padding = 0.5;
if(isset($_POST['padding']))
	$width = $_POST['padding'];
echo exec('python text_recognition.py -east frozen_east_text_detection.pb -w '.$width.' -e '.$height.' -p '.$padding.' -i '.$file,$msg,$return);

?>