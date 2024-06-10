<?php
session_start();
include 'includes/dbcon.php';
if ($_SESSION['id']) {
    $userid = $_SESSION['id'];
    $appname = 'qr-scanner.php';
    $login_sql = mysqli_query($conn, "SELECT * FROM qr_users WHERE id=$userid AND status='1'");
    $login_access = mysqli_fetch_array($login_sql);
    // Fetch active event ID
    $active_event_sql = mysqli_query($conn, "SELECT ID FROM qr_event WHERE STATUS='Active'");
    $active_event_row = mysqli_fetch_array($active_event_sql);
    $active_event_id = $active_event_row['ID'];
    // Fetch event room ID
    $event_room_sql = mysqli_query($conn, "SELECT event_room_id FROM qr_event_room WHERE event_id=$active_event_id AND assigned_user_id=$userid");
    $event_room_row = mysqli_fetch_array($event_room_sql);
    $event_room_id = $event_room_row['event_room_id'];
} else {
    echo '<script type="text/javascript">
           window.location = "' . $domain_url . 'index-scanner.php"
         </script>'; 
    unset($_SESSION['id']);
}
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Check if a POST request with a QR code value has been submitted
if (isset($_POST['qr-value'])) {
    $qrValue = $_POST['qr-value'];

    // Fetch active event ID
    $active_event_sql = mysqli_query($conn, "SELECT id FROM qr_event WHERE STATUS='Active'");
    $active_event_row = mysqli_fetch_array($active_event_sql);
    $active_event_id = $active_event_row['id'];

    // Fetch event room ID
    $event_room_sql = mysqli_query($conn, "SELECT event_room_desc FROM qr_event_room WHERE event_id=$active_event_id AND assigned_user_id=$userid");
    $event_room_row = mysqli_fetch_array($event_room_sql);

    $del_id_sql = mysqli_query($conn, "SELECT id FROM qr_attendance WHERE qrcode='$qrValue'");
    $del_id_row = mysqli_fetch_assoc($del_id_sql);
    $del_id = $del_id_row ? $del_id_row['id'] : null;

    // Check if QR code value exists in the qr_attendance table
    $stmt = $conn->prepare("SELECT COUNT(*) FROM qr_attendance WHERE qrcode = ?");
    $stmt->bind_param("s", $qrValue);
    $stmt->execute();
    $count = $stmt->get_result()->fetch_row()[0];
    $stmt->close();

    // Initialize status and username
    $status = "Failed"; // Default status if the QR code is not found

    if ($count > 0) {
        // QR code found in qr_attendance table
        $status = "Passed";
        // Update the attendance column in the qr_attendance table
        $stmt = $conn->prepare("UPDATE qr_attendance SET onsite_remarks = 'ATTENDED', status = 'YES' WHERE qrcode = ?");
        $stmt->bind_param("s", $qrValue);
        $stmt->execute();
        $stmt->close();
    } 

    // Check if the QR code exists in qr_scanner
    $qrsc_sql = mysqli_query($conn, "SELECT * FROM qr_scanner WHERE qrcode='$qrValue' and DATE_FORMAT(date,'%Y-%m-%d %h:%i') = DATE_FORMAT(now(),'%Y-%m-%d %h:%i');");
    if (mysqli_num_rows($qrsc_sql)) {
        // Update the existing qr_scanner record
    } else {
        // Insert a new record into qr_scanner
        mysqli_query($conn, "INSERT INTO qr_scanner (qrcode, date, username, status, event) VALUES ('$qrValue', now(), '$userid', '$status', '$active_event_id')");

        // Insert into qr_event_attendance if the event room is valid
        if ($status === "Passed" && $event_room_id > 0) {
            $visitData = date('Y-m-d H:i:s');
            mysqli_query($conn, "INSERT INTO qr_event_room_attendance (event_id, event_room_id, delegate_id, attendance_status, visitTime) VALUES ('$active_event_id', '$event_room_id', '$del_id', 'Attended', '$visitData')");
        }
    }

    // Display a message to the user based on the status
    if ($status === "Passed") {
        $message = "QR code value $qrValue was marked present!";
        $alertType = "success";
        $sound = 'sounds/success.mp3'; // Success sound path
    } else {
        $message = "QR code value $qrValue is not registered!";
        $alertType = "danger";
        $sound = 'sounds/error.mp3'; // Error sound path
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
            // Play notification sound
            var audio = new Audio('$sound');
            audio.play();
        </script>
    </div>";

    // Store the message in a session variable
    $errmsg_arr[] = $notification;
    $errflag = true;
    $_SESSION['register_success'] = $errmsg_arr;
    session_write_close();
    // Redirect the user to a specific page after processing the request
    header('Location: https://opengovasiatest.com/ogapps_dev/qrapp-may08-2024/qr-scanner.php');
    exit(); // Terminate the script after the redirect
}
?>
<?php
if( isset($_SESSION['register_success']) && is_array($_SESSION['register_success']) && count($_SESSION['register_success']) >0 ) {
    foreach($_SESSION['register_success'] as $msg) {
        echo $msg;
    }
    unset($_SESSION['register_success']);
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

    <div id="main-wrapper">
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                 <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title" style="text-align: center;">QR SCANNER</h4>
                                <?php
                                  // Fetch user information including username
                                  $user_sql = mysqli_prepare($conn, "SELECT * FROM qr_users WHERE id=? AND status='1'");
                                  mysqli_stmt_bind_param($user_sql, "i", $userid);
                                  mysqli_stmt_execute($user_sql);
                                  $user_result = mysqli_stmt_get_result($user_sql);
                                  $user_info = mysqli_fetch_array($user_result);
                                  $username = $user_info['username'];

                                  // Display user information
                                  echo "<p>User: $username<br>";

                                  $event_sql = mysqli_prepare($conn, "SELECT * FROM qr_event WHERE ID=?");
                                  mysqli_stmt_bind_param($event_sql, "i", $active_event_id);
                                  mysqli_stmt_execute($event_sql);
                                  $event_result = mysqli_stmt_get_result($event_sql);
                                  $event_info = mysqli_fetch_array($event_result);
                                  $event_code = $event_info['EVENT_CODE']; // Assuming this field exists in the table
                                  $event_title = $event_info['EVENT_TITLE']; // Assuming this field exists in the table
                               

                                  echo "Active Event: $event_code - $event_title<br>";

                                  // Fetch event room description
                                  $room_desc_sql = mysqli_query($conn, "SELECT event_room_desc FROM qr_event_room WHERE event_room_id='$event_room_id'");
                                  $room_desc_row = mysqli_fetch_assoc($room_desc_sql);
                                  $event_room_desc = $room_desc_row ? $room_desc_row['event_room_desc'] : null;
                                  echo "Event Room: $event_room_desc</p>";
                                  ?>

                                  <form method="POST" action="qr-scanner.php">
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
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
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