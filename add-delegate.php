<?php
// Include the database connection file
include 'includes/dbcon.php';

// Collect data from the POST request
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
$remarks1 = $_POST['remarks1'];
$additional = $_POST['additional'];
$grouping = $_POST['grouping'];
$sched = $_POST['sched'];
$vaccinated = $_POST['vaccinated'];
$roe = $_POST['roe'];
$notes = $_POST['notes'];
$active_user = $_POST['active_user'];
$unique = $_POST['unique'];
$eventID = $_POST['eventID'];
$userstatus = $_POST['userstatus'];
$item = $_POST['userstatus'];

// Define the SQL query
$sql_query = "INSERT INTO qr_delegates (qrcode,status, onsite_remarks, firstname, lastname, badge_name, job_title, job_category, org, de, past_new_de, agency_count, de_to_call, reminder_call1, reminder_call2, polling_no, lanyard, did, mobile, email, alt_email, office_address, diet, parking, grouping, sched, vaccinated, roe, unique_id, event_id, state, created_by, notes, street, postal_code, country, city, wishlist) 
                    VALUES ('$qrcode','$status', '$remarks1', '$firstname', '$lastname', '$badge_name', '$job_title', '$job_category', '$org', '$de', '$past_new_de', '$agency_count', '$de_to_call', '$reminder_call1', '$reminder_call2', '$polling_no', '$lanyard', '$did', '$mobile', '$email', '$alt_email', '$office_address', '$diet', '$parking', '$grouping', '$sched', '$vaccinated', '$roe', '$unique', '$eventID', 'Pending', '$active_user', '$notes', '$street', '$postal_code', '$country', '$city', '$wishlist')";

// Conditionally execute the appropriate SQL query based on userstatus
if ($userstatus == 4) {
    // ADDING THE ROW ON BOTH QR ATTENDANCE AND QR DELEGATES TABLE
    $add_sql = "INSERT INTO qr_attendance (qrcode,de,past_new_de,agency_count,de_to_call,reminder_call1,reminder_call2,onsite_remarks,notes,polling_no,lanyard,badge_name,firstname,
lastname,job_title,org,did,mobile,email,alt_email,office_address,diet,parking,grouping,sched,vaccinated,roe,onsite_time,state,created_by,unique_id,event_id,approved_by,approved_time,street,postal_code,country,city,wishlist, job_category) VALUES ('$qrcode','$de','$past_new_de','$agency_count','$de_to_call','$reminder_call1','$reminder_call2','$status','$notes','$polling_no','$lanyard','$badge_name','$firstname','$lastname','$job_title','$org','$did','$mobile','$email','$alt_email','$office_address','$diet','$parking','$grouping','$sched','$vaccinated','$roe','','Approved','$created_by','$unique','$eventID','$active_user',NOW(), '$street', '$postal_code', '$country', '$city', '$wishlist', '$job_category')";

    $sql_query = "INSERT INTO qr_delegates (qrcode, firstname, lastname, badge_name, job_title, job_category, org, de, past_new_de, agency_count, de_to_call, reminder_call1, reminder_call2, polling_no, lanyard, did, mobile, email, alt_email, office_address, diet, parking, grouping, sched, vaccinated, roe, unique_id, event_id, state, created_by, notes,street, postal_code, country, city, wishlist) 
    VALUES ('$qrcode', '$firstname', '$lastname', '$badge_name', '$job_title', '$job_category', '$org', '$de', '$past_new_de', '$agency_count', '$de_to_call', '$reminder_call1', '$reminder_call2', '$polling_no', '$lanyard', '$did', '$mobile', '$email', '$alt_email', '$office_address', '$diet', '$parking', '$grouping', '$sched', '$vaccinated', '$roe', '$unique', '$eventID', 'Approved', '$active_user', '$notes', '$street', '$postal_code', '$country', '$city', '$wishlist')";

     
    if ($conn->query($sql_query) === true && $conn->query($add_sql) === true) {
        echo "<script>
                setTimeout(function() {
                    alert('Delegate Successfully Saved');
                    window.location.href = 'dashboard.php';
                }, 1000);
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    if ($conn->query($sql_query) === true) {
        echo "<script>
                setTimeout(function() {
                    alert('Delegate Successfully Saved');
                    window.location.href = 'dashboard.php';
                }, 1000);
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
