<?php
session_start();
ob_start();
$sess = session_id();
include 'includes/dbcon.php';
$privuser2 = 'scanner';
$qrValue = '';

if ($_SESSION['id']) {
    $id = $_SESSION['id'];
    $login_sql = mysqli_query($conn, "SELECT * FROM qr_users WHERE id = $id AND status = '1'");
    $login_access = mysqli_fetch_array($login_sql);
    $privuser2 = $login_access['username'];
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
</head>

<body>
    <?php
    if (isset($_POST['qr-value'])) {
        // Rest of your code for handling POST requests
    }
    ?>
    <?php
    if (isset($_SESSION['register_success']) && is_array($_SESSION['register_success']) && count($_SESSION['register_success']) > 0) {
        foreach ($_SESSION['register_success'] as $msg) {
            echo $msg;
        }
        unset($_SESSION['register_success']);
    }
    ?>

    <div id="main-wrapper">
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center;">QR SCANNER OPTIMISED</h4>
                                <form method="POST" action="qr-scanner.php">
                                    <center>
                                        <input type="text" id="qr-value" style="font-weight:bold;font-size: 22px;tex-align:center;margin-bottom:10px;border:none; background: #0b4696; color: #fff" class="form-control" readonly name="qr-value" placeholder="" />
                                        <?php
                                        $sql0 = "SELECT * FROM qr_event WHERE STATUS='Active'";
                                        $result0 = $conn->query($sql0);
                                        if ($result0->num_rows > 0) {
                                            while ($row0 = $result0->fetch_array()) {
                                                $eventid = $row0['ID'];
                                        ?>
                                                <input type="hidden" id="eventid" class="form-control" name="eventid" value="<?php echo $eventid ?>" aria-describedby="name">
                                        <?php
                                            }
                                        } else {
                                            echo "<center><p>No Records</p></center>";
                                        }
                                        ?>
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
        navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "environment"
                }
            })
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
                    inversionAttempts: "dontInvert"
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
