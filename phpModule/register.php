<?php
header('content="text/html;charset=utf-8"');
session_start();

$DB_HOST="localhost";
$DB_USER="root";
$DB_PASS="";

$con = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);

if(!$con){
    die("Could not connect ".mysqli_connect_error());
}


$usrn = $_POST['registerUsrn'];
$usrp = $_POST['registerPass'];
$email = $_POST['registerEmail'];
$tel = $_POST['registerTel'];
$address = $_POST['registerAdr'];

function checkRegister($usrn,$usrp,$email,$tel,$address){
    global $con;
    mysqli_select_db($con,'project_2');
    $sql = "SELECT name FROM users";
    $result = mysqli_query($con,$sql);
    $flag = false;
    while($row = $result->fetch_assoc())
        if($usrn == $row['name']){
            $flag = true;
            break;
        }
    if($flag)
        return "registered name";
    else{
        $sql = "INSERT INTO users (name, email, password, tel, address, balance) VALUES ('".$usrn."','".$email."','".$usrp."','".$tel."','".$address."',0)";
        $result = mysqli_query($con,$sql);
        if($result)
            return "success";
        else
            return "fail to do sql";
    }
}

echo checkRegister($usrn,$usrp,$email,$tel,$address);