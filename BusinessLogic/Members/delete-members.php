<?php
session_start();
require_once '../Common/functions.php';

if(!isset($_SESSION['session_id']) or empty($_SESSION['session_id'])){
   print_r( json_encode(array('message' => 'Cannot find a refereced user to delete this record.', 'code' => ERROR_CODE)));
   return;  
}

    $memberId = file_get_contents("php://input");
   
    try{
     
        $connection = mysqli_connect(DB_SERVER, DB_USER_NAME, DB_PASSWORD, DB_NAME);

        $memberEventsDeleteQuery="DELETE FROM memberevents where memberId = '$memberId'";
        mysqli_query($connection,$memberEventsDeleteQuery);  //Delete member events

        $memberDeleteQuery="DELETE FROM members where id = '$memberId'";
        mysqli_query($connection,$memberDeleteQuery);  //Delete members
        
        if(mysqli_error($connection) == ''){ 
            print_r( json_encode(array('message' => "Successfully removed member ", 'code' => SUCCESS_CODE)));
            mysqli_close($connection);
        }
        else{
           print_r( json_encode(array('message' => 'An error occured.'. mysqli_error($connection), 'code' => ERROR_CODE)));
           mysqli_close($connection);
            //TO DO: Write to error log.
        }
    }
    catch(Exception $e){
        print_r( json_encode(array('message' => $e->getMessage(), 'code' => ERROR_CODE)));
    }
   
?>