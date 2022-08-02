/************* lenght fixed ********/
function maxLength(el) {    
    if (!('maxLength' in el)) {
        var max = el.attributes.maxLength.value;
        el.onkeypress = function () {
            if (this.value.length >= max) return false;
        };
    }
}

maxLength(document.getElementById("floatingTextarea2"));


/************ Submit Data ********/
function submitData(){
    var sessionId = $('#sessionId').val();
    var sub = $('#floatingInputForSubject').val();
    var des = $('#floatingTextareaForDes').val();
    // alert(des);
    if(sub =='' && des == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All fields are mandatory...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }else if(sub ==''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Subject...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }else if(des == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Description...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }else{
        $.ajax({
            type: "post",
            url: "js/db/giveComplaintBackend.php",
            data: {
                custId : sessionId,
                sub : sub,
                des : des
            },
            success: function (response) {
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Complaint Record Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function () {
                        $('#complaintForm')[0].reset();
                    });
                }
            }
        });
    }
    
    
}