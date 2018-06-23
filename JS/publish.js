$(document).ready(function () {
    if(!getCookie('user')){
        var alertBody = document.getElementById("alert");
        alertBody.getElementsByClassName("alertText")[0].innerHTML = "Please sign in first!";
        alertBody.style.visibility = "visible";
        alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
        $(".ok").on("click",function () {
            location.href = "./Index.php";
        });
    }
    else {

        $("#uploadFile").on("change", function () {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return;
            var objUrl = getObjectURL(this.files[0]);
            $("#showImg").attr("src", objUrl);
        });

        var getObjectURL = function (file) {
            var url = null;
            if (window.createObjectURL != undefined) {
                url = window.createObjectURL(file);
            } else if (window.URL != undefined) {
                url = window.URL.createObjectURL(file);
            } else if (window.webkitURL != undefined) {
                url = window.webkitURL.createObjectURL(file);
            }
            return url;
        };

        var checkEmpty = function () {
            var flag = true;
            var list = document.getElementsByClassName("detailInput");
            for (var i = 0; i < list.length; i++) {
                if (!list[i].value) {
                    flag = false;
                    break;
                }
            }
            if (flag)
                return true;
            else {
                $("#emptyWarning").css("visibility", "visible");
                return false;
            }
        };

        var checkDate = function () {
            var value = $(".date:eq(0)").val();
            var patrn = /^[0-9]+$/;
            if (patrn.exec(value))
                return true;
            else {
                $(".warning:eq(0)").css("visibility", "visible");
                return false;
            }
        };

        var checkDimension = function () {
            var list = document.getElementsByClassName("dimension");
            var patrn = /^(([0-9]+\\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\\.[0-9]+)|([0-9]*[1-9][0-9]*))$/;
            var flag = true;
            for (var i = 0; i < 2; ++i)
                if (!patrn.exec(list[i].value))
                    flag = false;
            if (flag)
                return true;
            else {
                $(".warning:eq(1)").css("visibility", "visible");
                return false;
            }
        };

        var checkPrice = function () {
            var value = $(".price:eq(0)").val();
            var patrn = /^[0-9]*[1-9][0-9]*$/;
            if (patrn.exec(value))
                return true;
            else {
                $(".warning:eq(2)").css("visibility", "visible");
                return false;
            }
        };

        var checkAll = function () {
            var list = document.getElementsByClassName("warning");
            for (var i = 0; i < list.length; ++i) {
                list[i].style.visibility = "hidden";
            }
            document.getElementById("emptyWarning").style.visibility = "hidden";
            return checkEmpty() && checkDate() && checkDimension() && checkPrice();
        };

        Date.prototype.Format = function (fmt) {
            var o = {
                "M+": this.getMonth() + 1, //月份
                "d+": this.getDate(), //日
                "H+": this.getHours(), //小时
                "m+": this.getMinutes(), //分
                "s+": this.getSeconds(), //秒
                "q+": Math.floor((this.getMonth() + 3) / 3), //季度
                "S": this.getMilliseconds() //毫秒
            };
            if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
            for (var k in o)
                if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length === 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
            return fmt;
        };

        $("#publishBtn").on("click", function () {
            if (checkAll()) {
                var formData = new FormData(document.getElementById("publishForm"));
                formData.append("owner", getCookie("user"));
                var nowTime = new Date().Format("yyyy-MM-dd HH:mm:ss");
                formData.append("time", nowTime);
                $.ajax({
                    type: 'post',
                    async: false,
                    url: './phpModule/publish.php',
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        var alertBody = document.getElementById("alert");
                        alertBody.getElementsByClassName("alertText")[0].innerHTML = "Success!";
                        alertBody.style.visibility = "visible";
                        alertBody.getElementsByClassName("ok")[0].style.visibility = "visible";
                        $(".ok").on("click", function () {
                            location.href = "./MyAccount.php";
                        });
                    },
                    error: function () {
                        console.log("error");
                    }
                });
            }
        });
    }
});