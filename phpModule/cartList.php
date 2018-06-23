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

$user = $_POST['user'];
mysqli_select_db($con,"project_2");
$sql_userDetails = "SELECT * FROM users WHERE name = '".$user."'";
$result = mysqli_query($con,$sql_userDetails);
$row = $result->fetch_assoc();
$userID = $row['userID'];

$cartList = [];
$sql_worksAdded = "SELECT artworkID FROM carts WHERE userID = ".$userID;
$result = mysqli_query($con,$sql_worksAdded);
for($i=0;$row = $result->fetch_assoc();$i++){
    $sql_item="SELECT title,description,price FROM artworks WHERE artworkID = ".$row['artworkID'];
    $items=mysqli_query($con,$sql_item);
    $item=$items->fetch_assoc();
    $intro = $item["description"];
    if(strlen($intro)>75)
        $intro = substr($intro,0,75)."...";
    $cartList[$i] = ["artworkID"=>$row['artworkID'],"title"=>$item['title'],"description"=>$intro,"price"=>$item['price']];
}

echo json_encode(["cartList"=>$cartList]);