<?php
session_start();
ob_start();
$sess=session_id();
include 'includes/dbcon.php';
$privuser2='scanner';
$qrValue='';
if ( $_SESSION[ 'id' ] ) {
    $id = $_SESSION[ 'id' ];
    $login_sql = mysqli_query( $conn, "select * from qr_users WHERE id=$id and status='1'" );
    $login_access = mysqli_fetch_array( $login_sql );
    $privuser2=$login_access['username'];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.jpg">
    <title>OpenGov Asia QR Code Event Scanner</title>
    <link href="assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="dist/css/style.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  
<body>

<?php
// Check if a POST request with a QR code value has been submitted
if (isset($_POST['qr-value'])) {
    $qrValue = $_POST['qr-value'];
    $eventid = $_POST['eventid'];
    
    // Check if QR code value exists in the qr_attendance table
    $stmt = $conn->prepare("SELECT COUNT(*) FROM qr_attendance WHERE qrcode = ?");
    $stmt->bind_param("s", $qrValue);
    $stmt->execute();
    $count = $stmt->get_result()->fetch_row()[0];
    $stmt->close();

    // Initialize status and username
    $status = "Failed"; // Default status if the QR code is not found
    $username = ""; // You should define this based on your application's logic

    if ($count > 0) {
        // QR code found in qr_attendance table
        $status = "Pass";
        
        // Update the attendance column in the qr_attendance table
        $stmt = $conn->prepare("UPDATE qr_attendance SET onsite_remarks = 'ATTENDED', status = 'YES' WHERE qrcode = ?");
        $stmt->bind_param("s", $qrValue);
        $stmt->execute();
        $stmt->close();
        
        // Check if the QR code exists in qr_scanner
        $qrsc_sql = mysqli_query($conn, "SELECT * FROM qr_scanner WHERE qrcode='$qrValue'");
        if (mysqli_num_rows($qrsc_sql)) {
            // Update the existing qr_scanner record
            mysqli_query($conn, "UPDATE qr_scanner SET status='$status', date=now(), username='$privuser2', event='$eventid' WHERE qrcode='$qrValue'");
        } else {
            // Insert a new record into qr_scanner
            mysqli_query($conn, "INSERT INTO qr_scanner (qrcode, date, username, status, event) VALUES ('$qrValue', now(), '$privuser2', '$status', '$eventid')");
        }
    } else {
        // QR code not found in qr_attendance table
        // Check if the QR code exists in qr_scanner to avoid multiple insertions
        $qrsc_sql = mysqli_query($conn, "SELECT * FROM qr_scanner WHERE qrcode='$qrValue'");
        if (!mysqli_num_rows($qrsc_sql)) {
            // Insert a new record into qr_scanner with 'Failed' status
            mysqli_query($conn, "INSERT INTO qr_scanner (qrcode, date, username, status, event) VALUES ('$qrValue', now(), '$privuser2', '$status', '$eventid')");
        }
    }

    // Display a message to the user based on the status
    if ($status === "Pass") {
        $message = "QR code value $qrValue was marked present!";
        $alertType = "success";
    } else {
        $message = "QR code value $qrValue is not registered!";
        $alertType = "danger";
    }

    // Create an alert message for the user
    $notification = "<div class='alert alert-$alertType alert-dismissible fade show' role='alert' style='font-size: 22px; padding: 20px; text-align: center;'>
        QR Value: <span style='font-size: 22px; padding: 0px; text-align: center; font-weight: bold;'>$qrValue</span><br><br>
        $message
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        <script>
            setTimeout(function() {
                document.querySelector('.alert').remove();
            }, 4000);
        </script>
    </div>";

    // Store the message in a session variable
    $errmsg_arr[] = $notification;
    $errflag = true;
    $_SESSION['register_success'] = $errmsg_arr;
    session_write_close();
    
    // Redirect the user to a specific page after processing the request
    header('Location: https://opengovasia.com/ogapps/ogapp03nov23/qr-scanner-faster.php');
    exit(); // Terminate the script after the redirect
}
?>

<?php
if( isset($_SESSION['register_success']) && is_array($_SESSION['register_success']) && count($_SESSION['register_success']) >0 ) {
foreach($_SESSION['register_success'] as $msg) {
echo $msg;
    
}
unset($_SESSION['register_success']); }
                        ?>
    <div id="main-wrapper">
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                 <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center;">QR SCANNER</h4>
                               
                                    <form method="POST" action="qr-scanner-faster.php">
                                    <center>
                                      <input type="text" id="qr-value" style="font-weight:bold;font-size: 22px;tex-align:center;margin-bottom:10px;border:none; background: #0b4696; color: #fff" class="form-control" readonly name="qr-value" placeholder=""/>
                                    </center>
                                    </form>
                                    <video id="video" width="100%" height="auto" autoplay></video>
                                    <canvas id="canvas" style="display:none;"></canvas>
                                    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
         
   <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>


     <script>
      const video = document.getElementById("video");
      const canvas = document.getElementById("canvas");
      const result = document.getElementById("qr-value");
      const ctx = canvas.getContext("2d");

      navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
        .then(function(stream) {
          video.srcObject = stream;
          video.setAttribute("playsinline", true);
          video.play();
          requestAnimationFrame(tick);
        })
        .catch(function(err) {
          console.log(err);
        });

      function tick() {
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
          canvas.width = video.videoWidth;
          canvas.height = video.videoHeight;
          ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
          const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
          const code = jsQR(imageData.data, imageData.width, imageData.height, {
            inversionAttempts: "dontInvert",
          });
          if (code) {
            result.value = code.data;
            submitForm();
          }
        }
        requestAnimationFrame(tick);
      }

      function submitForm() {
        if (result.value) {
          document.forms[0].submit();
        }
      }

      result.addEventListener("input", submitForm);
    </script>
</body>
</html>