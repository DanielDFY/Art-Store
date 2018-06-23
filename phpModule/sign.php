<?php
header('content="text/html;charset=utf-8"');

$DB_HOST="localhost";
$DB_USER="root";
$DB_PASS="";

$con = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);

if(!$con){
    die("Could not connect ".mysqli_connect_error());
}


$usrn = $_POST['signUsrn'];
$usrp = $_POST['signPass'];
echo checkSign($usrn,$usrp);

function checkSign($usrn,$usrp){
    global $con;
    mysqli_select_db($con,'project_2');
    $sql = "SELECT name,password FROM users";
    $result = mysqli_query($con,$sql);
    $flag = false;
    while($row = $result->fetch_assoc())
        if($usrn == $row['name']){
            $flag = true;
            break;
        }
    if(!$flag)
        return "unregistered name";
    else{
        if($usrp===$row['password'])
            $flag = false;
        if($flag)
            return "wrong password";
        else{
            return "success";
        }

    }
}

