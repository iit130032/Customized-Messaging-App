<?php
/* if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/dashboard/');
  exit; */
  require_once 'BusinessLogic/Common/functions.php';
  
  if(!IsUserLogged()){
    echo 
    "<script>
    window.location.href='views/authentication/login-view.php';
    </script>"; 

  }
  else{
    echo 
    "<script>
    window.location.href='views/home/home.php';
    </script>"; 
  }
?>
