$(document).ready(function () {
    var binItemNum = 0;

    var loadUser = function (userDetails) {
        $("#detailUsrN").text(userDetails['name']);
        $("#detailUsrE").text(userDetails['email']);
        $("#detailUsrT").text(userDetails['tel']);
        $("#detailUsrA").text(userDetails['address']);
        $("#detailUsrB").text(userDetails['balance']);
    };

    var delectTemp = function (artworkID,title) {
        if(binItemNum>4)binItemNum=4;
        for(var i=binItemNum;i>0;i--){
            var itemBlockOld = document.getElementById("bin").getElementsByClassName("recordBlock")[i];
            var itemBlockNew = document.getElementById("bin").getElementsByClassName("recordBlock")[i-1];
            itemBlockOld.getElementsByTagName("img")[0].src = itemBlockNew.getElementsByTagName("img")[0].src;
            itemBlockOld.getElementsByTagName("a")[0].href = itemBlockNew.getElementsByTagName("a")[0].href;
            itemBlockOld.getElementsByClassName("name")[0].innerHTML = itemBlockNew.getElementsByClassName("name")[0].innerHTML;
            itemBlockOld.getElementsByTagName("button")[0].value = itemBlockNew.getElementsByTagName("button")[0].value;
            itemBlockOld.style.display = "inline-block";
        }
        var itemBlock = document.getElementById("bin").getElementsByClassName("recordBlock")[0];
        itemBlock.getElementsByTagName("img")[0].src = "./images/img/"+artworkID+".jpg";
        itemBlock.getElementsByTagName("a")[0].href = "ArtDemo.php?workID="+artworkID;
        itemBlock.getElementsByClassName("name")[0].innerHTML = title;
        itemBlock.getElementsByTagName("button")[0].value = artworkID;
        itemBlock.style.display = "inline-block";
        binItemNum++;

        $("#bin .recordBlock button").click(function () {
            for(var i=0;i<binItemNum;++i){
                var id = document.getElementById("bin").getElementsByClassName("recordBlock")[i].getElementsByTagName("button")[0].value;
                var name = document.getElementById("bin").getElementsByClassName("recordBlock")[i].getElementsByClassName("name")[0].innerHTML;
                if(this.value===id){
                    restore(id,name,i);
                }
            }
            $.ajax({
                type: 'post',
                async: false,
                url: './phpModule/cartList.php',
                data: {user:getCookie('name')},
                success: function (data) {
                    data = JSON.parse(data);
                    loadCart(data.cartList);
                },
                error: function () {
                    console.log("error");
                }
            });
            return false;
        });
    };

    var restore = function (artworkID,title,index) {
        var user = getCookie('user');
        $.ajax({
            type: 'post',
            async: false,
            url: './phpModule/checkCart.php',
            data: {artworkID:artworkID,para:"switch",user:user},
            success: function () {
                for(var i=binItemNum-1;i>index;i--){
                    var itemBlockUp = document.getElementById("bin").getElementsByClassName("recordBlock")[i-1];
                    var itemBlockDown = document.getElementById("bin").getElementsByClassName("recordBlock")[i];
                    itemBlockUp.getElementsByTagName("img")[0].src = itemBlockDown.getElementsByTagName("img")[0].src;
                    itemBlockUp.getElementsByTagName("a")[0].href = itemBlockDown.getElementsByTagName("a")[0].href;
                    itemBlockUp.getElementsByClassName("name")[0].innerHTML = itemBlockDown.getElementsByClassName("name")[0].innerHTML;
                    itemBlockUp.getElementsByTagName("button")[0].value = itemBlockDown.getElementsByTagName("button")[0].value;
                }
                binItemNum--;
                var itemBlock = document.getElementById("bin").getElementsByClassName("recordBlock")[binItemNum];
                itemBlock.getElementsByTagName("img")[0].src = "";
                itemBlock.getElementsByTagName("a")[0].href = "";
                itemBlock.getElementsByClassName("name")[0].innerHTML = "";
                itemBlock.getElementsByTagName("button")[0].value = "";
                itemBlock.style.display = "none";
            },
            error: function () {
                console.log("error");
            }
        });
    };

    var loadCart = function (workList) {
        var container = $("#shoppingCart .recordContainer");
        var totalPrice = 0;
        container.empty();
        for(var i=0;i<workList.length;i++){
            var item = workList[i];
            container.append('<li><a href="ArtDemo.php?workID='+item['artworkID']+'"><div class="recordBlock">' +
                '<img src="./images/img/'+item['artworkID']+'.jpg">' +
                '<table class="detail"><tr>' +
                '<td class="workName"><span>'+item['title']+'</span></td>' +
                '<td class="workIntro"><span>'+item['description']+'</span></td>' +
                '<td class="price"><span>$'+item['price']+'</span></td>' +
                '<td class="deleteBtn"><span><button type="button" class="delete" value="'+item['artworkID']+'" name="'+item['title']+'">Delete</button></span></td>' +
                '</tr></table>' +
                '</div></a></li>');
            totalPrice += parseInt(item['price']);
        }
        $("#pay span").text(totalPrice);
        $("button.delete").click(function () {
            var artworkID = this.value;
            var title = this.name;
            $.ajax({
                type: 'post',
                async: false,
                url: './phpModule/checkCart.php',
                data: {artworkID:artworkID,para:"switch",user:user},
                success: function () {
                    delectTemp(artworkID,title);
                },
                error: function () {
                    console.log("error");
                }
            });
            $.ajax({
                type: 'post',
                async: false,
                url: './phpModule/cartList.php',
                data: {user:user},
                success: function (data) {
                    data = JSON.parse(data);
                    loadCart(data.cartList);
                },
                error: function () {
                    console.log("error");
                }
            });
            return false;
        });
    };

    var checkPay = function () {
        var user = getCookie('user');
        var idList = document.getElementById("shoppingCart").getElementsByClassName("delete");
        var priceList = document.getElementById("shoppingCart").getElementsByClassName("price");
        var list = [];
        var nowTime = new Date().Format("yyyy-MM-dd HH:mm:ss");
        for(var i=0;i<idList.length;++i){
            var id = idList[i].value;
            var price = parseInt(priceList[i].getElementsByTagName("span")[0].innerHTML.replace("$",""));
            list[i] = {'artworkID':id,'price':price};
        }
        $.ajax({
            type: 'post',
            async: false,
            url: './phpModule/checkPay.php',
            data: {user:user,cartList:JSON.stringify(list),time:nowTime},
            success: function (data) {
                data = JSON.parse(data);
                var container = $("#failContainer");
                container.empty();
                if(data.flag==="fail"){
                    var deleteList = data.deleteList;
                    var soldList = data.soldList;
                    var changeList = data.changeList;
                    var failStr = '';
                    if(deleteList.length){
                        failStr += '<p class="failTitle">'+deleteList.length+' artworks deleted :</p>';
                        for(var i=0;i<deleteList.length&&i<2;++i){
                            var index = deleteList[i]['position'];
                            var title = document.getElementById("shoppingCart").getElementsByClassName("workName")[index].getElementsByTagName("span")[0].innerHTML;
                            failStr += '<p class="failItem">'+title+'</p>';
                        }
                        if(deleteList.length>3){
                            failStr += '<p class="failItem">......</p>';
                        }
                        else if(deleteList.length===3) {
                            var index = deleteList[2]['position'];
                            var title = document.getElementById("shoppingCart").getElementsByClassName("workName")[index].getElementsByTagName("span")[0].innerHTML;
                            failStr += '<p class="failItem">'+title+'</p>';
                        }
                    }
                    if(soldList.length){
                        failStr += '<p class="failTitle">'+soldList.length+' artworks sold :</p>';
                        for(var i=0;i<soldList.length&&i<2;++i){
                            var index = soldList[i]['position'];
                            var title = document.getElementById("shoppingCart").getElementsByClassName("workName")[index].getElementsByTagName("span")[0].innerHTML;
                            failStr += '<p class="failItem">'+title+'</p>';
                        }
                        if(soldList.length>3){
                            failStr += '<p class="failItem">......</p>';
                        }
                        else if(deleteList.length===3) {
                            var index = soldList[2]['position'];
                            var title = document.getElementById("shoppingCart").getElementsByClassName("workName")[index].getElementsByTagName("span")[0].innerHTML;
                            failStr += '<p class="failItem">'+title+'</p>';
                        }
                    }
                    if(changeList.length){
                        failStr += '<p class="failTitle">'+changeList.length+' price changed :</p>';
                        for(var i=0;i<changeList.length&&i<2;++i){
                            var index = changeList[i]['position'];
                            var title = document.getElementById("shoppingCart").getElementsByClassName("workName")[index].getElementsByTagName("span")[0].innerHTML;
                            failStr += '<p class="failItem">'+title+'</p>';
                        }
                        if(changeList.length>3){
                            failStr += '<p class="failItem">......</p>';
                        }
                        else if(deleteList.length===3) {
                            var index = changeList[2]['position'];
                            var title = document.getElementById("shoppingCart").getElementsByClassName("workName")[index].getElementsByTagName("span")[0].innerHTML;
                            failStr += '<p class="failItem">'+title+'</p>';
                        }
                    }
                    container.append(failStr);
                    document.getElementById("failPay").style.visibility = "unset";
                }
                else if(data.flag==="money"){
                    var alertBody = document.getElementById("alert");
                    alertBody.getElementsByClassName("alertText")[0].innerHTML = "Insufficient Balance";
                    alertBody.style.visibility = "visible";
                    alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
                }
                else if(data.flag==="success"){
                    var alertBody = document.getElementById("alert");
                    alertBody.getElementsByClassName("alertText")[0].innerHTML = "Success!";
                    alertBody.style.visibility = "visible";
                    alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
                    $(".ok").on("click",function () {
                        location.href = "./MyAccount.php";
                    });
                }

            },
            error: function () {
                console.log("error");
            }
        })
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
            },
            error: function () {
                console.log("error");
            }
        });
        $.ajax({
            type: 'post',
            async: false,
            url: './phpModule/cartList.php',
            data: {user:user},
            success: function (data) {
                data = JSON.parse(data);
                loadCart(data.cartList);
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

    $("#pay button").click(function () {
        checkPay();
    });

    Date.prototype.Format = function (fmt) {
        var o = {
            "M+": this.getMonth() + 1,
            "d+": this.getDate(),
            "H+": this.getHours(),
            "m+": this.getMinutes(),
            "s+": this.getSeconds(),
            "q+": Math.floor((this.getMonth() + 3) / 3),
            "S": this.getMilliseconds()
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length === 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    };

    $("#failPay .payFailBtn").click(function () {
        document.getElementById("failPay").style.visibility = "hidden";
    });

});