$( document ).ready(function() {
    $('#registerUser').prop("disabled",true);
    $('#chkAgree').prop("checked",false);

    $("#chkAgree").click(function() {
        $("#registerUser").prop("disabled", !this.checked);
    });
    
});