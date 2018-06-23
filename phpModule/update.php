<?php
header('content="text/html;charset=utf-8"');

$DB_HOST="localhost";
$DB_USER="root";
$DB_PASS="";

$con = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);

if(!$con){
    die("Could not connect ".mysqli_connect_error());
}

$title = $_POST['title'];
$artist = $_POST['artist'];
$description = $_POST['description'];
$date = $_POST['date'];
$genre = $_POST['genre'];
$width = $_POST['width'];
$height = $_POST['height'];
$price = $_POST['price'];
$artworkID = $_POST['workID'];

mysqli_select_db($con,"project_2");
$sql = "UPDATE artworks SET title = '".$title."',artist = '".$artist."',description = '".$description."',genre = '".$genre."',width = '".$width."',height = '".$height."',price = '".$price."' WHERE artworkID = '".$artworkID."'";
mysqli_query($con,$sql);
$sql = "UPDATE artworks SET date = '".$date."' WHERE artworkID = '".$artworkID."'";

if($file = $_FILES['workFile']){
    move_uploaded_file($file['tmp_name'],"../images/img/".$artworkID.".jpg");
}