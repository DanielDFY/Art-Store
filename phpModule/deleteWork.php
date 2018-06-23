<?php
header('content="text/html;charset=utf-8"');

$DB_HOST="localhost";
$DB_USER="root";
$DB_PASS="";

$con = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);

if(!$con){
    die("Could not connect ".mysqli_connect_error());
}

mysqli_select_db($con,"project_2");

$artworkID = $_POST['artworkID'];
$sql = "DELETE FROM artworks WHERE artworkID = '".$artworkID."'";
mysqli_query($con,$sql);
