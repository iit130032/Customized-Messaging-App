<?php
//DB connect parameters
define('DB_SERVER','localhost');
define('DB_USER_NAME','root');
define('DB_PASSWORD','admin');
define('DB_NAME','templedb');
//
//http status codes
define('ERROR_CODE',400);
define('SUCCESS_CODE',200);

//user roles
define('ADMIN',0);
define('FULL_ACCESS',1);
define('QUICK_ACCESS',2);




//to check whether a user is logged in or not.
function IsUserLogged(){
	session_start();
	if(isset($_SESSION['session_id']) or !empty($_SESSION['session_id'])){
		return true;	  
	}
	else{
		return false;
	}
	
}

function VerifyLogin(){

	if(!isset($_SESSION['session_id']) or empty($_SESSION['session_id'])){
		echo 
		"<script>
		window.location.href='../../views/authentication/login-view.php';
		</script>"; 
	
	  }
}

//This function is to convert local contact numbers to international format
function changeContactFormat($contact){

$finalString="";	

 $result = str_split($contact);
 
 $temp=0;

	for($i=sizeof($result)-1;$i>=0;$i--){

		if($temp==9){

			break;			
		}	
		else{

		$finalString.=$result[$i];
		$temp++;

		}			
	}		
		return strrev($finalString."49+");

	  //should edit returns +94 for null strings
}


//This function is to send SMS via online gateway

