$(document).ready(function () {
    getData();
});

/********** get Data ************/
function getData(){
    var dummyVar = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/rechargeHistoryBackend.php",
        data: {
            dummyVar: dummyVar
        },
        success: function (response) {
            $('#cardBodyTable').html(response);
        }
    });
}


/************ Print Invoice ********/
function printInvoice(){
    var divToPrint=document.getElementById('printArea');
    var newWin=window.open('','Print-Window');
    newWin.document.open();
    newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
    newWin.document.close();
    setTimeout(function(){newWin.close();},10);
}


/************ get pay details *******/
function getPayDetFn(getPayDetId){
    // alert("jj");
    $.ajax({
        type: "POST",
        url: "js/db/rechargeHistoryBackend.php",
        data: {
            getPayDetId : getPayDetId
        },
        success: function (response) {
            // alert(response);
            $('#printArea').html(response);
        }
    });
}


/************ all clear data ******/
function closeModl(){
    $('#printArea').html('');
}

/*************** Search data ***********/
function searchData() {
    let serchText = $('#searchText').val();
    let cId = $('#sessionId').val();
    if (serchText == '') {
        getData();
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/rechargeHistoryBackend.php",
            data: {
                serchText: serchText,
                cId : cId
            },
            success: function (response) {
                $('#cardBodyTable').html(response);
            }
        });
    }
}