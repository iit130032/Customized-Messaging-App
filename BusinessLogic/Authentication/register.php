<<script type="text/javascript" src="../../scripts/sweetalert2.min.js"></script>
<<link rel="stylesheet" href="../../styles/sweetalert2.min.css">

<?php
require_once '../Common/functions.php';

if(isset($_POST['username']) and isset($_POST['password'])){
	
	if(!empty($_POST['username']) and !empty($_POST['password'])){
			
    $username = $_POST['username'];  
    $password = md5($_POST['password']);
    $veryfiedPassword = md5($_POST['verifiedPassword']);
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $organization = $_POST['organization'];
    $mobile = $_POST['mobile'];
    $tele = $_POST['tele'];
    $userType =(int) $_POST['userType'];

    if($password != $veryfiedPassword){
      echo "<script>
      Swal.fire({
        title: 'Oops!',
        text: 'Passwords do not match!',
        icon: 'error',
        confirmButtonText: 'Ok, I will check'
      }).then((result) => {
          if(result.value){
              window.history.back();
          }
      })
      </script>";
      return;
    }
   
		$connection = mysqli_connect(DB_SERVER, DB_USER_NAME, DB_PASSWORD, DB_NAME);
		
		$query = "SELECT * FROM users WHERE username='$username'";
		$query_run = mysqli_query($connection,$query);
		
		if(mysqli_num_rows($query_run) == 0){
      //creating user account          
      $username=trim(htmlspecialchars($username));
      $email = trim(htmlspecialchars($email));  
      $fullName = trim(htmlspecialchars($fullName));
      $organization = trim(htmlspecialchars($organization));
      $mobile = trim(htmlspecialchars($mobile));
      $tele = trim(htmlspecialchars($tele));

      $insertQuery="INSERT INTO users (username,passwordhash,email,fullname,organization,mobile,telephone,userRoleId) 
      VALUES('$username','$password','$email','$fullName','$organization','$mobile','$tele','$userType')";                 
      mysqli_query($connection,$insertQuery);
        
      if(mysqli_affected_rows($connection) > 0){          
        mysqli_close($connection);
        $message = "successfully created user: ".$username;
        echo "<script>
        Swal.fire({
          title: 'Good!',
          text: '".$message."',
          icon: 'success',
          confirmButtonText: 'Ok'
        }).then((result) => {
            if(result.value){
                window.location.href = '../../views/authentication/login-view.php';
            }
        })
        </script>";
      }
      else{
      mysqli_close($connection);
      //echo "Error: " . $insertQuery . "<br>" . mysqli_error($connection);
      //TO DO: Insert Try Catch, Write to error log.
      echo "<script>
          Swal.fire({
            title: 'Oops!',
            text: 'Something went wrong!',
            icon: 'error',
            confirmButtonText: 'Ok, I will check'
          }).then((result) => {
              if(result.value){
                  window.history.back();
              }
          })
          </script>";
      }

		}	
		else{                
      mysqli_close($connection);
      echo "
      <script>
      Swal.fire({
        title: 'Oops!',
        text: 'This user already exists!',
        icon: 'error',
        confirmButtonText: 'Ok, I will check'
      }).then((result) => {
          if(result.value){
              window.history.back();
          }
      })
      </script>";
		}
		
	}
	else{	      
      echo "
      <script>
      Swal.fire({
        title: 'Oops!',
        text: 'Username and Password should not empty!',
        icon: 'error',
        confirmButtonText: 'Ok, I will check'
      }).then((result) => {
          if(result.value){
              window.history.back();
          }
      })
      </script>";	
    }

    
}

?>


   