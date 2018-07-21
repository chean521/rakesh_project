var wins_2 = null;

function CustomerSelectShow(pid){
    if(wins_2 === null)
        wins_2 = window.open("CustSelectPop.php?pid="+pid,"_blank", "width=900,height=540,scrollbars=1,left=300,top=50");
    else
        wins_2.focus();
}

function GetCustomerId(CustId, Pid){
    wins_2 = null;
    var compiled = Pid + '_' + CustId;
    
    document.getElementById("CustomerID").value = CustId;
    GetCustomerDetailList(Pid, compiled);
}