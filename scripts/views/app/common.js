
function sweetAlertError(msgHeading,msg){

    Swal.fire({
        title: msgHeading,
        text: msg,
        icon: 'error'
        
      });
}

function sweetAlertSuccess(msgHeading,msg){
    Swal.fire({
        title: msgHeading,
        text: msg,
        icon: 'success'
      });
}

function sweetAlertConfirm(msgHeading,msg,confirmBtnText,showCancelButton,callBack){
  Swal.fire({
    title: msgHeading,
    text: msg,
    icon: 'warning',
    showCancelButton: showCancelButton,
    confirmButtonText: confirmBtnText
  }).then((result) => {
     if(result.value){
       callBack();
     }
  }) 
}

function sweetAlertSuccessFromSide(title){
  Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: title,
    showConfirmButton: false,
    timer: 2000
  });
}