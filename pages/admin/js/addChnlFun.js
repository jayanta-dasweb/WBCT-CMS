/****************** Get Data ************/
function getData() {
    let dummyVar2 = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/addChnlBackend.php",
        data: {
            dummyVar2: dummyVar2
        },
        success: function (response) {
            $('#cardBodyTable').html(response);
        }
    });
}


/******* get all channel list *******/
function getChnlList() {
    $.getJSON("/wbct-cms/dist/chnl_list.json", function (data) {
        let chnlDetails = '';
        let no = 1;
        $.each(data, function (key, value) {
            let imgUrl = '../../dist/img/chnlLogo/' + value.url;
            let detailsCombine = '%' + value.name + '%' + value.url + '%' + value.amount;
            chnlDetails += '<div id="box-' + no + '" class="d-flex flex-column box" onclick="selectBox(' + no + ')">';
            chnlDetails += '<div class="form-check ml-1 chkbx">';
            chnlDetails += '<input class="form-check-input chnlSelectCheck chkbx-' + no + '" name="chnlDataForAdd" type="checkbox" value="' + detailsCombine + '" id="flexCheckDefault">';
            chnlDetails += '</div>';
            chnlDetails += '<div id="subBox">';
            chnlDetails += '<img src="' + imgUrl + '" alt="' + value.name + '" id="chnlLogo" class="chnlLogo-' + no + '">';
            chnlDetails += '<p><b>&#8377;' + value.amount + '</b></p>';
            chnlDetails += '</div>';
            chnlDetails += '</div>';
            no++;
        });
        $('#mainbox').append(chnlDetails);
    });
}

/************ select chnl box **********/
function selectBox(no) {
    if ($('.chkbx-' + no).prop('checked') == true) {
        $('.chkbx-' + no).css("visibility", "hidden");
        $('.chkbx-' + no).prop('checked', false);
    } else {
        $('.chkbx-' + no).css("visibility", "visible");
        $('.chkbx-' + no).prop('checked', true);
    }

}

/************* get all pkg name *******/
function getPkgData() {
    let dummyVar = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/addChnlBackend.php",
        data: {
            dummyVar: dummyVar
        },
        success: function (response) {
            $('.dataSelectForAssign').html(response);
        }
    });
}

// /************ ADD data *************/
function addData() {
    let pkgId = $('#floatingSelect').val();
    var array = [];
    var checkboxes = document.querySelectorAll('input[name=chnlDataForAdd]:checked');
    for (var i = 0; i < checkboxes.length; i++) {
        array.push(checkboxes[i].value);
    }
    if (pkgId == 0 && array == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All Fields Are Mendetory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (pkgId == 0) {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Package..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (array == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Channels..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/addChnlBackend.php",
            data: {
                pkgId: pkgId,
                arr: array
            },
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Inserted Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function (success) {
                        if (success) {
                            autoPlusAmt();
                            $('.chnlSelectCheck').css("visibility", "hidden");
                            $('.chnlSelectCheck').prop('checked', false);
                            getData();
                            getCustPkgData();
                            getAllSubPkg();
                        }
                    });
                }
            }
        });
    }
}

/************** get channels for modal *********/
function getChnlsForModal(getchnlID) {
    $.ajax({
        type: "POST",
        url: "js/db/addChnlBackend.php",
        data: {
            getchnlID: getchnlID
        },
        success: function (response) {
            // alert(response);
            $('#mainbox1').html(response);
        }
    });
}

/******** On delete btn clik *******/
function deleteData(delId) {
    getChnlForDel(delId);
}


/********** Get all chanl for delete *******/
function getChnlForDel(delIdForGetChnl) {
    $.ajax({
        type: "POST",
        url: "js/db/addChnlBackend.php",
        data: {
            delIdForGetChnl: delIdForGetChnl
        },
        success: function (response) {
            $('.allChnlMenueForDelete').html(response);
        }
    });
}

