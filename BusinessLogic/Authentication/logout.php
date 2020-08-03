<<script type="text/javascript" src="../../scripts/sweetalert2.min.js"></script>
<<link rel="stylesheet" href="../../styles/sweetalert2.min.css">
<?php
session_start();
session_destroy();
echo "<script>
Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: 'You have logged out!',
    showConfirmButton: false,
    timer: 2000
  });
  window.location.href = '../../views/authentication/login-view.php';
</script>";

?>