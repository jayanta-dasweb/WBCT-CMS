var imported = document.createElement('script');
imported.src = './globel.js';
document.head.appendChild(imported);

$(document).ready(function () {
    getCustPkgData();
});

/**************get all pkgs ********/
function getCustPkgData() {
    var custId = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/rechargeCustBackend.php",
        data: {
            custId: custId
        },
        success: function (response) {
            // alert(response);
            $('#allPkgs').html(response);
        }
    });
}

function finalSubmitData() {
    var custIdForFinalSubmit = $('#sessionId').val();
    var dummyVarForGateWay = $('#sessionId').val();
    var getPkgIdAndAmt = $('input[name="flexRadioDefault"]:checked').val();
    let array = getPkgIdAndAmt.split('%');
    let pkgId = array[0];
    let totalAmt = array[1];
    if (pkgId == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Package..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/rechargeCustBackend.php",
            data: {
                custIdForFinalSubmit: custIdForFinalSubmit,
                pkgId: pkgId
            },
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    $.ajax({
                        type: "POST",
                        url: "js/db/rechargeCustBackend.php",
                        data: {
                            dummyVarForGateWay: dummyVarForGateWay,
                            totalAmt: totalAmt
                        },
                        success: function (response) {
                            // alert(response);
                            window.location.href = response;
                            hideRechrgNav();
                        }
                    });
                }
            }
        });
    }
}