function sendMessage($contact,$sendingmessage){ 

	// Textlocal account details
	$username = "gihanishalanika@gmail.com";
	//$hash =  "f32ea343c37a400e733811136efbdc3582bca3ba";
	$hash="f3c36568afff8d0ebdf03550ff0d6dc879791e82";

	// Message details
	$number = $contact;
	$sender = urlencode("UWU");
	$message = rawurlencode($sendingmessage);
	//$numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('username' => $username, 'hash' => $hash, 'numbers' => $number, "sender" => $sender, "message" => $message);
 
	// Send the POST request with cURL
	$ch = curl_init('http://api.txtlocal.com/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	// Process your response here
	echo $response;
}

//This function is to notify students when registration is available


function notifyRegistration(){

	dbConnect();

	$result1=mysql_query("SELECT * from msgstatus WHERE msgid='MSG001'");

	if(mysql_result($result1,0,'status')==0){

		$result2=mysql_query("SELECT * from programschedule");

		if((mysql_num_rows($result2)==1)){

			if(!is_null(mysql_result($result2,0,'regstartdate')) and !is_null(mysql_result($result2,0,'regenddate'))){

				$today=date('Y-m-d');
				$sendingmessage="";
				$contact="";

			 if((mysql_result($result2,0,'regstartdate')<=$today) and ($today<=mysql_result($result2,0,'regenddate'))){

    					
				 $result3 = mysql_query("SELECT * FROM studentstonotify");

				 if((mysql_num_rows($result3)>0)){

					while ($row = mysql_fetch_array($result3, MYSQL_ASSOC)) {

				  	$sendingmessage=$row['title'].' '.$row['lname'].', OnlineRegistration for External Courses at UWU has now been started.';
				  	$contact =$row['contact'];

				  	sendMessage($contact,$sendingmessage);

				  	echo $sendingmessage." ".$contact."</br>";

					}

					//mysql_query("UPDATE msgstatus SET status=1 WHERE msgid='MSG001'");
				   
				}	

    					 
  				}

			}   
		}
	}


//mysql_close($con);
}

//this function is to inform who have not yet registered about limited vacencies when registration is ongoing.
function notifyRemainingVacencies(){

	dbConnect();

	$result1=mysql_query("SELECT * from msgstatus WHERE msgid='MSG002'");

	if(mysql_result($result1,0,'status')==0){

		$result2=mysql_query("SELECT * from programschedule");

		if((mysql_num_rows($result2)==1)){

			if(!is_null(mysql_result($result2,0,'regstartdate')) and !is_null(mysql_result($result2,0,'regenddate'))){

				$today=date('Y-m-d');
				$sendingmessage="";
				$contact="";

			 if((mysql_result($result2,0,'regstartdate')<=$today) and ($today<=mysql_result($result2,0,'regenddate'))){

    			
    			$registeredStudents=mysql_num_rows(mysql_query("SELECT * FROM students_courses"));
    			$totalVacencies=mysql_result(mysql_query("SELECT SUM(numofstudents) AS TotalVacencies FROM courses"),0,'TotalVacencies');

    			

    			if(($totalVacencies-$registeredStudents)<=10){

    			 $result3 = mysql_query("SELECT studentstonotify.title,studentstonotify.lname,studentstonotify.contact from studentstonotify,students where studentstonotify.nic not in(students.nic)");

    			  if((mysql_num_rows($result3)>0)){

					while ($row = mysql_fetch_array($result3, MYSQL_ASSOC)) {

				  	$sendingmessage=$row['title'].' '.$row['lname'].',please make your registration soon. Less than 10 vacencies are available.';
				  	$contact =$row['contact'];

				  	sendMessage($contact,$sendingmessage);

				  	echo $sendingmessage." ".$contact."</br>";

					}

					//mysql_query("UPDATE msgstatus SET status=1 WHERE msgid='MSG002'");
				   
				}
				mysql_error();

    			}		
    					 
  				}

			}   
		}
	}
	//mysql_close($con);
}

// this is to inform the program start date to registered students.
function notifyStartDate(){

 	dbConnect();

	$result1=mysql_query("SELECT * from msgstatus WHERE msgid='MSG003'");

	if(mysql_result($result1,0,'status')==0){

		$result2=mysql_query("SELECT * from programschedule");

		if((mysql_num_rows($result2)==1)){

			if(!is_null(mysql_result($result2,0,'prostartdate')) and !is_null(mysql_result($result2,0,'proenddate'))){

				$today=date('Y-m-d');
				$sendingmessage="";
				$contact="";

			 if(($today>=mysql_result($result2,0,'regenddate'))){

    			 $result3 = mysql_query("SELECT students.title,students.name_with_ini,students.contact from students");

    			  if((mysql_num_rows($result3)>0)){

					while ($row = mysql_fetch_array($result3, MYSQL_ASSOC)) {

				  	$sendingmessage=$row['title'].' '.$row['name_with_ini'].',External Courses of UWU will be commenced on '.mysql_result($result2,0,'prostartdate');
				  	$contact =$row['contact'];

				  	sendMessage($contact,$sendingmessage);

				  	echo $sendingmessage." ".$contact."</br>";

					}

					//mysql_query("UPDATE msgstatus SET status=1 WHERE msgid='MSG003'");
				   
				}
				mysql_error();
    					 
  				}

			}   
		}
	}

//mysql_close($con);

}

/*this is to notify students who have no 80% attendance (this function needs to be modified when new course added or sheduled day is changed
for a course)*/
/*function notifyAttendance(){

dbConnect();


$result1=mysql_query("SELECT * from msgstatus WHERE msgid='MSG004'");

	if(mysql_result($result1,0,'status')==0){

		$result2=mysql_query("SELECT * from programschedule");

		if((mysql_num_rows($result2)==1)){

			if(!is_null(mysql_result($result2,0,'prostartdate')) and !is_null(mysql_result($result2,0,'proenddate'))){

				$today=date('Y-m-d');
				$sendingmessage="";
				$contact="";
				$minAttDaysJava=0;//minimum no of days to keep 80% attendance
				$minAttDaysWeb=0; 

				$querySats=mysql_query("SELECT FLOOR((DATEDIFF(proenddate,prostartdate)/7)) as numofSat FROM programschedule");

				$numofSats=mysql_result($query,0,'numofSat'); //no of Saturdays: need to have a better way to get exact number

				$querySuns=mysql_query("SELECT FLOOR((DATEDIFF(proenddate,prostartdate)/7)) as numofSat FROM programschedule");

				$numofSuns=mysql_result($query,0,'numofSat'); //no of Sundays: need to have a better way to get exact number

			 if(($today>mysql_result($result2,0,'prostartdate')) and ($today<mysql_result($result2,0,'proenddate'))){

			 	$minAttDaysJava=$numofSuns)/5;
			 	$minAttDaysWeb=(4*$numofSats)/5;

    			 $result3 = mysql_query("SELECT students.title,students.name_with_ini,students.contact from students where per_status in(1)");

    			  if((mysql_num_rows($result3)>0)){

					while ($row = mysql_fetch_array($result3, MYSQL_ASSOC)) {

				  	$sendingmessage=$row['title'].' '.$row['name_with_ini'].', current attendence for '.$row['coursename'].'will disqualify you to offer participation certificate.
				  	Please attend comming 4 days regularly to avoid this.';
				  	$contact =$row['contact'];

				  	//sendMessage($contact,$sendingmessage);

				  	echo $sendingmessage." ".$contact."</br>";

					}

					//mysql_query("UPDATE msgstatus SET status=1 WHERE msgid='MSG004'");
				   
				}
				mysql_error();
    					 
  				}

			}   
		}
	}







}*/









// this function displays all available courses in the database in the registration form with check boxes
function displayCourses(){

dbConnect();

$courseid="";
$coursename="";

$result=mysql_query("SELECT * FROM courses");

				 if((mysql_num_rows($result)>0)){

					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

					$courseid=$row["courseid"];
					$coursename=$row['coursename'];	
					echo "<label><input type='checkbox' value='$courseid' name='courseid[]'>$coursename</label>";	
					echo "</br>";
					}

					mysql_error();
				   
				}


}

