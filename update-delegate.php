<?php
    include 'includes/dbcon.php';
    $id = $_GET['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $badge_name = $_POST['badge_name'];
    $job_title = $_POST['job_title'];
    $org = $_POST['org'];
    $de = $_POST['de'];
    $past_new_de = $_POST['past_new_de'];
    $agency_count = $_POST['agency_count'];
    $de_to_call = $_POST['de_to_call'];
    $reminder_call1 = $_POST['reminder_call1'];
    $reminder_call2 = $_POST['reminder_call2'];
    $polling_no = $_POST['polling_no'];
    $lanyard = $_POST['lanyard'];
    $did = $_POST['did'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $alt_email = $_POST['alt_email'];
    $office_address = $_POST['office_address'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];
    $wishlist = $_POST['wishlist'];
    $diet = $_POST['diet'];
    $parking = $_POST['parking'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];
    $notes = $_POST['notes'];
    $grouping = $_POST['grouping'];
    $sched = $_POST['sched'];
    $vaccinated = $_POST['vaccinated'];
    $roe = $_POST['roe'];
if(isset($_REQUEST['priv_id'])){
	$privid2 = $_REQUEST['priv_id'];
	$updatpriv_sql = "UPDATE ev_privileges_details SET view_update ='view/update' WHERE priv_id='$privid2'";
	mysqli_query($conn,$updatpriv_sql);
	
}
    //$activity = "Updated attendance for ID: " . $firstname . $lastname;
    //$active_user = $_POST['active_user'];
   // echo
    $attendance_sql = "UPDATE qr_attendance SET firstname ='$firstname', lastname ='$lastname', badge_name ='$badge_name', job_title ='$job_title', org ='$org', de ='$de', past_new_de ='$past_new_de', agency_count ='$agency_count', de_to_call ='$de_to_call', reminder_call1 ='$reminder_call1', reminder_call2 ='$reminder_call2', polling_no ='$polling_no', lanyard ='$lanyard', did ='$did', mobile ='$mobile', de ='$de', email ='$email', alt_email ='$alt_email', office_address ='$office_address', diet ='$diet', parking ='$parking', de ='$de', status='$status', onsite_remarks ='$remarks', notes ='$notes', lastname ='$lastname', firstname ='$firstname', grouping ='$grouping', sched ='$sched' , vaccinated ='$vaccinated' , roe ='$roe', street ='$street', city ='$city', postal_code ='$postal_code', country ='$country', wishlist ='$wishlist' WHERE md5(id) = '$id'";        

    
if ($conn->query($attendance_sql) === true) {
    echo "<script>
            setTimeout(function() {
                alert('Successfully saved');
                window.location.href = 'dashboard.php';
            }, 1000);
          </script>";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();

?>
