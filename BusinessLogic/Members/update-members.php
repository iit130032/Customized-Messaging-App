<?php
session_start();
require_once '../Common/functions.php';

if(!isset($_SESSION['session_id']) or empty($_SESSION['session_id'])){
   print_r( json_encode(array('message' => 'Cannot find a refereced user to update this record.', 'code' => ERROR_CODE)));
   return;  
}
//TO DO: Modify to update and add members
    $postdata = file_get_contents("php://input");
    $member = json_decode($postdata);
    $Id = $member->Id;
    $title = $member->Title;
    $contactName = $member->ContactName;
    $fullName = $member->FullName;
    $contactMobile = $member->ContactMobile;
    $contactAddress = $member->ContactAddress;
    $email = $member->Email;
    $isSheduleSMS = $member->IsSheduleSMS;
    $events = $member->ContactPersons;

    if(empty($contactName) or empty($contactMobile)){
        print_r(json_encode(array('message' => 'You must provide a contact name and a mobile number.', 'code' => ERROR_CODE)));
        return;
    }

    try{

        $connection = mysqli_connect(DB_SERVER, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        
        //update member
        $referenceId = (int) $_SESSION['userId'];        
        $title = trim(htmlspecialchars($title));
        $contactName =trim(htmlspecialchars($contactName));
        $fullName = trim(htmlspecialchars($fullName));
        $contactMobile = trim(htmlspecialchars($contactMobile));
        $contactAddress = trim(htmlspecialchars($contactAddress));
        $email = trim(htmlspecialchars($email));
      
       
        $updateQuery="UPDATE members SET
        referenceId = '$referenceId',
        title = '$title',
        contactName = '$contactName',
        fullName = '$fullName',
        mobile = '$contactMobile',
        contactAddress = '$contactAddress',
        email = '$email',
        scheduleSMS = ".($isSheduleSMS ? 1 : 0) ." WHERE Id = '$Id' ";

        mysqli_query($connection,$updateQuery);

        //Update events
       
        if($isSheduleSMS){
            //select all existing records
            $selectQuery = "SELECT * FROM memberevents WHERE memberId = ". $Id;
            $query_result = mysqli_query($connection,$selectQuery);
            
            if(mysqli_num_rows($query_result) == 0){ //no existing events
                if(count($events) > 0) {
                    foreach ($events as $key => $event) {
                        $idx = $event->Id;
                        $eventName =  trim(htmlspecialchars($event->Description));
                        $eventDate =  date('Y-m-d', strtotime($event->Date));
                        $insertEventQuery = "INSERT INTO memberevents (memberId,idx,eventName,eventDate,isOneTime) VALUES('$Id','$idx','$eventName','$eventDate',".($event->IsOneTime ? 1 : 0) .")";        
                        mysqli_query($connection,$insertEventQuery);
                    }
                }
            }
            else{ 
                $existingEventIds = array();
                //iterating through existing records
                while($row = mysqli_fetch_assoc($query_result)) {
                    $existingEventIds[] = $row["idx"];
                }

                if(count($events) > 0) {
                    //Delete removed events from the database
                    $eventIdsFromFrontEnd = array_column($events, 'Id');
                    $deletedEventIds = array_diff($existingEventIds, $eventIdsFromFrontEnd);

                    if(count($deletedEventIds) > 0){
                        foreach ($deletedEventIds as $key => $deletedId) {
                            $deleteEventQuery = "DELETE FROM memberevents WHERE memberId='$Id' AND idx='$deletedId' ";
                            mysqli_query($connection,$deleteEventQuery);
                        }
                    }
                    //Add and update events
                    foreach ($events as $key => $event) {
                        $query = "";
                        $idx = $event->Id;
                        $eventName =  trim(htmlspecialchars($event->Description));
                        $eventDate =  date('Y-m-d', strtotime($event->Date));

                        if(in_array($idx, $existingEventIds)){ //update existing event
                            $query = "UPDATE memberevents SET eventName='$eventName',eventDate='$eventDate',isOneTime=".($event->IsOneTime ? 1 : 0)." WHERE memberId='$Id' AND idx='$idx'";
                        }
                        else{ //add new event
                            $query = "INSERT INTO memberevents (memberId,idx,eventName,eventDate,isOneTime) VALUES('$Id','$idx','$eventName','$eventDate',".($event->IsOneTime ? 1 : 0) .")";
                        }     
                        mysqli_query($connection,$query);
                    }
                }
            }

        }
        else{
            //Delete all events
            $deleteAllEventsQuery = "DELETE FROM memberevents WHERE memberId =". $Id;
            mysqli_query($connection,$deleteAllEventsQuery);
        }

        mysqli_close($connection);
        print_r( json_encode(array('message' => "Successfully updated member details ", 'code' => SUCCESS_CODE)));
            
        
        
    }
    catch(Exception $e){
        //mysqli_query($connection,"ROLLBACK");
        print_r( json_encode(array('message' => $e->getMessage(), 'code' => ERROR_CODE)));
    }
   
?>