// this function displays all available courses in the database in the option list

function displayCoursesOptions(){

dbConnect();

$courseid="";
$coursename="";

$result=mysql_query("SELECT * FROM courses");

				 if((mysql_num_rows($result)>0)){

					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

					$courseid=$row["courseid"];
					$coursename=$row['coursename'];	
					echo "<option>$coursename</option>";	
				
					}

					mysql_error();
				   
				}


}








//this is to retrieve starting dates and ending dates of courses and registrations admin home page
function returnDates(){

$regstartdate=date('Y-m-d');
$regenddate=date('Y-m-d');
$coursestartdate=date('Y-m-d');
$courseenddate=date('Y-m-d');


dbConnect();

$result=mysql_query("SELECT * from programschedule");

if((mysql_num_rows($result)==1)){



  if((!is_null(mysql_result($result,0,'regstartdate'))) && (!is_null(mysql_result($result,0,'regenddate')))){

    $regstartdate=mysql_result($result,0,'regstartdate');
    $regenddate=mysql_result($result,0,'regenddate');

  }

  if((!is_null(mysql_result($result,0,'prostartdate'))) && (!is_null(mysql_result($result,0,'proenddate')))){

    $coursestartdate=mysql_result($result,0,'prostartdate');
    $courseenddate=mysql_result($result,0,'proenddate');

  }

  return array($regstartdate,$regenddate,$coursestartdate,$courseenddate);
}


}



function viewTemporaryStudents(){


dbConnect();


$query="SELECT * FROM students ORDER BY registereddate";

$result=mysql_query($query);

if((mysql_num_rows($result)>0)){

	$recordno=1;
	$confirmstatus="";

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		
		$nic=$row['nic'];
		$name_with_ini=$row['name_with_ini'];
		$contactno=$row['contact'];
		$paddress=$row['paddress'];
		


		if($row['confirm_status']==0)
			$confirmstatus="Not Confirmed";
		else
			$confirmstatus="Confirmed";


					echo "<tr>
					<td>$recordno</td>
					<td>$nic</td>
					<td>$name_with_ini</td>
					<td>$contactno</td>
					<td>$paddress</td>
					<td>$confirmstatus</td>
					

					<td>
					
					<button type='button' class='btn btn-info btn-sm btngrp' id='$nic' data-toggle='modal' data-target='#myModal1'>View/Edit</button>
					<button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal2'>Confirm Student</button>
					</td>
					



					</tr>";	
					$recordno++;
					}

					

	return true;

}

else{

echo 'No Results Found!';

}

//mysql_close($con);

}












function viewPermanentStudents(){


dbConnect();

$result=mysql_query("SELECT * FROM students WHERE confirm_status=1 ORDER BY regno");

if((mysql_num_rows($result))>0){

	$recordno=1;
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		
		$regno=$row['regno'];
		$name_with_ini=$row['name_with_ini'];
		
		
		


					echo "<tr>
					<td>$recordno</td>
					<td>$regno</td>
					<td>$name_with_ini</td>
					

					<td>
					<button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='myModal' id='edit'>View/Edit</button>
					<button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal' id='verify'>Confirm Installment 2</button>
					</td>
					

					</tr>";	
					$recordno++;
					}

}

