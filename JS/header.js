function signOrRegister() {
    document.getElementById("sign").style.display = "inline";
}

function signOrRegisterCancel() {
    var checkList = document.getElementsByClassName("check");
    for(var i=0;i<checkList.length;i++){
        checkList[i].style.display = "none";
    }
    document.getElementsByClassName("signIn")[0].reset();
    document.getElementsByClassName("register")[0].reset();
    document.getElementById("sign").style.display = "none";
    switchSelect(1);
}

function signed(){
    signOrRegisterCancel();
    document.getElementById("Usrn").innerHTML = getCookie("user");
    document.getElementById("sign").style.display = "none";
    document.getElementsByClassName("signed")[0].style.display = "inline";
    document.getElementsByClassName("unsigned")[0].style.display = "none";
}

function signIn() {
    if(checkSign()){
        var alertBody = document.getElementById("alert");
        alertBody.getElementsByClassName("alertText")[0].innerHTML = "Welcome, "+getCookie('user')+"!";
        alertBody.style.visibility = "visible";
        alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
        $(".ok").on("click",function () {
            var tmp=location.href;
            location.href =tmp;
        });
    } else {
        var alertBody = document.getElementById("alert");
        alertBody.getElementsByClassName("alertText")[0].innerHTML = "Fail to sign in";
        alertBody.style.visibility = "visible";
        alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
    }
}

function checkSignEmpty() {
    var checkList = document.getElementsByClassName("signName")[0].getElementsByClassName("check");
    var username = document.getElementsByName("signUsrn")[0].value;
    var password = document.getElementsByName("signPass")[0].value;

    for(var i=0;i<checkList.length;i++){
        checkList[i].style.display = "none";
    }

    if (username.length === 0) {
        document.getElementById("signIn").getElementsByClassName("empty")[0].style.display = "inline";
        return false;
    }
    if (password.length === 0 ) {
        document.getElementById("signIn").getElementsByClassName("empty")[1].style.display = "inline";
        return false;
    }
    return true;
}

function checkSign() {
    var flag = false;
    if(checkSignEmpty()){
        var formData = new FormData(document.getElementsByClassName("signIn")[0]);
        $.ajax({
            type: 'post',
            async: false,
            url: './phpModule/sign.php',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if(data === "unregistered name"){
                    document.getElementById("signIn").getElementsByClassName("exist")[0].style.display = "inline";
                }
                else if(data === "wrong password"){
                    document.getElementById("signIn").getElementsByClassName("correct")[0].style.display = "inline";
                }
                else if(data === "success"){
                    console.log("success");
                    var usrn = document.getElementById("signUsrn").value;
                    document.cookie = "user=" + usrn + ";expires=1;path=/";
                    flag = true;
                }

            },
            error: function () {
                console.log("error");
            }
        });
    }
    return flag;
}

function register(){
    if(checkRegister()){
        var alertBody = document.getElementById("alert");
        alertBody.getElementsByClassName("alertText")[0].innerHTML = "Welcome, "+getCookie('user')+"!";
        alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
        alertBody.style.visibility = "visible";
        $(".ok").on("click",function () {
            var tmp=location.href;
            location.href =tmp;
        });
    }
}

function checkRegister() {
    var flag = false;
    if(checkRegisterFormat()){
        var formData = new FormData(document.getElementsByClassName("register")[0]);
        $.ajax({
            type: 'post',
            async: false,
            url: './phpModule/register.php',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if(data === "registered name"){
                    var alertBody = document.getElementById("alert");
                    alertBody.getElementsByClassName("alertText")[0].innerHTML = "Sorry, the name has been used.";
                    alertBody.style.visibility = "visible";
                    alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
                    signed();
                }else if (data === "success"){
                    var usrn = document.getElementById("registerUsrn").value;
                    document.cookie = "user=" + usrn + ";expires=1;path=/";
                    console.log("success");
                    flag = true;
                }
            },
            error: function () {
                console.log("error");
            }
        });
    }
    return flag;
}

