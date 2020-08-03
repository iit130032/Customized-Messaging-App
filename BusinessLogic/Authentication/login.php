<<script type="text/javascript" src="../../scripts/sweetalert2.min.js"></script>
<<link rel="stylesheet" href="../../styles/sweetalert2.min.css">
<?php
session_start();
require_once '../Common/functions.php';

if(isset($_POST['username']) and isset($_POST['password'])){
	
	if(!empty($_POST['username']) and !empty($_POST['password'])){
			
		$username=$_POST['username'];
		$password=md5($_POST['password']);

		$connection = mysqli_connect(DB_SERVER, DB_USER_NAME, DB_PASSWORD, DB_NAME);
		
		$query = "SELECT * FROM users WHERE username ='$username' AND passwordhash ='$password'";
		$query_run = mysqli_query($connection,$query);
		
		if(mysqli_num_rows($query_run) == 1){
		  $row   = mysqli_fetch_assoc($query_run);
		  $_SESSION['session_id'] = $row['username']; //a session is created for the user
		  $_SESSION['start_time']=$_SERVER['REQUEST_TIME'];
		  $_SESSION['userId'] = $row['id'];
		  $_SESSION['user_role'] = $row['userRoleId'];

		  mysqli_close($connection);
		  echo "<script>
			window.location.href='../../views/home/home.php';
			</script>";	
		}
			
		else{
			mysqli_close($connection);
			echo "<script>
			Swal.fire({
			  title: 'Oops!',
			  text: 'Invalid log in!',
			  icon: 'error',
			  confirmButtonText: 'Ok, I will check'
			}).then((result) => {
				if(result.value){
					window.history.back();
				}
			})
			</script>";
			session_destroy();	
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