else{

echo 'No Results Found!';

}

//mysql_close($con);

}

















function generateRegistrationNumbers(){


dbConnect();

$batchno=0;

$result=mysql_query("SELECT * FROM students WHERE confirm_status=1 ORDER BY lastname");



	if((mysql_num_rows($result))>0){

		$result2=mysql_query("SELECT * FROM programschedule");

		if((mysql_num_rows($result2))==1){

			$batchno = mysql_result($result2,0,'batchno');



			$regno="UWU/SC/".$batchno."/";

			$index=1;

			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {


			$index=str_pad($index, 3, "0", STR_PAD_LEFT);
			$regno=$regno.$index;
			$nic=$row['nic'];

			mysql_query("UPDATE students SET regno='$regno' WHERE nic='$nic'");

			$index++;
			$regno="UWU/SC/".$batchno."/";

		}

		header("location:viewpermstudents.php");

		}

		else
			echo "<script>
			alert('Not Entered Programme Schedule');
			window.location.href='viewpermstudents.php';
			</script>";

			
	}
	else
		echo 'No entries found to generate Registration Numbers';

}

//these functions are related to enter student attendance


function getnic($regno){

dbConnect();
  $nic;
  $result_nic=mysql_query("SELECT nic FROM students WHERE regno='$regno'");
    
      while ($row = mysql_fetch_array($result_nic, MYSQL_ASSOC)) {
      $nic=$row['nic'];

    }

    return $nic;

 }


function getcourseid($coursename){

  dbConnect();
  $courseid;

  $result_courseid=mysql_query("SELECT courseid FROM courses WHERE coursename='$coursename'");
      
      while ($row = mysql_fetch_array($result_courseid, MYSQL_ASSOC)) {
        $courseid=$row['courseid'];
      }
      
    return $courseid;
 }








//functions related to financial transactions

function viewActualExpenditureCategories(){


dbConnect();
$grandTotal=0.0;

$result=mysql_query("SELECT * FROM expensecategories ");

if((mysql_num_rows($result))>0){

	//$recordno=1;
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$categoryId=$row['categoryid'];
		$categoryName=$row['categoryname'];
		

		$total=0.0;
		

		$result2=mysql_query("SELECT SUM(sub_total) from expenses where budget_type=1 and expense_category='$categoryId'");

		while ($row = mysql_fetch_array($result2, MYSQL_NUM)) {

			$total=$row[0];
			$grandTotal+=$row[0];
      
		}
		
					echo "<tr>
						  <td>$categoryId</td>
						  <td><a href='viewActualExpences.php?id="."$categoryId"."'>$categoryName</a></td>
						  <td><input type='text' class='form-control' id='' value='$total' placeholder='' disabled></td>
						  </tr>";					

					
					}

			echo "<tr>
				  <td></td>
				  <td><strong>Grand Total</strong></td>
				  <td><strong><input type='text' class='form-control' id='' value='$grandTotal' placeholder='' disabled></strong></td>
				  </tr>";		

}

else{

echo 'No Results Found!';

}


}



function viewExpenditureCategories(){


dbConnect();
$grandTotal=0.0;
$result=mysql_query("SELECT * FROM expensecategories");

if((mysql_num_rows($result))>0){
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$categoryId=$row['categoryid'];
		$categoryName=$row['categoryname'];

		$total=0.0;
		

		$result2=mysql_query("SELECT SUM(sub_total) from expenses where budget_type=0 and expense_category='$categoryId'");

		while ($row = mysql_fetch_array($result2, MYSQL_NUM)) {

			$total=$row[0];
			$grandTotal+=$row[0];
      
		}		
		
		  echo "<tr>
				<td>$categoryId</td>
				<td><a href='viewExpenses.php?id="."$categoryId"."'>$categoryName</a></td>
				<td><input type='text' class='form-control' id='' value='$total' placeholder='' disabled></td>
				</tr>";					

				
		}

			echo "<tr>
				  <td></td>
				  <td><strong>Grand Total</strong></td>
				  <td><strong><input type='text' class='form-control' id='' value='$grandTotal' placeholder='' disabled></strong></td>
				  </tr>";		

}

