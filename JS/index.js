function changeImg(pictureNum) {
    switch(pictureNum){
        case 1:
            document.getElementById("carousel").style.marginLeft="0";
            break;
        case 2:
            document.getElementById("carousel").style.marginLeft="-100%";
            break;
        case 3:
            document.getElementById("carousel").style.marginLeft="-200%";
            break;
        case 4:
            document.getElementById("carousel").style.marginLeft="-300%";
            break;
        default:
            break;
    }
    document.getElementById("demoUrl").href = "ArtDemo.php?workID="+gWorks[pictureNum-1];
    scrollChange();
}

var nowNum;

function changeImgAuto() {
    if (nowNum === 5) {
        nowNum = 1;
    }
    changeImg(nowNum);
    ++nowNum;
    setTimeout("changeImgAuto()",4000);
}

function changeImgPlus() {
    ++nowNum;
    if (nowNum > 4) {
        nowNum = 1;
    }
    changeImg(nowNum);
}

function changeImgMinus() {
    --nowNum;
    if (nowNum === 0) {
        nowNum = 4;
    }
    changeImg(nowNum);
}

function scrollChange(){
    switch(nowNum){
        case 1:
            document.getElementById("firstDot").className = "fa fa-check-circle-o";
            document.getElementById("secondDot").className = "fa fa-circle";
            document.getElementById("thirdDot").className = "fa fa-circle";
            document.getElementById("forthDot").className = "fa fa-circle";
            break;
        case 2:
            document.getElementById("firstDot").className = "fa fa-circle";
            document.getElementById("secondDot").className = "fa fa-check-circle-o";
            document.getElementById("thirdDot").className = "fa fa-circle";
            document.getElementById("forthDot").className = "fa fa-circle";
            break;
        case 3:
            document.getElementById("firstDot").className = "fa fa-circle";
            document.getElementById("secondDot").className = "fa fa-circle";
            document.getElementById("thirdDot").className = "fa fa-check-circle-o";
            document.getElementById("forthDot").className = "fa fa-circle";
            break;
        case 4:
            document.getElementById("firstDot").className = "fa fa-circle";
            document.getElementById("secondDot").className = "fa fa-circle";
            document.getElementById("thirdDot").className = "fa fa-circle";
            document.getElementById("forthDot").className = "fa fa-check-circle-o";
            break;
    }
}

function changeByDot(dot) {
    nowNum = dot;
    changeImg(nowNum);
}

window.onload = function(){
    var nowNum = 1;
    changeImgAuto();
    changeByDot(1);
    if(getCookie("user"))
        signed();
};

