<?php
header('content="text/html;charset=utf-8"');

if(!isset($_SESSION["user"])){
    $_SESSION["user"]="";
}

$DB_HOST="localhost";
$DB_USER="root";
$DB_PASS="";

$con = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);

if(!$con){
    die("Could not connect ".mysqli_connect_error());
}

mysqli_select_db($con,"project_2");

$name = $_POST['user'];
$money = $_POST['money'];
$sql = "SELECT balance FROM users WHERE name = '".$name."'";
$result = mysqli_query($con,$sql);
$row = $result->fetch_assoc();
$sum = $money+$row['balance'];

$sql = "UPDATE users SET balance = ".$sum." WHERE name = '".$name."'";
mysqli_query($con,$sql);
echo $sum;