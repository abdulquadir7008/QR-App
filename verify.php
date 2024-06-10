<?php 
session_start();
ob_start();
include 'includes/dbcon.php';
if(isset($_REQUEST['temp']) && isset($_REQUEST['email'])) {
    echo $temp=$_REQUEST['temp'];
    $email=$_REQUEST['email'];
	$sess = session_id();

    $query="update qr_users SET status='1' WHERE useremail='$email' and status='0'";         
    mysqli_query($conn,$query);

$errmsg_arr[] = '<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> <strong>Success!</strong> Thank you for register.Your Email Verify is Successfully. Please login to below.</div>';
$errflag = true;
$_SESSION['register_success'] = $errmsg_arr;
session_write_close();
header('Location: index.php');
ob_end_flush();
	}
	else{
		$errmsg_arr[] = '<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> <strong>Fail!</strong> Session has expired. Please try again.</div>';
		$errflag = true;
		$_SESSION['register_success'] = $errmsg_arr;
		session_write_close();
		header('Location: register.php');
		ob_end_flush();
	}
    
?>