/************** final delete *************/
function finalDeleteData() {
    var no = $('#hiddenNo').val();
    var chnlNameForD = $('#chnlNameForDel'+no).val();
    var pkgIdForD = $('#pkgIdForDel'+no).val();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "js/db/addChnlBackend.php",
                data: {
                    chnlNameForD : chnlNameForD ,          
                    pkgIdForD : pkgIdForD
                },
                success: function (response) {
                    // alert(response);
                    if (response == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: '<h1 style="color:#009970">Success</h1>',
                            text: 'Data Deleted Successfully...',
                            textColor: 'red',
                            confirmButtonColor: '#009970'
                        }).then(function (success) {
                            if (success) {
                                autoPlusAmt();
                                $('.dataShowAfterSelect').css('visibility','hidden');
                                getData();
                                getCustPkgData();
                                $('#deleteModal').modal('hide');
                                getAllSubPkg();
                            }
                        });
                    }
                }
            });
        } else {
            swal.fire("your data is safe..");
        }
    });
}

/*********** update automattically pkg Amount ******/
function autoPlusAmt(){
    var dummyVar5 = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/addChnlBackend.php",
        data: {
            dummyVar5 : dummyVar5 
        },
        success: function (response) {
            // alert(response);
        }
    });
}

/******** fun on clik li
 */
function clikThis(fnNo){
    $('#hiddenNo').val(fnNo);
    $('.dataShowAfterSelect').css('visibility','visible');
    var chnlNameHidden = $('#chnlNameForDel'+fnNo).val();
    var pkgIdForDel = $('#pkgIdForDel'+fnNo).val();
    var logo = $('#logoPath'+fnNo).val();
    var logoPath = '/wbct-cms/dist/img/chnlLogo/'+logo;
    var chnlAmt = $('#chnlAmt'+fnNo).val();
    $('#dispChnlImg').attr('src',logoPath);
    $('#dispAmt').text(chnlAmt);

}


/*************** Search data ***********/
function searchData() {
    let serchText = $('#searchText').val();

    if (serchText == '') {
        getData();
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/addChnlBackend.php",
            data: {
                serchText: serchText
            },
            success: function (response) {
                $('#cardBodyTable').html(response);
            }
        });
    }
}


/********** Get add Sub Pkg *******/
function getAllSubPkg(){
    var dummyVar3 = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/addChnlBackend.php",
        data: {
            dummyVar3:dummyVar3 
        },
        success: function (response) {
            $('#allSubPkgs').html(response);
        }
    });
}


// /************ ADD Custom Pkg data *************/
function addCustomPkg() {
    let pkgNameCustom = $('#floatingInputCustomName').val();
    var adminId = $('#sessionId').val();
    var array = [];
    var checkboxes = document.querySelectorAll('input[name=subPkg]:checked');
    for (var i = 0; i < checkboxes.length; i++) {
        array.push(checkboxes[i].value);
    }

    var noOfSelectedCheckBx =  document.querySelectorAll('input[name=subPkg]:checked').length;
    // alert(noOfSelectedCheckBx);
    if(pkgNameCustom =='' && array == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All Fields Are Mendetory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(pkgNameCustom ==''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Package Name..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(array == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Sub Packages..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(!(noOfSelectedCheckBx >= 2)){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'At Least 2 Sub Package Should Select..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else{
        $.ajax({
            type: "POST",
            url: "js/db/addChnlBackend.php",
            data: {
                pkgNameCustom : pkgNameCustom,
                arr2 : array,
                adminId : adminId
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
                            getCustPkgData();
                            $('#addCustomPkgModal').modal('hide');
                            $('#addCustPkgForm')[0].reset();
                        }
                    });
                }
            }
        });
    }
}




/************ get all custom pkg details  **********/
function getCustPkgData(){
    var dummyVar4 = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/addChnlBackend.php",
        data: {
            dummyVar4 : dummyVar4
        },
        success: function (response) {
            // alert(response);
            $('#cardBodyTable2').html(response);
        }
    });
}


