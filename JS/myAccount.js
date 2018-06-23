$(document).ready(function () {
    var loadUser = function (userDetails) {
        $("#detailUsrN").text(userDetails['name']);
        $("#detailUsrE").text(userDetails['email']);
        $("#detailUsrT").text(userDetails['tel']);
        $("#detailUsrA").text(userDetails['address']);
        $("#detailUsrB").text(userDetails['balance']);
    };

    var loadOffered = function(workList){
        var container = $("#offered .recordContainer");
        container.empty();
        for(var i=0;i<workList.length;i++){
            var item = workList[i];
            container.append('<li><a href="ArtDemo.php?workID='+item['artworkID']+'"><div class="recordBlock">' +
                '<p><img src="./images/img/'+item['artworkID']+'.jpg">' +
                '<div class="detail">' +
                '<span class="name">'+item['title']+'</span>' +
                '<span class="timeOffered">'+item['timeReleased']+'</span>' +
                '<button class="deleteItem offeredBtn" value="'+item['artworkID']+'">Delete</button>' +
                '<button class="editItem offeredBtn" value="'+item['artworkID']+'">Edit</button></div>' +
                '</p></div></a></li>');
        }
        $(".editItem").click(function () {
            var artworkID = this.value;
            $.ajax({
                type: 'post',
                async: false,
                url: './phpModule/checkSold.php',
                data: {artworkID:artworkID,user:getCookie("user")},
                success: function (data) {
                    if(data==="sold"){
                        var alertBody = document.getElementById("alert");
                        alertBody.getElementsByClassName("alertText")[0].innerHTML = "This artwork has been sold!";
                        alertBody.style.visibility = "visible";
                        alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
                    }
                    else {
                        var str = artworkID;
                        location.href = "workUpdate.php?artworkID=" + str + ".jpg";
                    }
                },
                error: function () {
                    console.log("error");
                }
            });
            return false;
        });

        $(".deleteItem").click(function () {
            var artworkID = this.value;
            $.ajax({
                type: 'post',
                async: false,
                url: './phpModule/checkSold.php',
                data: {artworkID:artworkID},
                success: function (data) {
                    if(data==="sold"){
                        var alertBody = document.getElementById("alert");
                        alertBody.getElementsByClassName("alertText")[0].innerHTML = "This artwork has been sold!";
                        alertBody.style.visibility = "visible";
                        alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
                    }
                    else{
                        var alertBody = document.getElementById("alert");
                        alertBody.getElementsByClassName("alertText")[0].innerHTML = "Do you want to delete this artwork?";
                        alertBody.getElementsByClassName("cancel")[0].style.visibility = "visible";
                        alertBody.getElementsByClassName("confirm")[0].style.visibility = "visible";
                        alertBody.getElementsByClassName("ok")[0].style.visibility = "hidden";
                        alertBody.getElementsByClassName("confirm")[0].onclick = function (){
                            $.ajax({
                                type: 'post',
                                async: false,
                                url: './phpModule/deleteWork.php',
                                data: {artworkID:artworkID},
                                success: function (data) {
                                    window.location.reload();
                                },
                                error: function () {
                                    console.log("error");
                                }
                            });
                            ok();
                        };
                        alertBody.style.visibility = "visible";
                    }
                },
                error: function () {
                    console.log("error");
                }
            });
            return false;
        });
    };

    var loadOrder = function(orderList){
        var container = $("#orders .recordContainer");
        container.empty();
        for(var i=0;i<orderList.length;i++){
            var order = orderList[i];
            var orderStr = '<table class="orderContainer">' +
                '<tr><td class="orderHead"></td>' +
                '<td class="orderDetails">' +
                '<p>Order No.&nbsp;&nbsp;&nbsp;: <span class="orderID">'+order['orderID']+'</span></p>' +
                '<p>Order time&nbsp;&nbsp;: <span class="timeCreated">'+order['orderTime']+'</span></p>' +
                '<p>Total price&nbsp;&nbsp;: $<span class="totalPrice">'+order['orderSum']+'</span></p>' +
                '</td><td class="orderItems">';
            var list = order['items'];
            for(var j=0;j<list.length;++j){
                orderStr += '<li><a href="ArtDemo.php?workID='+list[j]['artworkID']+'"><div class="recordBlock">' +
                    '<img src="./images/img/'+list[j]['artworkID']+'.jpg">' +
                    '<div class="detail"><p><span class="name">'+list[j]['title']+'</span><span class="price">$'+list[j]['price']+'</span></p></div>' +
                    '</div></a></li>';
            }
            orderStr += '</td></tr></table>';
            container.append(orderStr);
        }
    };

    var loadSold = function(soldList){
        var container = $("#sold .recordContainer");
        container.empty();
        for(var i=0;i<soldList.length;i++){
            var item = soldList[i];
            container.append('<li><a href="ArtDemo.php?workID='+item['artworkID']+'"><div class="recordBlock">' +
                '<img src="./images/img/'+item['artworkID']+'.jpg">' +
                '<table class="detail">' +
                '<tr><td class="soldWork"><span class="name">'+item['title']+'</span></td>' +
                '<td class="soldDetails"><span class="timeSold">'+item['timeSold']+'</span><span class="price">'+item['price']+'</span></td>' +
                '<td class="buyerName"><span>Buyer :</span><span>'+item['buyerDetails']['name']+'</span></td>' +
                '<td class="buyerDetails"><p><i class="fa fa-envelope"></i><span>'+item['buyerDetails']['email']+'</span></p><p><i class="fa fa-phone"></i> <span>'+item['buyerDetails']['tel']+'</span></p><p><i class="fa fa-bed"></i><span>'+item['buyerDetails']['address']+'</span></p></td>' +
                '</tr></table></div></a></li>');
        }
    };

    if(!getCookie('user')){
        var alertBody = document.getElementById("alert");
        alertBody.getElementsByClassName("alertText")[0].innerHTML = "Please sign in first!";
        alertBody.style.visibility = "visible";
        alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
        $(".ok").on("click",function () {
            location.href = "./Index.php";
        });
    }
    else{
        signed();
        var user = getCookie('user');
        $.ajax({
            type: 'post',
            async: false,
            url: './phpModule/getAccount.php',
            data: {user:user},
            success: function (data) {
                data = JSON.parse(data);
                loadUser(data.userDetails);
                loadOffered(data.artworksOffered);
                loadOrder(data.orders);
                loadSold(data.artworksSold);
            },
            error: function () {
                console.log("error");
            }
        });
    }

    $("#rechargeBtn").click(function () {
        $("#recharge").css("display","inline");
    });

    $("#rechargeConfirm").click(function () {
        var value = parseInt($("input[name='recharge']").val());
        var pattern = /^[0-9]*[1-9][0-9]*$/;
        if(pattern.exec(value)){
            $(".hint").css("visibility","hidden");
            $.ajax({
                type: 'post',
                async: false,
                url: './phpModule/recharge.php',
                data: {money:value,user:getCookie('user')},
                success: function (data) {
                    $("#recharge").css("display","none");
                    var alertBody = document.getElementById("alert");
                    alertBody.getElementsByClassName("alertText")[0].innerHTML = "Success!";
                    alertBody.style.visibility = "visible";
                    alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
                    $("#detailUsrB").text(data);
                },
                error: function () {
                    console.log("error");
                }
            })
        }
        else{
            $(".hint").css("visibility","visible");
            return false;
        }
    });
    $("#rechargeCancel").click(function () {
        $("#recharge").css("display","none");
    });
});



