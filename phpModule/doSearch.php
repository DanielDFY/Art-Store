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

$resultList = [];
$key = $_POST['key'];
$keyType = $_POST['keyType'];
$sortBy = $_POST['sortBy'];
$currentPage = $_POST['currentPage'];

mysqli_select_db($con,'project_2');
$resultSql = "SELECT * FROM artworks";
$limitation = "";


if($keyType){
    $limitation = " WHERE ".$keyType." LIKE '%".$key."%' AND orderID is NULL";
}
else {
    $keyList = explode(",",$key);
    for($i=0;$i<3;++$i) if(!$keyList[$i])$keyList[$i]  = "";
    $limitation = " WHERE title LIKE '%".$keyList[0]."%' AND artist LIKE '%".$keyList[1]."%' AND description LIKE '%".$keyList[2]."%' AND orderID is NULL";
}

$result = mysqli_query($con,$resultSql.$limitation);
$totalNum = mysqli_num_rows($result);
$startNum = 6*($currentPage-1);

$result = mysqli_query($con,$resultSql.$limitation." ORDER BY ".$sortBy." DESC LIMIT ".$startNum.",6");

for($i=0;$row = $result->fetch_assoc();++$i){
    $resultList[$i] = ['artworkID'=>$row['artworkID'],'title'=>$row['title'],'artist'=>$row['artist'],'description'=>$row['description'],'imageFileName'=>$row['imageFileName'],'view'=>$row['view'],'price'=>$row['price']];
}

echo json_encode(["result"=>$resultList,"totalNum"=>$totalNum]);