/*********** show all sub pkgs modal view *********/
function getSubPkgsForModal(subPkgId){
    $.ajax({
        type: "POST",
        url: "js/db/addChnlBackend.php",
        data: {
            subPkgId:subPkgId 
        },
        success: function (response) {
            $('#showAllSubPkgsModalView').html(response);
        }
    });
}

/************* Edit Custom pkg data **********/
function editCustPkgData(editCustPkgId){
    getCustPkgNameData(editCustPkgId);
    getAllSubPkgForUpdateData(editCustPkgId);
    $('#hiddenCustPkgId').val(editCustPkgId);
}


/************** get Pkg name (custom pkg)******** */
function getCustPkgNameData(custPkgId){
    var pkgIdForGetCustPkgName = custPkgId;
    $.ajax({
        type: "POST",
        url: "js/db/addChnlBackend.php",
        data: {
            pkgIdForGetCustPkgName : pkgIdForGetCustPkgName
        },
        success: function (response) {
            $('#floatingInputUpdateDataCustPkg').val(response);
        }
    });
}

/********* get all sub packages with selected checkbox *****/
function getAllSubPkgForUpdateData(custPkgId2){
    var pkgIdForGetAllSubPkg = custPkgId2;
    $.ajax({
        type: "POST",
        url: "js/db/addChnlBackend.php",
        data: {
            pkgIdForGetAllSubPkg: pkgIdForGetAllSubPkg
        },
        success: function (response) {
            $('#allSubPkgsForUpdate').html(response);
        }
    });
}

/*********** final update custome pkg data ********/
function updateCustPkgData(){
    var adminId2 = $('#sessionId').val();
    var hiddenCustPkgId = $('#hiddenCustPkgId').val();
    var updateCustPkgName = $('#floatingInputUpdateDataCustPkg').val();
    var array = [];
    var checkboxes = document.querySelectorAll('input[name=subPkg2]:checked');
    for (var i = 0; i < checkboxes.length; i++) {
        array.push(checkboxes[i].value);
    }
    
    var noOfSelectedCheckBx =  document.querySelectorAll('input[name=subPkg2]:checked').length;
    // alert(noOfSelectedCheckBx);
    if(updateCustPkgName =='' && array == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All Fields Are Mendetory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(updateCustPkgName ==''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Package Name..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(array == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Sub Packages..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(!(noOfSelectedCheckBx >= 2)){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'At Least 2 Sub Package Should Select..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else{
        $.ajax({
            type: "POST",
            url: "js/db/addChnlBackend.php",
            data: {
                updateCustPkgName : updateCustPkgName,
                arr3 : array,
                hiddenCustPkgId : hiddenCustPkgId,
                adminId2 : adminId2
            },
            success: function (response) {
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Update Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function (success) {
                        if (success) {
                            getCustPkgData();
                            $('#editModal').modal('hide');
                        }
                    });
                }
            }
        });
    }

}

function deleteCustPkgData(delCustPkgId){
    let delCustPkgId1 = delCustPkgId;
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => 
    {
        if (result.isConfirmed) 
        {
            $.ajax({
                type: "POST",
                url: "js/db/addChnlBackend.php",
                data: {
                    delCustPkgId1: delCustPkgId1
                },
                success: function (response) {
                    if (response == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: '<h1 style="color:#009970">Success</h1>',
                            text: 'Data Deleted Successfully...',
                            textColor: 'red',
                            confirmButtonColor: '#009970'
                        }).then(function (success) {
                            if (success) {
                                getCustPkgData();
                            }
                        });
                    }
                }
            });
        }
        else{
            swal.fire("your data is safe..");
        }
    });
}

/*************** Search Custom Pkg data ***********/
function searchData2() {
    let serchText2 = $('#searchText2').val();

    if (serchText2 == '') {
        getCustPkgData();
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/addPkgBackend.php",
            data: {
                serchText2: serchText2
            },
            success: function (response) {
                $('#cardBodyTable2').html(response);
            }
        });
    }
}