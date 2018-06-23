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
$user = $_POST['user'];
$sql = "SELECT userID FROM users WHERE name = '".$user."'";
$result = mysqli_query($con,$sql);
$row=$result->fetch_assoc();
$userID = $row['userID'];

$sql = "SELECT orderID,ownerID FROM artworks WHERE artworkID = '".$artworkID."'";
$result = mysqli_query($con,$sql);
$row = $result->fetch_assoc();
if($row['orderID'])
    echo "sold";
else{
    if($row['ownerID']===$userID)
        echo "owner";
    else
        echo "unsold";
}