else{

echo 'No Results Found!';

}


}




function viewIncomeCategories(){

dbConnect();
$grandTotal=0.0;

$result=mysql_query("SELECT * FROM incomecategories");

if((mysql_num_rows($result))>0){

	//$recordno=1;
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$categoryId=$row['categoryid'];
		$categoryName=$row['categoryname'];

		$total=0.0;
		

		$result2=mysql_query("SELECT SUM(sub_total) from incomes where budget_type=0 and income_category='$categoryId'");

		while ($row = mysql_fetch_array($result2, MYSQL_NUM)) {

			$total=$row[0];
			$grandTotal+=$row[0];
      
		}
		
		
					echo "<tr>
						  <td>$categoryId</td>
						  <td><a href='viewIncomes.php?id="."$categoryId"."'>$categoryName</a></td>
						  <td><input type='text' class='form-control' id='' value='$total' placeholder='' disabled></td>
						  </tr>";					

					
					}

			echo "<tr>
				  <td></td>
				  <td><strong>Grand Total</strong></td>
				  <td><strong><input type='text' class='form-control' id='' value='$grandTotal' placeholder='' disabled></strong></td>
				  </tr>";		

}

else{

echo 'No Results Found!';

}





}


function viewActualIncomeCategories(){

dbConnect();
$grandTotal=0.0;

$result=mysql_query("SELECT * FROM incomecategories");

if((mysql_num_rows($result))>0){

	//$recordno=1;
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$categoryId=$row['categoryid'];
		$categoryName=$row['categoryname'];


	$total=0.0;
		
		$result2=mysql_query("SELECT SUM(sub_total) from incomes where budget_type=1 and income_category='$categoryId'");

		while ($row = mysql_fetch_array($result2, MYSQL_NUM)) {

			$total=$row[0];
			$grandTotal+=$row[0];
      
		}
		
		
					echo "<tr>
						  <td>$categoryId</td>
						  <td><a href='viewActualIncome.php?id="."$categoryId"."'>$categoryName</a></td>
						  <td><input type='text' class='form-control' id='' value='$total' placeholder='' disabled></td>
						  </tr>";					

					
					}

			echo "<tr>
				  <td></td>
				  <td><strong>Grand Total</strong></td>
				  <td><strong><input type='text' class='form-control' id='' value='$grandTotal' placeholder='' disabled></strong></td>
				  </tr>";		

}

else{

echo 'No Results Found!';

}

}













function viewActualVal(){
$html="";
dbConnect();

$categoryid=$_GET['id'];

$result=mysql_query("SELECT * FROM expenses where expense_category="."$categoryid and budget_type=1");

if((mysql_num_rows($result))>0){

	$recordno=1;
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$description=$row['description'];
		$cost_per_unit=$row['cost_per_unit'];
		$no_of_units=$row['no_of_units'];
		$sub_total=$row['sub_total'];
		$transact=$row['transac_no'];
		$expences_cat=$row['expense_category'];

					 
					echo "<tr id=".$transact.">
						  <td>$recordno</td>
						  <td>$description</td>
						  <td><input type='text' class='form-control' id='txtunit_Price' value='$cost_per_unit'></td>
						  <td><input type='text' class='form-control' id='txtunits' value='$no_of_units'></td>
						  <td><input type='text' class='form-control' id='txtsub' value='$sub_total' disabled></td>
						  <td><input type='hidden' class='form-control' id='txthid' value='$expences_cat'></td>
						  </tr>";					

					$recordno++;
					}
}


}


function viewActualIncomeVal(){
$html="";
dbConnect();

$categoryid=$_GET['id'];

$result=mysql_query("SELECT * FROM incomes where income_category="."$categoryid and budget_type=1");

if((mysql_num_rows($result))>0){

	$recordno=1;
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$description=$row['description'];
		$cost_per_unit=$row['cost_per_unit'];
		$no_of_units=$row['no_of_units'];
		$sub_total=$row['sub_total'];
		$transact=$row['transac_no'];
		$income_cat=$row['income_category'];

					 
					echo "<tr id=".$transact.">
						  <td>$recordno</td>
						  <td>$description</td>
						  <td><input type='text' class='form-control' id='txtunit_Price' value='$cost_per_unit'></td>
						  <td><input type='text' class='form-control' id='txtunits' value='$no_of_units'></td>
						  <td><input type='text' class='form-control' id='txtsub' value='$sub_total' disabled></td>
						  <td><input type='hidden' class='form-control' id='txthid' value='$income_cat'></td>
						  </tr>";					

					$recordno++;
					}
}


}






















