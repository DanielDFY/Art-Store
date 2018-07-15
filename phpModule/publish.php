<?php
header('content="text/html;charset=utf-8"');

$DB_HOST="localhost";
$DB_USER="root";
$DB_PASS="";

$con = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);

if(!$con){
    die("Could not connect ".mysqli_connect_error());
}

mysqli_query($con,'SET NAMES UTF8');

$file = $_FILES['workFile'];
$title = $_POST['title'];
$artist = $_POST['artist'];
$description = $_POST['description'];
$date = $_POST['date'];
$genre = $_POST['genre'];
$width = $_POST['width'];
$height = $_POST['height'];
$price = $_POST['price'];
$time = $_POST['time'];
$owner = $_POST['owner'];

mysqli_select_db($con,"project_2");
$sql_getUser = "SELECT userID FROM users WHERE name = '".$owner."'";
$userData = mysqli_query($con,$sql_getUser);
$result = $userData->fetch_assoc();
$ownerID = $result['userID'];

$sql_add = "INSERT INTO artworks (title,artist,description,yearOfWork,genre,width,height,price,ownerID,timeReleased) VALUES ('".$title."','".$artist."','".$description."','".$date."','".$genre."','".$width."','".$height."','".$price."','".$ownerID."','".$time."')";
$result = mysqli_query($con,$sql_add);

$sql_getArtwork = "SELECT artworkID FROM artworks WHERE title = '".$title."'";
$artworkData = mysqli_query($con,$sql_getArtwork);
$result = $artworkData->fetch_assoc();
$artworkID = $result['artworkID'];
$imageFileName = $artworkID.".jpg";

$sql_update = "UPDATE artworks SET imageFileName = '".$imageFileName."' WHERE artworkID = '".$artworkID."'";
$update = mysqli_query($con,$sql_update);

move_uploaded_file($file['tmp_name'],"../images/img/".$artworkID.".jpg");