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
$para = $_POST['para'];
$user = $_POST['user'];
$sql = "SELECT userID FROM users WHERE name = '".$user."'";
$result = mysqli_query($con,$sql);
$row=$result->fetch_assoc();
$userID = $row['userID'];

$sql = "SELECT userID FROM carts WHERE artworkID = '".$artworkID."'";
$result = mysqli_query($con,$sql);
if($para==="check"){
    if(!$result)
        echo "removed";
    else{
        $flag = false;
        while($row=$result->fetch_assoc()){
            if($row['userID']===$userID){
                $flag=true;
                break;
            }
        }
        if($flag)
            echo "added";
        else
            echo "removed";
    }
}
else if($para==="switch"){
    if(!$result){
        $sql_add = "INSERT INTO carts (userID,artworkID) VALUES (".$userID.",".$artworkID.")";
        mysqli_query($con,$sql_add);
        echo "added";
    }
    else{
        $flag = false;
        while($row=$result->fetch_assoc()){
            if($row['userID']===$userID){
                $flag=true;
                break;
            }
        }
        if($flag){
            $sql_delete = "DELETE FROM carts WHERE artworkID = '".$artworkID."' AND userID = ".$userID;
            mysqli_query($con,$sql_delete);
            echo "removed";
        }
        else{
            $sql_add = "INSERT INTO carts (userID,artworkID) VALUES (".$userID.",".$artworkID.")";
            mysqli_query($con,$sql_add);
            echo "added";
        }
    }
}