function viewExpectedVal(){
$html="";
dbConnect();

$categoryid=$_GET['id'];

$result=mysql_query("SELECT * FROM expenses where expense_category="."$categoryid and budget_type='0'");

if((mysql_num_rows($result))>0){

	$recordno=1;
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$description=$row['description'];
		$cost_per_unit=$row['cost_per_unit'];
		$no_of_units=$row['no_of_units'];
		$sub_total=$row['sub_total'];
		$transact=$row['transac_no'];
		$expences_cat=$row['expense_category'];

					 
					echo "<tr id=".$transact.">
						  <td>$recordno</td>
						  <td>$description</td>
						  <td><input type='text' class='form-control' id='txtunit_Price' value='$cost_per_unit'></td>
						  <td><input type='text' class='form-control' id='txtunits' value='$no_of_units'></td>
						  <td><input type='text' class='form-control' id='txtsub' value='$sub_total' disabled></td>
						  <td><input type='hidden' class='form-control' id='txthid' value='$expences_cat'></td>
						  </tr>";					

					$recordno++;
					}
}


}


function viewExpectedIncome(){

$html="";
dbConnect();

$categoryid=$_GET['id'];

$result=mysql_query("SELECT * FROM incomes where income_category="."$categoryid and budget_type='0'");

if((mysql_num_rows($result))>0){

	$recordno=1;
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$description=$row['description'];
		$cost_per_unit=$row['cost_per_unit'];
		$no_of_units=$row['no_of_units'];
		$sub_total=$row['sub_total'];
		$transact=$row['transac_no'];
		$income_cat=$row['income_category'];

					 
					echo "<tr id=".$transact.">
						  <td>$recordno</td>
						  <td>$description</td>
						  <td><input type='text' class='form-control' id='txtunit_Price' value='$cost_per_unit'></td>
						  <td><input type='text' class='form-control' id='txtunits' value='$no_of_units'></td>
						  <td><input type='text' class='form-control' id='txtsub' value='$sub_total' disabled></td>
						  <td><input type='hidden' class='form-control' id='txthid' value='$income_cat'></td>
						  </tr>";					

					$recordno++;
					}
}










}



function returnExpenseValues(){
$html="";
dbConnect();

$categoryid=$_GET['id'];

$result=mysql_query("SELECT * FROM expenses where expense_category="."$categoryid");

if((mysql_num_rows($result))>0){

	$recordno=1;
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$description=$row['description'];
		$cost_per_unit=$row['cost_per_unit'];
		$no_of_units=$row['no_of_units'];
		$sub_total=$row['sub_total'];
		$transact=$row['transac_no'];
		$expences_cat=$row['expense_category'];

					 
					echo "<tr id=".$transact.">
						  <td>$recordno</td>
						  <td>$description</td>
						  <td><input type='text' class='form-control' id='txtunit_Price' value='$cost_per_unit'></td>
						  <td><input type='text' class='form-control' id='txtunits' value='$no_of_units'></td>
						  <td><input type='text' class='form-control' id='txtsub' value='$sub_total' disabled></td>
						  <td><input type='hidden' class='form-control' id='txthid' value='$expences_cat'></td>
						  </tr>";					

					$recordno++;
					}
}



}

function getExpenseCategoryName(){

dbConnect();

$categoryid=$_GET['id'];
$categoryName;

$result=mysql_query("SELECT categoryname FROM expensecategories where categoryid="."$categoryid");

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

	$categoryName=$row['categoryname'];

}

return $categoryName;

}

function getIncomeCategoryName(){

dbConnect();

$categoryid=$_GET['id'];
$categoryName;

$result=mysql_query("SELECT categoryname FROM incomecategories where categoryid="."$categoryid");

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

	$categoryName=$row['categoryname'];

}

