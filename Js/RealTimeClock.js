var clock_container = "clock";

function StartClock(){
    var today = new Date();
    var year = today.getFullYear();
    var mon = today.getMonth() + 1;
    var day = today.getDate();
    
    var hrs = CheckTime(today.getHours());
    var min = CheckTime(today.getMinutes());
    var sec = CheckTime(today.getSeconds());
    
    document.getElementById(clock_container).innerHTML = year + '-' + mon + '-' + day + '&nbsp;' + hrs + ':' + min + ':' + sec;
    
    var times = setTimeout(StartClock, 500);
}

function CheckTime(t){
    if(t<10) t = '0' + t;
    return t;
}
