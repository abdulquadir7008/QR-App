<?php
session_start();
ob_start();
include("../includes/dbcon.php");

$username = $_POST['username'];
$password_1 = $_POST['password'];
$password = hash('sha512', $password_1);
$sess = session_id();

if ($username != '' || $password != '') {    
    $qry = "SELECT * FROM qr_users WHERE (username = '$username' OR useremail = '$username') AND password = '$password' AND status='1'";
    $result = mysqli_query($conn, $qry);

    if ($result) { // Check if the query was executed successfully
        if (mysqli_num_rows($result) == 1) {
            $member = mysqli_fetch_assoc($result);

            if ($member['2fa_switch'] == 'inactive') {    
                $id = $_SESSION['id'] = $member['id'];
            }

            $member_id = $member['id'];
            $fullname = $member['fullname'];
            $f_email = $member['useremail'];

            // Insert a record into qr_user_logs for successful login
            $logDesc = 'success';
            $logDate = date('Y-m-d');
            $logTime = date('H:i:s');
            $insertQuery = "INSERT INTO qr_user_logs (username, log_desc, log_date, log_time) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $member_id, $logDesc, $logDate, $logTime);
            
            if ($stmt->execute()) { // Check if the insert query was executed successfully
                $stmt->close();
                mysqli_query($conn, "UPDATE qr_users SET session_id='$sess' WHERE id='$member_id'");

                if ($member['2fa_switch'] == 'inactive') {
                    header('Location:../index.php');
                    ob_end_flush();
                } else {    
                    $errmsg_arr[] = '<div class="alert alert-success alert-dismissable show-hidden-menu"> <a href="#" class="close hidden-menu" data-dismiss="alert" aria-label="close">×</a> The QR Code for this secret (to scan with the Google Authenticator App: \n".</div>';
                    $errflag = true;
                    $_SESSION['famesage'] = $errmsg_arr;
                    session_write_close();
                    header('Location: ../2fa-login.php?log='.$sess);
                    ob_end_flush();
                }
            } else {
                // Handle the case where the insert query fails
                $error_message = mysqli_error($conn);
                echo "Insert Error: " . $error_message; // You can log or display the error message
            }
        } else {
            // Insert a record into qr_user_logs for failed login
            $logDesc = 'failed';
			$logDate = date('Y-m-d');
			$logTime = date('H:i:s');
			$insertQuery = "INSERT INTO qr_user_logs (username, log_desc, log_date, log_time) VALUES (?, ?, ?, ?)";
			$stmt = $conn->prepare($insertQuery);
			$stmt->bind_param("ssss", $username, $logDesc, $logDate, $logTime);
			$stmt->execute();
			$stmt->close();
            
            $errmsg_arr[] = '<div class="alert alert-danger alert-dismissable show-hidden-menu"> <a  class="close hidden-menu">×</a> <strong>Error!</strong> Please enter your valid email and password</div>';
            $errflag = true;
            $_SESSION['loginerror'] = $errmsg_arr;
            echo "$appname";
            header('Location:../index.php');
            ob_end_flush();
        }
    } else {
        // Handle the case where the query itself fails
        $error_message = mysqli_error($conn);
        echo "Query Error: " . $error_message; // You can log or display the error message
    }
} else {
    $errmsg_arr[] = '<div class="alert alert-danger alert-dismissable show-hidden-menu"> <a class="close hidden-menu" onclick="funcShow();">×</a> <strong>Error!</strong> This email/password combination is incorrect</div>';
    $errflag = true;
    $_SESSION['loginerror'] = $errmsg_arr;
    
    // Insert a record into qr_user_logs for failed login
    $logDesc = 'failed';
    $logDate = date('Y-m-d');
    $logTime = date('H:i:s');
    $insertQuery = "INSERT INTO qr_user_logs (username, log_desc, log_date, log_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $username, $logDesc, $logDate, $logTime);
    $stmt->execute();
    $stmt->close();
    
    header('Location:../index.php');
    ob_end_flush();
}
?>