return $categoryName;





}
function updateExpences(){

$Id = $_POST['Id']; 
$Cost = $_POST['Cost']; 
$No = $_POST['No']; 
$Sub = $_POST['Sub']; 
$Cat = $_POST['Cat']; 
 
dbConnect();



$result=mysql_query("UPDATE expenses set  cost_per_unit='$Cost',no_of_units='$No',sub_total='$Sub' where transac_no='$Id' and expense_category='$Cat' and budget_type=0");


}




function updateExpectedIncome(){

$Id = $_POST['Id']; 
$Cost = $_POST['Cost']; 
$No = $_POST['No']; 
$Sub = $_POST['Sub']; 
$Cat = $_POST['Cat']; 
 
dbConnect();


$result=mysql_query("UPDATE incomes set  cost_per_unit='$Cost',no_of_units='$No',sub_total='$Sub' where transac_no='$Id' and income_category='$Cat' and budget_type=0");


}

function updateActualIncome(){

$Id = $_POST['Id']; 
$Cost = $_POST['Cost']; 
$No = $_POST['No']; 
$Sub = $_POST['Sub']; 
$Cat = $_POST['Cat']; 
 
dbConnect();


$result=mysql_query("UPDATE incomes set  cost_per_unit='$Cost',no_of_units='$No',sub_total='$Sub' where transac_no='$Id' and income_category='$Cat' and budget_type=1d");


}




function 	updateActualExpences(){

$Id = $_POST['Id']; 
$Cost = $_POST['Cost']; 
$No = $_POST['No']; 
$Sub = $_POST['Sub']; 
$Cat = $_POST['Cat']; 
 
//echo "Called Function";
dbConnect();

$result=mysql_query("UPDATE expenses set  cost_per_unit='$Cost',no_of_units='$No',sub_total='$Sub' where transac_no='$Id' and expense_category='$Cat' and budget_type=1");


}


function getExpectedBudgetSummary(){

dbConnect();


$totalRev=0.0;
$totalExpend=0.0;
$projProfit=0.0;
$profitMargin=0.0;
$sumofUnitIncome=0.0;
$breakEP=0.0;

$result=mysql_query("SELECT SUM(sub_total) from incomes where budget_type=0");

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {

	$totalRev=$row[0];
}

$result2=mysql_query("SELECT SUM(sub_total) from expenses where budget_type=0");

while ($row = mysql_fetch_array($result2, MYSQL_NUM)) {

	$totalExpend=$row[0];
}


$projProfit=$totalRev-$totalExpend;

$profitMargin=($projProfit/$totalRev)*100;


$result3=mysql_query("SELECT SUM(cost_per_unit) from incomes where budget_type=0");

while ($row = mysql_fetch_array($result3, MYSQL_NUM)) {

	$sumofUnitIncome=$row[0];
}


$breakEP=floor($totalExpend/$sumofUnitIncome);



echo "<tr>
	  <th>Total Expected Revanue</th>
	  <td>$totalRev</td>
	  </tr>

	  <tr>
	  <th>Total Expected Expenditure</th>
	  <td>$totalExpend</td>
	  </tr>

	  <tr>
	  <th>Projected Profit</th>
	  <td>$projProfit</td>
	  </tr>


	  <tr>
	  <th>Profit Margin</th>
	  <td>$profitMargin</td>
	  </tr>


	  <tr>
	  <th>Break Even Point (As Number of Students)</th>
	  <td>$breakEP</td>
	  </tr>

	  ";



}

/*function searchTemp(){
	

	$Id=$_POST['Id'];
 session_start();
 $_SESSION['nic']=$Id;

    ;

}*/


/*function getStudentInfo(){
	$id=$_SESSION['nic'];

 $details= array();

$result=mysql_query("SELECT * FROM students where nic=$id");
 
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$details['lastname']=$row['lastname'];
	$details['fullname']=$row['fullname'];
	$details['title']=$row['title'];
	$details['dob']=$row['dob'];
	$details['sex']=$row['sex'];
	$details['designation']=$row['designation'];
	$details['paddress']=$row['paddress'];
	$details['workaddress']=$row['workaddress'];


 
}
return $details;
}*/

 


?>