function confirmSignOut() {
    var alertBody = document.getElementById("alert");
    alertBody.getElementsByClassName("alertText")[0].innerHTML = "Do you want to sign out?";
    alertBody.getElementsByClassName("cancel")[0].style.visibility = "visible";
    alertBody.getElementsByClassName("confirm")[0].style.visibility = "visible";
    alertBody.getElementsByClassName("ok")[0].style.visibility = "hidden";
    alertBody.getElementsByClassName("confirm")[0].onclick = function (){signOut();};
    alertBody.style.visibility = "visible";
}

function signOut() {
    var alertBody = document.getElementById("alert");
    for(var i=1;i<3;i++)
        alertBody.getElementsByClassName("alertBtn")[i].style.visibility = "hidden";
    $.ajax({
        type: 'post',
        async: false,
        url: './phpModule/signOut.php',
        data: {signOut:"signOut"},
        success: function (data) {
            console.log(data);
            if(data==="Sign out!"){
                delCookie("user");
                document.getElementsByClassName("signed")[0].style.display = "none";
                document.getElementsByClassName("unsigned")[0].style.display = "inline";
                switchSelect(1);
                alertBody.getElementsByClassName("alertText")[0].innerHTML = "You have signed out!";
                alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
                alertBody.style.visibility = "visible";
                $(".ok").on("click",function () {
                    var tmp=location.href;
                    location.href =tmp;
                });
            }
        },
        error: function () {
            console.log("error");
        }
    });
}

function switchSelect(num) {
    if(num){
        document.getElementById("switcher_1").className = "selected";
        document.getElementById("signIn").style.display = "block";
        document.getElementById("switcher_2").className = "unselected";
        document.getElementById("register").style.display = "none";
    }
    else{
        document.getElementById("switcher_1").className = "unselected";
        document.getElementById("signIn").style.display = "none";
        document.getElementById("switcher_2").className = "selected";
        document.getElementById("register").style.display = "block";
    }
}


function checkRegisterUsrn() {
    var check = false;
    var nameList = /[^0-9a-zA-Z]/g;
    var letterList =  /[a-zA-Z]/g;
    var numList = /[0-9]/g;
    var i;
    var checkList = document.getElementsByClassName("registerName")[0].getElementsByClassName("check");
    var username = document.getElementsByName("registerUsrn")[0].value;

    for(i=0;i<checkList.length;i++){
        checkList[i].style.display = "none";
    }

    if (username.length === 0 ) {
        document.getElementById("register").getElementsByClassName("empty")[0].style.display = "inline";
        check = false;
    } else if (username.length < 6) {
        document.getElementById("register").getElementsByClassName("length")[0].style.display = "inline";
        check = false;
    } else if(!((!nameList.test(username))&&numList.test(username)&&letterList.test(username))){
        document.getElementById("register").getElementsByClassName("content")[0].style.display = "inline";
        check = false;
    } else {
        check = true;
    }
    return check;
}

function checkRegisterPass() {
    var check = false;
    var i;
    var checkList = document.getElementsByClassName("registerPass")[0].getElementsByClassName("check");
    var password = document.getElementsByName("registerPass")[0].value;
    var username = document.getElementsByName("registerUsrn")[0].value;

    for(i=0;i<checkList.length;i++){
        checkList[i].style.display = "none";
    }

    if (password.length === 0 ) {
        document.getElementById("register").getElementsByClassName("empty")[1].style.display = "inline";
        check = false;
    } else if (username.length < 6) {
        document.getElementById("register").getElementsByClassName("length")[1].style.display = "inline";
        check = false;
    } else {
        check = true;
    }
    return check;
}

