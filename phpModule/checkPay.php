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

$user = $_POST['user'];
$cartList = json_decode($_POST['cartList']);
$time = $_POST['time'];

mysqli_select_db($con,"project_2");
$sql_userDetails = "SELECT * FROM users WHERE name = '".$user."'";
$result = mysqli_query($con,$sql_userDetails);
$row = $result->fetch_assoc();
$userID = $row['userID'];

$deleteList = [];
$soldList = [];
$changeList = [];

$totalPrice = 0;

$flag = true;
for($i=0;$i<count($cartList);$i++){
    $artworkID = $cartList[$i]->artworkID;
    $price = $cartList[$i]->price;
    $sql_check = "SELECT title,orderID,price FROM artworks WHERE artworkID = ".$artworkID;
    $result = mysqli_query($con,$sql_check);
    if(!$result){
        array_push($deleteList,['position'=>$i]);
        $sql_delete = "DELETE FROM carts WHERE artworkID = ".$artworkID;
        mysqli_query($con,$sql_delete);
        $flag = false;
    }
    else{
        while ($row = $result->fetch_assoc()){
            if($row['orderID']){
                array_push($soldList,['position'=>$i]);
                $sql_delete = "DELETE FROM carts WHERE artworkID = ".$artworkID;
                mysqli_query($con,$sql_delete);
                $flag = false;
            }
            else if($row['price']!=$price){
                array_push($changeList,['position'=>$i]);
                $sql_delete = "DELETE FROM carts WHERE artworkID = ".$artworkID;
                mysqli_query($con,$sql_delete);
                $flag = false;
            }
        }
    }
}

if(!$flag){
    echo json_encode(['flag'=>"fail",'deleteList'=>$deleteList,'soldList'=>$soldList,'changeList'=>$changeList]);
}
else{
    $sql_worksAdded = "SELECT artworkID FROM carts WHERE userID = ".$userID;
    $result = mysqli_query($con,$sql_worksAdded);
    for($i=0;$row = $result->fetch_assoc();$i++){
        $sql_item="SELECT price FROM artworks WHERE artworkID = ".$row['artworkID'];
        $items=mysqli_query($con,$sql_item);
        $item=$items->fetch_assoc();
        $totalPrice+=$item['price'];
    }

    $sql_checkBalance = "SELECT balance FROM users WHERE userID = ".$userID;
    $result = mysqli_query($con,$sql_checkBalance);
    $row=$result->fetch_assoc();
    $userBalance = $row['balance'];
    if($userBalance<$totalPrice){
        echo json_encode(['flag'=>"money"]);
    }
    else{
        $sql_order = "INSERT INTO orders (ownerID,sum,timeCreated) VALUES (".$userID.",".$totalPrice.",'".$time."')";
        mysqli_query($con,$sql_order);
        $orderID = mysqli_insert_id($con);
        if($orderID){
            for($i=0;$i<count($cartList);$i++) {
                $artworkID = $cartList[$i]->artworkID;
                $sql_orderItem = "UPDATE artworks SET orderID = ".$orderID." WHERE artworkID = ".$artworkID;
                mysqli_query($con,$sql_orderItem);
                $sql_orderItem = "SELECT ownerID,price FROM artworks WHERE artworkID = ".$artworkID;
                $itemPrice = mysqli_query($con,$sql_orderItem);
                $itemPrice = $itemPrice->fetch_assoc();
                $owner = $itemPrice['ownerID'];
                $itemPrice = $itemPrice['price'];
                $sql_itemPay = "SELECT balance FROM users WHERE userID =".$owner;
                $oldBalance = mysqli_query($con,$sql_itemPay);
                $oldBalance = $oldBalance->fetch_assoc();
                $oldBalance = $oldBalance['balance'];
                $newBalance = $oldBalance + $itemPrice;
                $sql_itemPay = "UPDATE users SET balance = ".$newBalance." WHERE userID = ".$owner;
                mysqli_query($con,$sql_itemPay);
            }
            $balanceLeft = $userBalance-$totalPrice;
            $sql_payment = "UPDATE users SET balance = ".$balanceLeft." WHERE userID = ".$userID;
            mysqli_query($con,$sql_payment);
            $sql_emptyCart = "DELETE FROM carts WHERE userID = ".$userID;
            mysqli_query($con,$sql_emptyCart);
        }

        echo json_encode(['flag'=>"success"]);
    }
}
