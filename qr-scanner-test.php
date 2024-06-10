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
    <?php include 'includes/dbcon.php';?>
  
<body>
   
   <?php

// Check if a POST request with a QR code value has been submitted
if (isset($_POST['qr-value'])) {
    $qrValue = $_POST['qr-value'];

    // Check if QR code value exists in the qr_attendance table
    $stmt = $conn->prepare("SELECT COUNT(*) FROM qr_attendance WHERE qrcode = ?");
    $stmt->bind_param("s", $qrValue);
    $stmt->execute();
    $count = $stmt->get_result()->fetch_row()[0];
    $stmt->close();

    if ($count > 0) {
        // Update the attendance column in the qr_attendance table
        $stmt = $conn->prepare("UPDATE qr_attendance SET onsite_remarks = 'ATTENDED', status = 'YES'  WHERE qrcode = ?");
        $stmt->bind_param("s", $qrValue);
        $stmt->execute();
        $stmt->close();

        // Display a success message to the user
       echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          QR code value $qrValue was marked present!
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          <script>
            setTimeout(function() {
              document.querySelector('.alert').remove();
              
            }, 3000);
          </script>
        </div>";
    } else {
        // Check if QR code value exists in the qr_invalid table
        $stmt = $conn->prepare("SELECT COUNT(*) FROM qr_invalid WHERE qrcode = ?");
        $stmt->bind_param("s", $qrValue);
        $stmt->execute();
        $count = $stmt->get_result()->fetch_row()[0];
        $stmt->close();

        if ($count > 0) {
            // Display a message to the user indicating that the QR code is invalid
                      
       echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          QR code value $qrValue was marked present!
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          <script>
            setTimeout(function() {
              document.querySelector('.alert').remove();

            }, 3000);
          </script>
        </div>";

        } else {
            // Add the QR code value to the qr_invalid table
            $stmt = $conn->prepare("INSERT INTO qr_invalid (qrcode, status) VALUES (?, 'INVALID QR')");
            $stmt->bind_param("s", $qrValue);
            $stmt->execute();
            $stmt->close();

            // Display a success message to the user indicating that the QR code was added to the invalid table
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          The QR code value $qrValue is invalid and has been added to the invalid table.
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          <script>
            setTimeout(function() {
              document.querySelector('.alert').remove();
            }, 3000);
          </script>
        </div>";

        }
    }
}
?>

   
    <div id="main-wrapper">
       

        <div class="page-wrapper">
            <div class="container-fluid">
            

                <div class="row">
                
                 <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center;">QR SCANNER</h4>
                               
                                
                               
                                    <video id="video" width="100%" height="auto" autoplay></video>
                                    <canvas id="canvas" style="display:none;"></canvas>
                                    <form method="POST">
                                    <input type="text" id="qr-value" class="form-control" name="qr-value" placeholder="Scanned QR code value"/>
                                    </form>
                               

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