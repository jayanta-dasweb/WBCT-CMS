/************** search cust data **********/
function searchCustData(){
    var stbNo = $('#floatingInputGridForSTBNO').val();
    var sessionId = $('#sessionId').val();
    if(stbNo == ''){
        $('#pkgSelectSection').hide();
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter STB Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else{
        $.ajax({
            type: "POST",
            url: "js/db/rechargeBackend.php",
            data: {
                stbNo : stbNo,
                sessionId :sessionId
            },
            success: function (response) {
                // alert(response);
                $('#hiddenId').val(response);
                getCustPkgData(response);
            }
        });
    }
}

/**************** onkeyup capitel all letters **********/
function capitalizeText(){
    var stbNoText = $('#floatingInputGridForSTBNO').val();
    $('#floatingInputGridForSTBNO').val(stbNoText.toUpperCase());
    if(stbNoText == ''){
        $('#pkgSelectSection').hide();
        $('#hiddenId').val(0);
    }
}

/**************get all pkgs ********/
function getCustPkgData(custId){
    $.ajax({
        type: "POST",
        url: "js/db/rechargeBackend.php",
        data: {
            custId : custId
        },
        success: function (response) {
            // alert(response);
         $('#allPkgs').html(response); 
         $('#pkgSelectSection').show();  
        }
    });
}

function finalSubmitData(){
    var custIdForFinalSubmit = $('#hiddenId').val();
    var pkgId = $('input[name="flexRadioDefault"]:checked').val();
    if(pkgId == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Package..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else {
        $.ajax({
            type: "POST",
            url: "js/db/rechargeBackend.php",
            data: {
                custIdForFinalSubmit: custIdForFinalSubmit,
                pkgId : pkgId  
            },
            success: function (response) {
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Inserted Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function (success) {
                        if (success) {
                            $('#pkgSelectSection').hide();
                            $('#hiddenId').val(0);
                            $('#floatingInputGridForSTBNO').val('');
                        }
                    });
                }
            }
        });
    }
}