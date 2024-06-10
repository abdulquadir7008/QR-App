<?php
    include 'includes/dbcon.php';
    $id = $_GET['id'];
    

    if(isset($_REQUEST['priv_id'])){
        $privid2 = $_REQUEST['priv_id'];
        $updatpriv_sql = "UPDATE ev_privileges_details SET view_update ='view/update' WHERE priv_id='$privid2'";
        mysqli_query($conn,$updatpriv_sql);
    }
    
    $qrcode = $_POST['qrcode'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $badge_name = $_POST['badge_name'];
    $job_title = $_POST['job_title'];
    $job_category = $_POST['job_category'];
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
    $additional = $_POST['additional'];
    $grouping = $_POST['grouping'];
    $sched = $_POST['sched'];
    $vaccinated = $_POST['vaccinated'];
    $roe = $_POST['roe'];
    $active_user = $_POST['active_user'];
    $unique = $_POST['unique'];
    $state = $_POST['state'];
    $notes = $_POST['notes'];
    $created_by = $_POST['created_by'];
    $eventID = $_POST['eventID'];

    $delegates_sql = "UPDATE qr_delegates SET state ='$state', approved_by = '$active_user', approved_time = NOW() WHERE md5(id) = '$id'";

    $add_sql = "INSERT INTO qr_attendance (qrcode,de,past_new_de,agency_count,de_to_call,reminder_call1,reminder_call2,onsite_remarks,status,notes,polling_no,lanyard,badge_name,firstname,lastname,job_title,job_category,org,did,mobile,email,alt_email,office_address,diet,parking,grouping,sched,vaccinated,roe,onsite_time,state,created_by,unique_id,event_id,approved_by,approved_time,street, postal_code, country, city, wishlist)
    VALUES ('$qrcode','$de','$past_new_de','$agency_count','$de_to_call','$reminder_call1','$reminder_call2','$remarks','$status','$notes','$polling_no','$lanyard','$badge_name','$firstname','$lastname','$job_title','$job_category','$org','$did','$mobile','$email','$alt_email','$office_address','$diet','$parking','$grouping','$sched','$vaccinated','$roe','','$state','$created_by','$unique','$eventID','$active_user',NOW(), '$street', '$postal_code', '$country', '$city', '$wishlist')";
   
    /* text placeholder for APPROVED(state column) edited by HEATHER to $state MAY 10 2024*/
   /* VALUES ('$qrcode','$de','$past_new_de','$agency_count','$de_to_call','$reminder_call1','$reminder_call2','$remarks','$status','$notes','$polling_no','$lanyard','$badge_name','$firstname','$lastname','$job_title','$job_category','$org','$did','$mobile','$email','$alt_email','$office_address','$diet','$parking','$grouping','$sched','$vaccinated','$roe','','Approved','$created_by','$unique','$eventID','$active_user',NOW(), '$street', '$postal_code', '$country', '$city', '$wishlist')"; */

    /* end*/

   if ($conn->query($add_sql) === true && $conn->query($delegates_sql) === true) {
        echo "<script>
            setTimeout(function() {
                alert('Successfully saved');
                window.location.href = 'for-approval.php';
            }, 1000);
          </script>";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
?>
