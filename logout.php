<?php
//PREVIOUS CODE WITHOUT THE USERS LOGS
//session_start();
//ob_start();
//include( "includes/dbcon.php" );
//$id=$_SESSION['id'];
//mysqli_query($conn,"UPDATE qr_users set 2fa='0',session_id='' where id='$id'");
//session_destroy();
//unset($_SESSION['id']);
//header('location:index.php');
//ob_end_flush();
//exit();
?>
<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// PREVIOUS CODE WITHOUT THE USERS LOGS
session_start();
ob_start();
include("includes/dbcon.php");
$id = $_SESSION['id'];


// Debug: Check the value of $_SESSION['id']
echo "Session ID: " . $id;

mysqli_query($conn, "UPDATE qr_users SET 2fa='0', session_id='' WHERE id='$id'");

// Add the code snippet here to update the user logs
$updateQuery = "UPDATE qr_user_logs SET logout_time = NOW() WHERE username = ? AND log_time = ?";
$stmt = mysqli_prepare($conn, $updateQuery);

if ($stmt) {
    // Provide two type definition strings, 'ss' for two string placeholders
    mysqli_stmt_bind_param($stmt, "ss", $id, $globalLogTime);

    // Set the MySQL session time zone to Singapore
    mysqli_query($conn, "SET time_zone = '+08:00'");

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Check if the header redirection was successful
if (header('location:index.php')) {
    echo "Redirect successful";
} else {
    echo "Redirect failed";
}

session_destroy();
unset($_SESSION['id']);
ob_end_flush();
exit();
?>











