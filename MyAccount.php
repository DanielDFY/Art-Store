<?php
session_start();
$DB_HOST="localhost";
$DB_USER="root";
$DB_PASS="";

$con = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);

if(!$con){
    die("Could not connect ".mysqli_connect_error());
}

mysqli_query($con,'SET NAMES UTF8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" type="text/css" href="CSS/header.css" />
    <link rel="stylesheet" type="text/css" href="CSS/userDetails.css" />
    <link rel="stylesheet" type="text/css" href="CSS/myAccount.css" />
    <link rel="stylesheet" type="text/css" href="CSS/footer.css" />
    <link rel="stylesheet" href="CSS/font-awesome/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="JS/header.js"></script>
    <script src="JS/myAccount.js"></script>

    <title>Art Store</title>
</head>
<body>
    <?php echo include "phpModule/Header.php"; ?>
    <?php include "phpModule/FootPrint.php"?>
    <div id="footPrint">
        <p><a href="Index.php">Home Page</a><?php updateFootPrint("My Account"); showFootPrint();?></p>
    </div>
    <div id="headerBack"></div>

    <div id="search">
        <input type="search" name="search" placeholder="Search" autocomplete="off"><a href="Search.php"><button onclick="searchBtn()">
                <i class="fa fa-search"></i></button></a>
    </div>

    <div id="container">
        <div id="accountDetails">
            <img class="userPhoto" src="images/user_default.png">
            <p><i class="fa fa-tag"></i> : <span class="userName" id="detailUsrN"></span></p>
            <p><i class="fa fa-envelope"></i> : <span class="userEmail" id="detailUsrE"></span></p>
            <p><i class="fa fa-phone"></i> : <span class="userTel" id="detailUsrT"></span></p>
            <p><i class="fa fa-bed"></i> : <span class="userAdr" id="detailUsrA"></span></p>
            <p><i class="fa fa-dollar"></i> : <span class="userAdr" id="detailUsrB"></span></p>
            <button id="messageBtn"><i class="fa fa-comment"></i></button>
            <button id="rechargeBtn"><i class="fa fa-credit-card"></i></button>
            <button id="signOutBtn" onclick="confirmSignOut()"><i class="fa fa-sign-out" ></i>&nbsp;Sign out</button>
        </div>

        <div id="records">
            <div id="offered" class="record">
                <p class="title">Works I've offered : <a href="workPublish.php" class="moreBtn"> <i class="fa fa-plus-square"></i></a></p>
                <ul class="recordContainer"></ul>
            </div>
            <div id="orders" class="record">
                <p class="title">Works I've purchased : <a href="#" class="moreBtn"><i class="fa fa-ellipsis-h"></i></a></p>
                <ul class="recordContainer"></ul>
            </div>

            <div id="sold" class="record">
                <p class="title">Works I've sold : <a href="#" class="moreBtn"><i class="fa fa-ellipsis-h"></i></a></p>
                <ul class="recordContainer"></ul>
            </div>
        </div>
    </div>

    <form id="recharge">
        <div class="container">
            <p>Please input the amount of money :</p>
            <i class="fa fa-dollar"></i> <input type="text" name="recharge" placeholder="Positive integer required"><span class="hint"> <i class="fa fa-exclamation" ></i></span><br>
            <button type="button" id="rechargeCancel">Cancel</button><button type="button" id="rechargeConfirm">Confirm</button>
        </div>
    </form>

    <?php echo include "phpModule/Footer.php"; ?>
</body>
</html>