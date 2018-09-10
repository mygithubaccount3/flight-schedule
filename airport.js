$(document).ready(function(){
    $("input").keyup(function(){
        var txt = $("input").val();
        $.post("search.php", {suggest: txt}, function(result){
            $("table").html(result);
        });
    });
});

$( document ).ajaxComplete(function() {
    setupdt();
});
            
function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
function getTime() {
    var d = new Date();
    var hours = addZero(d.getHours());
    var minutes = addZero(d.getMinutes());
    var seconds = addZero(d.getSeconds());
    document.getElementById("time").innerHTML = hours+":"+minutes+":"+seconds;
}
function setDelay(i, diff) {
    setTimeout(function(){
                   tbl.rows[i].className = "green";
                   tbl.rows[i].cells[5].innerHTML = "Take off";
               }, diff - 30000);
}
function getRandomIntInclusive(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min; //The maximum is inclusive and the minimum is inclusive 
}
function setupdt() {
    var tbl = document.getElementById("tbl");
    var n = tbl.rows.length;
    var i, s = null, tr, td;
    time = new Date();
    hours = addZero(time.getHours());
    minutes = addZero(time.getMinutes());
    hrmn = hours + ":" + minutes;
    now = new Date("1/1/1900 " + hrmn);

    for (i = 1; i < n; i++) {
        switch (tbl.rows[i].cells[5].innerHTML) {
            case "Delay":
                tbl.rows[i].className = "yellow";
                var row = tbl.insertRow(n);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                if(new Date("1/1/1900 " + tbl.rows[i].cells[1].innerHTML).getHours() <= "22") {
                var rhours = getRandomIntInclusive(new Date("1/1/1900 " + tbl.rows[i].cells[1].innerHTML).getHours() + 1, 23);
                var rminutes = getRandomIntInclusive(0, 59);
                }
                else {
                    var rhours = new Date("1/1/1900 " + tbl.rows[i].cells[1].innerHTML).getHours();
                    var rminutes = getRandomIntInclusive(new Date("1/1/1900 " + tbl.rows[i].cells[1].innerHTML).getMinutes() + 1, 59);
                }
                cell1.innerHTML = tbl.rows[i].cells[0].innerHTML;
                cell2.innerHTML = addZero(rhours) + ":" + addZero(rminutes) + ":" + "00";
                cell3.innerHTML = tbl.rows[i].cells[2].innerHTML;
                cell4.innerHTML = tbl.rows[i].cells[3].innerHTML;
                cell5.innerHTML = tbl.rows[i].cells[4].innerHTML;
                cell6.innerHTML = "Scheduled (changed)";
                break;
            case "Canceled":
                tbl.rows[i].className = "red";
        }
        if(tbl.rows[i].cells[5].innerHTML != "Canceled" && tbl.rows[i].cells[5].innerHTML != "Delay") {
        eltime = new Date("1/1/1900 " + tbl.rows[i].cells[1].innerHTML);
        diff = eltime - now;            
        if (diff > 0) setDelay(i, diff);
        else {
            tbl.rows[i].className = "green";
            tbl.rows[i].cells[5].innerHTML = "Take off";
        }
    }                   
}
}
