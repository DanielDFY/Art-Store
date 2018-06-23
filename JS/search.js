function showList() {
    var visi = document.getElementById("searchHome").getElementsByClassName("typeList")[0].style.display;
    if(visi){
        closeList();
    } else {
        document.getElementById("searchHome").getElementsByClassName("typeList")[0].style.display = "block";
    }
}

function closeList() {
    document.getElementById("searchHome").getElementsByClassName("typeList")[0].style.display = "";
}

function changeType(obj){
    document.getElementById("searchHome").getElementsByClassName("default")[0].innerHTML = obj.innerHTML;
    if(obj.innerHTML !== "All") document.getElementById("searchHome").getElementsByClassName("keyWords")[0].setAttribute("placeholder","Find what you want !");
    else document.getElementById("searchHome").getElementsByClassName("keyWords")[0].setAttribute("placeholder","Format: name,artist,description");
    closeList();
}

function changePage(obj) {
    var i;
    var pageList = document.getElementById("paging").getElementsByClassName("pageNum");
    for(i=0;i<pageList.length;++i){
        pageList[i].style.color = "dodgerblue";
        pageList[i].style.backgroundColor = "white";
        pageList[i].className = "pageNum";
    }
    obj.style.color = "white";
    obj.style.backgroundColor = "dodgerblue";
    obj.className = "pageNum pageChosen";
}

$(document).ready(function () {
    if(getCookie("user"))
        signed();
    var totalNum;
    var totalPages;
    var resultList = [];
    var searchFun = function () {
        var key = $("#searchInput").val();
        var keyType = $("#keyType").text();
        switch (keyType) {
           case "Work Name": keyType = "title"; break;
           case "Artist": keyType = "artist"; break;
           case "Intro": keyType = "description"; break;
           default: keyType = ""; break;
        }
        var sortBy = $('#sortType input[name="sortBy"]:checked ').val();
        var currentPage = parseInt($(".pageChosen").text());
        var obj = new FormData();
        obj.append("key",key);
        obj.append("keyType",keyType);
        obj.append("sortBy",sortBy);
        obj.append("currentPage",currentPage);
        $.ajax({
            url: './phpModule/doSearch.php',
            type: 'post',
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            data:obj
        })
            .done(function (data) {
                data = JSON.parse(data);
                totalNum = data.totalNum;
                resultList = data.result;
                var base = document.getElementById("searchHome").getElementsByClassName("resultBlock");
                for(var i=0;i<6;++i){
                    base[i].style.display = 'none';
                }
                for(i=0;i<resultList.length;i++){
                    base[i].style.display = 'block';
                   base[i].getElementsByClassName("image")[0].src = "./images/img/"+resultList[i].imageFileName;
                   base[i].getElementsByClassName("name")[0].innerHTML = resultList[i].title;
                   base[i].getElementsByClassName("artist")[0].innerHTML = resultList[i].artist;
                   base[i].getElementsByClassName("viewed")[0].innerHTML = resultList[i].view;
                   base[i].getElementsByClassName("price")[0].innerHTML = "$ "+resultList[i].price;
                   base[i].getElementsByClassName("description")[0].innerHTML = resultList[i].description;
                   if(base[i].getElementsByClassName("description")[0].innerHTML.length>100){
                       base[i].getElementsByClassName("description")[0].innerHTML=base[i].getElementsByClassName("description")[0].innerHTML.substring(0,100)+"...";
                   }
                   document.getElementsByClassName("item")[i].href = "ArtDemo.php?workID="+resultList[i].artworkID;
               }
                if(totalNum%6)
                    totalPages = parseInt(totalNum/6) + 1;
                else
                    totalPages = parseInt(totalNum/6);
                $("#paging").empty();
                if(totalPages<8){
                    if(totalPages===1||totalPages===0){
                        var btn = '<button class="pageNum" onclick="changePage(this)">1</button>';
                        $("#paging").append(btn);
                        $(".pageNum").css("border-radius","4px");
                    }
                    else{
                        for(var i=1;i<totalPages;i++){
                            var btn = '<button class="pageNum" onclick="changePage(this)">'+i+'</button>';
                            $("#paging").append(btn);
                        }
                    }
                }
                else{
                    for(var i=1;i<8;i++){
                        var btn = '<button class="pageNum" onclick="changePage(this)">'+i+'</button>';
                        $("#paging").append(btn);
                    }

                    if(currentPage>4){
                        document.getElementsByClassName("pageNum")[1].innerHTML = "...";
                        document.getElementsByClassName("pageNum")[1].disabled = true;
                    }
                    if(currentPage<totalPages-3){
                        document.getElementsByClassName("pageNum")[5].innerHTML = "...";
                        document.getElementsByClassName("pageNum")[5].disabled = true;
                    }
                    if(currentPage>4&&currentPage<totalPages-3){
                        changePage(document.getElementsByClassName("pageNum")[3]);
                        document.getElementsByClassName("pageNum")[2].innerHTML = currentPage-1;
                        document.getElementsByClassName("pageNum")[3].innerHTML = currentPage;
                        document.getElementsByClassName("pageNum")[4].innerHTML = currentPage+1;
                        changePage(document.getElementsByClassName("pageNum")[3]);
                    }
                    else if(currentPage<=4)
                        changePage(document.getElementsByClassName("pageNum")[currentPage-1]);
                    else{
                        changePage(document.getElementsByClassName("pageNum")[6+currentPage-totalPages]);
                        for(var i=2;i<7;i++){
                            document.getElementsByClassName("pageNum")[i].innerHTML = totalPages-6+i;
                        }
                    }
                    document.getElementsByClassName("pageNum")[6].innerHTML = totalPages;
                }

                $(".pageNum").click(function () {
                    searchFun();
                });
           })
           .fail(function (jqXHR, textStatus, errorThrown) {
               console.log(errorThrown);
           });
    };
    $(".searchBtn").click(function () {
        searchFun();
        $(".pageNum")[0].className +=" pageChosen";
    });
    $("input[type='radio']").click(function () {
        searchFun();
        $(".pageNum")[0].className +=" pageChosen";
    });
    searchFun();
});