$(document).ready(function() {
    $('#tblMembers').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "../../../businesslogic/members/view-members.php"
    } );
} );