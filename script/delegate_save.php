<?php
session_start();
ob_start();
$ses=session_id();
include '../includes/dbcon.php';
if(isset($_REQUEST['save'])){
	$uniqID =$_REQUEST['unique_id'];
	$event_id = $_REQUEST['event_id'];
	$username = $_REQUEST['username'];
	mysqli_query( $conn, "delete from qr_file_upload WHERE unique_id='$uniqID'" );
	$event_data_check = mysqli_query( $conn, "select * from qr_delegates WHERE unique_id='$uniqID'" );
  	while($event_list = mysqli_fetch_array( $event_data_check )){
		$uniq_list = $event_list['unique_id'];
		mysqli_query( $conn, "delete from qr_delegates WHERE unique_id='$uniq_list'" );
	}
//	mysqli_query($conn,"TRUNCATE TABLE qr_delegates");
					$getdata = $_SESSION['store_data'];
//					print $_SESSION['store_data'];
	
					$count = "0";
					foreach($getdata as $list){
					$notes = mysqli_real_escape_string($conn,$list['1']);
					$onsite_remarks = mysqli_real_escape_string($conn,$list['2']);
					$status = mysqli_real_escape_string($conn,$list['3']);
					$polling_no = mysqli_real_escape_string($conn,$list['4']);
					$grouping = mysqli_real_escape_string($conn,$list['5']);
					$badge_name = mysqli_real_escape_string($conn,$list['6']);
					$org = mysqli_real_escape_string($conn,$list['7']);
					$qrcode = mysqli_real_escape_string($conn,$list['8']);
					$firstname = mysqli_real_escape_string($conn,$list['9']);
					$lastname = mysqli_real_escape_string($conn,$list['10']);
					$job_title = mysqli_real_escape_string($conn,$list['11']);
					$job_category = mysqli_real_escape_string($conn,$list['12']);
					$did = mysqli_real_escape_string($conn,$list['13']);
					$mobile = mysqli_real_escape_string($conn,$list['14']);
					$email = mysqli_real_escape_string($conn,$list['15']);
					$alt_email = mysqli_real_escape_string($conn,$list['16']);
					//$office_address = mysqli_real_escape_string($conn,$list['16']); commented by heather
					$street = mysqli_real_escape_string($conn,$list['17']);
					$city = mysqli_real_escape_string($conn,$list['18']);
					$postal_code = mysqli_real_escape_string($conn,$list['19']);
					$country = mysqli_real_escape_string($conn,$list['20']);
					$wishlist = mysqli_real_escape_string($conn,$list['21']);
					$sched = mysqli_real_escape_string($conn,$list['22']);
					$past_new = mysqli_real_escape_string($conn,$list['23']);
					//$vaccinated = mysqli_real_escape_string($conn,$list['24']);
			//		$vaccinated = mysqli_real_escape_string($conn);
					// $vaccinated = ''; commented by heather
					$diet = mysqli_real_escape_string($conn,$list['24']);
					$lanyard = mysqli_real_escape_string($conn,$list['25']);
					$roe = mysqli_real_escape_string($conn,$list['26']);
			//		$roe = mysqli_real_escape_string($conn,$list['21']);
		//			$roe = mysqli_real_escape_string($conn);
					//$roe = ''; commented by heather
					
					$de = mysqli_real_escape_string($conn,$list['27']);
					$de_to_call = mysqli_real_escape_string($conn,$list['28']);
					$reminder_call1 = mysqli_real_escape_string($conn,$list['29']);
					$reminder_call2 = mysqli_real_escape_string($conn,$list['30']);
					
					if ($count > 0) {
						// mysqli_query($conn, "SET time_zone = 'Asia/Singapore'"); -- Commented by Heather May 02 2024
						//mysqli_query($conn);  //-- Commented by Heather May 02 2024
						 
						$studentQuery = "INSERT INTO qr_delegates (notes,onsite_remarks,status,polling_no,grouping,badge_name,org,qrcode,
																	 firstname,lastname,job_title,job_category,did,mobile,email,alt_email,
																	 street,city,postal_code,country,wishlist,                                                       
																	 sched,past_new_de,
																	 vaccinated,diet,lanyard,roe,de,de_to_call,reminder_call1,reminder_call2,
																	 create_date,unique_id,event_id) 
														VALUES ('$notes','$onsite_remarks','$status','$polling_no','$grouping','$badge_name','$org','$qrcode',
																'$firstname','$lastname','$job_title','$job_category','$did','$mobile','$email','$alt_email',
																'$street', '$city', '$postal_code', '$country', '$wishlist', 
																'$sched','$past_new',
																'','$diet','$lanyard','$roe','$de','$de_to_call','$reminder_call1','$reminder_call2',
																 NOW(),'$uniqID','$event_id')";
						
						$result = mysqli_query($conn, $studentQuery);
						mysqli_query($conn, "DELETE FROM qr_delegates WHERE qrcode=''");
						$_SESSION['succmessage'] = "Data Save Successfully.";
						unset($_SESSION['store_data']);
					}
					
					
					
	$count++;}
	$update_file_stutas = "INSERT INTO qr_file_upload (event_id,upload_by,unique_id,upload_datetime,approved_date_datetime,status) VALUES ('$event_id','$username','$uniqID',now(),now(),'1')";
                $result = mysqli_query($conn, $update_file_stutas);
	header('Location: ../data_import.php?status='.$ses."&&uniq=".$uniqID);
	ob_end_flush();
				}
?>