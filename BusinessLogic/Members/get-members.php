<?php
session_start();
require_once '../Common/functions.php';
require_once '../Common/classes.php';

if(!isset($_SESSION['session_id']) or empty($_SESSION['session_id'])){
   print_r( json_encode(array('message' => 'Cannot find a refereced user to retrieve this record.', 'code' => ERROR_CODE)));
   return;  
}

    $memberId = file_get_contents("php://input");
    $referenceId = (int) $_SESSION['userId'];
    try{
     
        $connection = mysqli_connect(DB_SERVER, DB_USER_NAME, DB_PASSWORD, DB_NAME);

        $MEMBER;

        $membersQuery = "SELECT * FROM members where id = '$memberId' AND referenceId = '$referenceId'"; //Get Members
        $memberResult = mysqli_query($connection,$membersQuery);

        if (mysqli_num_rows($memberResult) > 0) {
           
            $returnedMember = mysqli_fetch_assoc($memberResult);

            $member = new Member();
            $member->Id = $returnedMember["id"];
            $member->Title = $returnedMember["title"];
            $member->ContactName = $returnedMember["contactName"];
            $member->FullName = $returnedMember["fullName"];
            $member->ContactMobile = $returnedMember["mobile"];
            $member->ContactAddress = $returnedMember["contactAddress"];
            $member->Email = $returnedMember["email"];
            $member->IsSheduleSMS = ((int)$returnedMember["scheduleSMS"] == 1 ? true : false);          
            
            $events = array();

            $memberEventsQuery = "SELECT * FROM memberevents where memberId = '$memberId'";
            $memberEventsResult = mysqli_query($connection,$memberEventsQuery);  //Get member events
            
            if (mysqli_num_rows($memberEventsResult) > 0) {
                //Generate member events objects
                //$i =1;
               
                while($row = mysqli_fetch_assoc($memberEventsResult)) {

                    $event = new Event();

                    $event->Id = (int)$row["idx"];
                    $event->Description = $row["eventName"];
                    $event->Date = $row["eventDate"];
                    $event->IsOneTime = ((int)$row["isOneTime"] == 1 ? true : false);
                    $event->IsDelBtn = true;
                  
                    $events[] = $event;
                }

                $member->ContactPersons = $events;

            }
            else{ //create empty object
                $event = new Event();

                $event->Id = 1;
                $event->Description = "";
                $event->Date = null;
                $event->IsOneTime = true;
                $event->IsDelBtn = true;
              
                $events[] = $event;
                $member->ContactPersons = $events;
               
            }

            $MEMBER = json_encode($member);

            print_r(json_encode(array('message' => $MEMBER, 'code' => SUCCESS_CODE)));

        } 
        else{
            print_r( json_encode(array('message' => 'Could not find the member.', 'code' => ERROR_CODE)));
        }

    }
    catch(Exception $e){
        print_r( json_encode(array('message' => $e->getMessage(), 'code' => ERROR_CODE)));
    }
   
?>