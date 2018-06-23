function addFavChange(obj) {
    if(obj.className === "noAdded") {
        obj.innerHTML ="<i class=\"fa fa-star\" ></i>&nbsp;Added";
        obj.style.color = "dodgerblue";
        obj.style.backgroundColor = "white";
        obj.className = "Added";
    } else {
        obj.innerHTML ="<i class=\"fa fa-star\" ></i>&nbsp;Add to my favorites";
        obj.style.color = "white";
        obj.style.backgroundColor = "dodgerblue";
        obj.className = "noAdded";
    }
}

$(document).ready(function () {
    var checkCart = function (artworkID,para) {
        var obj = document.getElementsByName("shoppingCartButton")[0];
        var user = getCookie('user');
        $.ajax({
            type: 'post',
            async: false,
            url: './phpModule/checkCart.php',
            data: {artworkID:artworkID,para:para,user:user},
            success: function (data) {
                if(data==="added"){
                    obj.innerHTML ="<i class=\"fa fa-shopping-cart\" ></i>&nbsp;Added";
                    obj.style.color = "dodgerblue";
                    obj.style.backgroundColor = "white";
                    obj.className = "Added";
                }
                else if(data==="removed"){
                    obj.innerHTML ="<i class=\"fa fa-shopping-cart\" ></i>&nbsp;Add to shopping cart";
                    obj.style.color = "white";
                    obj.style.backgroundColor = "dodgerblue";
                    obj.className = "noAdded";
                }
            },
            error: function () {
                console.log("error");
            }
        });
    };

    var button = $("button[name='shoppingCartButton']");

    if(!getCookie('user')){
        button.text("Sign in");
        button.click(function () {
            signOrRegister();
        });
    }else{
        signed();
        $.ajax({
            type: 'post',
            async: false,
            url: './phpModule/checkSold.php',
            data: {artworkID:artworkID,user:getCookie('user')},
            success: function (data) {
                if(data==="sold"){
                    button.text("Sold");
                    button.attr("disabled","disabled");
                }
                else if(data==="owner"){
                    button.html('<i class="fa fa-edit"></i> Edit');
                    button.click(function () {
                        location.href = location.href = "workUpdate.php?artworkID=" + artworkID + ".jpg";
                    });
                }
                else if(data==="unsold"){
                    checkCart(artworkID,"check");
                    button.click(function () {
                        checkCart(artworkID,"switch");
                    });
                }
            },
            error: function () {
                console.log("error");
            }
        });
    }
});