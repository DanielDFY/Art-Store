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
$userDetails = [];
$artworksOffered = [];
$artworksSold = [];
$orders = [];


mysqli_select_db($con,"project_2");
$sql_userDetails = "SELECT * FROM users WHERE name = '".$user."'";
$result = mysqli_query($con,$sql_userDetails);
$row = $result->fetch_assoc();
$userID = $row['userID'];
$userDetails = ['name'=>$row['name'],'email'=>$row['email'],'tel'=>$row['tel'],'address'=>$row['address'],'balance'=>$row['balance']];

$sql_worksOffered = "SELECT artworkID,title,timeReleased,orderID FROM artworks WHERE ownerID = ".$userID." ORDER BY timeReleased DESC";
$result = mysqli_query($con,$sql_worksOffered);
for($i=0;$row = $result->fetch_assoc();$i++){
    $artworksOffered[$i] = ['artworkID'=>$row['artworkID'],'title'=>$row['title'],'timeReleased'=>$row['timeReleased']];
}

$sql_worksSold = "SELECT artworkID,title,orderID,price FROM artworks WHERE ownerID = ".$userID." AND (orderID is not NULL and orderID <> '')";
$result = mysqli_query($con,$sql_worksSold);
for($i=0;$row = $result->fetch_assoc();$i++){
    $sql_order = "SELECT ownerID,timeCreated FROM orders WHERE orderID = ".$row['orderID'];
    $order = mysqli_query($con,$sql_order);
    $orderDetails = $order->fetch_assoc();
    $buyerID = $orderDetails['ownerID'];
    $sql_buyer = "SELECT * FROM users WHERE userID = ".$buyerID;
    $getBuyer = mysqli_query($con,$sql_buyer);
    $buyerDetails = $getBuyer->fetch_assoc();
    $artworksSold[$i] = ['artworkID'=>$row['artworkID'],'title'=>$row['title'],'timeSold'=>$orderDetails['timeCreated'],'price'=>$row['price'],'buyerDetails'=>['name'=>$buyerDetails['name'],'email'=>$buyerDetails['email'],'tel'=>$buyerDetails['tel'],'address'=>$buyerDetails['address']]];
}

$sql_order = "SELECT * FROM orders WHERE ownerID = ".$userID." ORDER BY timeCreated DESC";
$result = mysqli_query($con,$sql_order);
for($i=0;$row = $result->fetch_assoc();$i++){
    $itemList = [];
    $sql_orderItems = "SELECT artworkID,title,price FROM artworks WHERE orderID = ".$row['orderID'];
    $items = mysqli_query($con,$sql_orderItems);
    for($j=0;$item=$items->fetch_assoc();$j++){
        $itemList[$j] = ['title'=>$item['title'],'artworkID'=>$item['artworkID'],'price'=>$item['price']];
    }
    $orders[$i] = ['orderID'=>$row['orderID'],'orderTime'=>$row['timeCreated'],'orderSum'=>$row['sum'],'items'=>$itemList];
}

echo json_encode(['userDetails'=>$userDetails,'artworksOffered'=>$artworksOffered,'artworksSold'=>$artworksSold,'orders'=>$orders]);