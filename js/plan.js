function cleartext() {
    document.getElementById("t1").value = "";
    document.getElementById("qt1").value = "";
    document.getElementById("qt2").value = "";
    document.getElementById("qt3").value = "";
    document.getElementById("qt4").value = "";
    document.getElementById("qt5").value = "";
}

function rfun1() {
    t = prompt("請輸入欲列印行程");
    if (t != "") {
        location.href = "basicidreport1.php?tid=" + t;
    } else {
        alert('發生錯誤! 請輸入行程編號');
        location.href = './basicdb.php';
    }
}
function rfun2() {
    t = prompt("請輸入欲列印出發點");
    if (t != "") {
        location.href = "basicnamereport1.php?tname=" + t;
    } else {
        alert('發生錯誤! 請輸入出發點');
        location.href = './basicdb.php';
    }
}
function rfun3() {
    t = prompt("請輸入欲列印目的地");
    if (t != "") {
        location.href = "basicendreport1.php?tend=" + t;
    } else {
        alert('發生錯誤! 請輸入目的地');
        location.href = './basicdb.php';
    }
}
function rfun4() {
    t = prompt("請輸入欲列印天數");
    if (t != "") {
        location.href = "basicdayreport1.php?tday=" + t;
    } else {
        alert('發生錯誤! 請輸入預計天數');
        location.href = './basicdb.php';
    }
}
function rfun5() {
    t = prompt("請輸入欲列印起始行程編號");
    t1 = prompt("請輸入欲列印結束行程編號");
    if (t != "" || t1 != "") {
        location.href = "basicrangereport1.php?tstart=" + t + "&tend=" + t1;
    } else {
        alert('發生錯誤! 請輸入行程編號');
        location.href = './basicdb.php';
    }
}