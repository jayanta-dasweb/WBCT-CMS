/****** get total no of customer ****/
function getTotalCust(){
    let totalCust = "somthing";
    $.ajax({
    type: "POST",
    url: "js/db/homeBackend.php",
    data: {totalCust : totalCust},
    success: function (response) {
        $('#totalCust').text(response);
    }
});
}

/****** get total active connection *******/
function getTotalActiveConnection(){
    let totalActiveConnection = "somthing";
    $.ajax({
    type: "POST",
    url: "js/db/homeBackend.php",
    data: {totalActiveConnection : totalActiveConnection},
    success: function (response) {
        $('#totalActiveConnection').text(response);
    }
});
}

/****** get total pending compplaints *******/
function getTotalPendingComplaints(){
    let totalPendingComplaints = "somthing";
    $.ajax({
    type: "POST",
    url: "js/db/homeBackend.php",
    data: {totalPendingComplaints : totalPendingComplaints},
    success: function (response) {
        $('#totalPendingComplaints').text(response);
    }
});
}

/****** get total pending connection request *******/
function getTotalPendingConnectionRequest(){
    let totalPendingConnectionRequest = "somthing";
    $.ajax({
    type: "POST",
    url: "js/db/homeBackend.php",
    data: {totalPendingConnectionRequest : totalPendingConnectionRequest},
    success: function (response) {
        $('#totalPendingConnectionRequest').text(response);
    }
});
}