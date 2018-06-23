<?php
function showFootPrint(){
    $result = "";
    $list = $_SESSION["footPrint"];
    for($i=0;$i<count($list);++$i)
        $result.= "<a href='".name2link($list[$i])."'> <i class='fa fa-caret-right'></i> ".$list[$i]."</a>";
    echo $result;
}
function name2link($name){
    $link="#";
    switch($name){
        case "Home Page":
            $link = "../Index.php";
            break;
        case "Search":
            $link = "Search.php";
            break;
        case "My Account":
            $link = "MyAccount.php";
            break;
        case "Shopping Cart":
            $link = "ShoppingCart.php";
            break;
        case "Item Detail":
            $link = "ArtDemo.php";
            break;
    }
    return $link;
}
function updateFootPrint($fp){
    if(!isset($_SESSION["footPrint"])){
        $_SESSION["footPrint"]=array();
    }
    if(in_array("Item Detail",$_SESSION["footPrint"])||in_array("Item Update",$_SESSION["footPrint"])||in_array("Item Publish",$_SESSION["footPrint"]))footPrintPop();
    $list = $_SESSION["footPrint"];
    $key = count($list);
    for($i=0;$i<count($list);++$i){
        if($fp===$list[$i]){
            $key=$i;
            break;
        }
    }
    if($key!=count($list)){
        $_SESSION["footPrint"] = array_slice($list,0,$key+1);
    }
    else array_push($_SESSION["footPrint"],$fp);
}

function footPrintPop(){
    array_pop($_SESSION["footPrint"]);
}
?>