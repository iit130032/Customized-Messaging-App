<?php
session_start();
require_once '../Common/functions.php';

if(!isset($_SESSION['session_id']) or empty($_SESSION['session_id'])){
   print_r( json_encode(array('message' => 'Cannot find a refereced user to add this record.', 'code' => ERROR_CODE)));
   return;  
}
//TO DO: Modify to update and add members
    $postdata = file_get_contents("php://input");
    $member = json_decode($postdata);

    $title = $member->Title;
    $contactName = $member->ContactName;
    $fullName = $member->FullName;
    $contactMobile = $member->ContactMobile;
    $contactAddress = $member->ContactAddress;
    $email = $member->Email;
    $isSheduleSMS = $member->IsSheduleSMS;
    $events = $member->ContactPersons;

    if(empty($contactName) or empty($contactMobile)){
        print_r( json_encode(array('message' => 'You must provide a contact name and a mobile number.', 'code' => ERROR_CODE)));
        return;
    }

    try{

        $connection = mysqli_connect(DB_SERVER, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        
        //creating new member
        $referenceId = (int) $_SESSION['userId'];        
        $title = trim(htmlspecialchars($title));
        $contactName =trim(htmlspecialchars($contactName));
        $fullName = trim(htmlspecialchars($fullName));
        $contactMobile = trim(htmlspecialchars($contactMobile));
        $contactAddress = trim(htmlspecialchars($contactAddress));
        $email = trim(htmlspecialchars($email));
      
        $insertQuery="INSERT INTO members (referenceId,title,contactName,fullName,mobile,contactAddress,email,scheduleSMS) 
                      VALUES('$referenceId','$title','$contactName','$fullName','$contactMobile','$contactAddress','$email',".($isSheduleSMS ? 1 : 0) .")";

        mysqli_query($connection,$insertQuery);
        
        if(mysqli_affected_rows($connection) > 0){ 
                   
            $inserted_member_id = (int) mysqli_insert_id($connection);
            $insertEventQuery ="";
            if($isSheduleSMS == true){
                try{
                    foreach ($events as $key => $event) {
                        $idx = $event->Id;
                        $eventName =  trim(htmlspecialchars($event->Description));
                        $eventDate =  date('Y-m-d', strtotime($event->Date));

                        $insertEventQuery = "INSERT INTO memberevents (memberId,idx,eventName,eventDate,isOneTime) VALUES('$inserted_member_id','$idx','$eventName','$eventDate',".($event->IsOneTime ? 1 : 0) .")";        
                        mysqli_query($connection,$insertEventQuery);

                    }
                }
                catch(Exception $x){
                    throw $x;
                }

                print_r( json_encode(array('message' => "Successfully created new member ".$contactName, 'code' => SUCCESS_CODE)));
                mysqli_close($connection);
               
            }
            else{
                print_r( json_encode(array('message' => "Successfully created new member ".$contactName, 'code' => SUCCESS_CODE)));
                mysqli_close($connection);
            }
            
        }
        else{
            //mysqli_query($connection,"ROLLBACK");
           print_r( json_encode(array('message' => 'An error occured.'. mysqli_error($connection), 'code' => ERROR_CODE)));
           mysqli_close($connection);
            //TO DO: Write to error log.
        }
    }
    catch(Exception $e){
        //mysqli_query($connection,"ROLLBACK");
        print_r( json_encode(array('message' => $e->getMessage(), 'code' => ERROR_CODE)));
    }
   
?>