function checkPassAgain() {
    var check = false;
    var i;
    var checkList = document.getElementsByClassName("registerPassAgain")[0].getElementsByClassName("check");
    var password_1 = document.getElementsByName("registerPass")[0].value;
    var password_2 = document.getElementsByName("registerPassAgain")[0].value;

    for(i=0;i<checkList.length;i++){
        checkList[i].style.display = "none";
    }

    if (password_1 === password_2) {
        check = true;
    } else {
        document.getElementById("register").getElementsByClassName("same")[0].style.display = "inline";
        check = false;
    }
    return check;
}

function checkRegisterEmail() {
    var check = false;
    var emailList = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
    var i;
    var checkList = document.getElementsByClassName("registerEmail")[0].getElementsByClassName("check");
    var email = document.getElementsByName("registerEmail")[0].value;

    for(i=0;i<checkList.length;i++){
        checkList[i].style.display = "none";
    }

    if (email.length === 0 ) {
        document.getElementById("register").getElementsByClassName("empty")[2].style.display = "inline";
        check = false;
    } else if (!emailList.test(email)) {
        document.getElementById("register").getElementsByClassName("email")[0].style.display = "inline";
        check = false;
    } else {
        check = true;
    }
    return check;
}

function checkRegisterTel() {
    var check = false;
    var telList = /^(0|86|17951)?(13[0-9]|15[012356789]|17[0678]|18[0-9]|14[57])[0-9]{8}$/;
    var i;
    var checkList = document.getElementsByClassName("registerTel")[0].getElementsByClassName("check");
    var tel = document.getElementsByName("registerTel")[0].value;

    for(i=0;i<checkList.length;i++){
        checkList[i].style.display = "none";
    }

    if (tel.length === 0 ) {
        document.getElementById("register").getElementsByClassName("empty")[3].style.display = "inline";
        check = false;
    } else if (!telList.test(tel)) {
        document.getElementById("register").getElementsByClassName("tel")[0].style.display = "inline";
        check = false;
    } else {
        check = true;
    }
    return check;
}

function checkRegisterAdr() {
    var check = false;
    var i;
    var checkList = document.getElementsByClassName("registerAdr")[0].getElementsByClassName("check");
    var address = document.getElementsByName("registerAdr")[0].value;

    for(i=0;i<checkList.length;i++){
        checkList[i].style.display = "none";
    }

    if (address.length === 0 ) {
        document.getElementById("register").getElementsByClassName("empty")[4].style.display = "inline";
        check = false;
    } else {
        check = true;
    }
    return check;
}

function checkRegisterFormat() {
    return checkRegisterUsrn()&&checkRegisterPass()&&checkPassAgain()&&checkRegisterEmail()&&checkRegisterTel()&&checkRegisterAdr();
}


function name2link(name){
    var link="#";
    switch(name){
        case "Home Page":
            link = "../Index.php";
            break;
        case "Search":
            link = "Search.php";
            break;
        case "My Account":
            link = "MyAccount.php";
            break;
        case "Shopping Cart":
            link = "ShoppingCart.php";
            break;
        case "Item Detail":
            link = "ArtDemo.php";
            break;
    }
    return link;
}

function getCookie(c_name)
{
    var c_start;
    var c_end;
    if (document.cookie.length>0)
    {
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!==-1)
        {
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end===-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}

function delCookie(c_name){
    var myDate=new Date();
    myDate.setTime(-1000);//设置时间
    document.cookie=c_name+"=''; expires="+myDate.toGMTString() +";path=/";

}

function ok() {
    var alertBody = document.getElementById("alert");
    alertBody.getElementsByClassName("alertText")[0].innerHTML = "";
    alertBody.style.visibility = "hidden";
    for(var i=0;i<3;i++)
        alertBody.getElementsByClassName("alertBtn")[i].style.visibility = "hidden";
}

function searchBtn() {
    var value = document.getElementById("search").getElementsByTagName("input")[0].value;
    document.getElementById("search").getElementsByTagName("a")[0].href = "Search.php?key="+value;
}