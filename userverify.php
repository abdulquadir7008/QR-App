<?php
include 'includes/dbcon.php';
session_start();
if ( isset( $_POST[ 'username' ] ) ) {
  $username = mysqli_real_escape_string( $conn, $_POST[ 'username' ] );
  $query = "select * from qr_users where username='" . $username . "'";
  $result = mysqli_query( $conn, $query );
  if ( mysqli_num_rows( $result ) > 0 ) {
    $response = "<span style='color: red;float:right;font-size:13px;'>Not Available.</span>";
  } else {
    $response = "<span style='color: green;float:right;font-size:13px;'>Available.</span>";
  }
  echo $response;
  die;
}
?>