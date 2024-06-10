<?php
//function connectToDatabase() {
//    $conn = mysqli_init();
//    mysqli_ssl_set($conn, NULL, NULL, "/home/site/wwwroot/ogapp/file/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
//    if (!$conn) {
//        die("Failed to initialize MySQLi: " . mysqli_connect_error());
//    }
//
//    if (!mysqli_real_connect($conn, "opengovasiatestdb.mysql.database.azure.com", "hywhuftmvq", "E8SI50E417T2L3F2$", "qrdb", 3306, MYSQLI_CLIENT_SSL)) {
//        die("Failed to connect to MySQL: " . mysqli_connect_error());
//    } else {
//        echo "Successfully connected to database.";
//    }
//}
//connectToDatabase();
$conn = mysqli_init();
//mysqli_ssl_set($conn,NULL,NULL, "/home/site/wwwroot/ogapp/file/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
//mysqli_real_connect($conn, "opengovasiatestdb.mysql.database.azure.com", "hywhuftmvq", "E8SI50E417T2L3F2$", "ogapp_dev", 3306, MYSQLI_CLIENT_SSL);

mysqli_ssl_set($conn,NULL,NULL, "/home/site/wwwroot/ogapps_dev/ogapp-jan10-24/file-test/DigiCertGlobalRootCA.crt.pem", NULL, NULL);               
mysqli_real_connect($conn, "opengovogdb1.mysql.database.azure.com", "wzsjsqxjiq", "T88318G176B5188Z$", "ogapp03nov23", 3306, MYSQLI_CLIENT_SSL);


$domain_url="https://opengovasiatest.com/ogapps_dev/ogapp-jan10-24/";
date_default_timezone_set('Asia/Singapore'); // Set the default timezone to Singapore
$sql0 = "SELECT * FROM qr_event WHERE STATUS='Active'";
$result0 = $conn->query($sql0);
if ($result0->num_rows > 0) {
    while ($row0 = $result0->fetch_array()) {
        $eventCode = $row0['EVENT_CODE'];
        $eventID = $row0['ID'];
        $eventTitle = $row0['EVENT_TITLE'];
        $eventVenue = $row0['EVENT_VENUE'];
        $eventDate = $row0['EVENT_DATE'];
}
}
?>
<?php
//session_start(); // Start the session (if not already started)
date_default_timezone_set('Asia/Singapore'); 
// Initialize a global variable to store the log_time
$globalLogTime = null;

// Assuming you have already established a database connection as shown in your code

// Check if the user is logged in (you may have different session variable names)
if (isset($_SESSION['id'])) {
    $username = $_SESSION['id'];

    // Prepare the SQL query
    $query = "SELECT log_time FROM qr_user_logs WHERE username = ? ORDER BY id DESC LIMIT 1";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Check if there are rows returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch the log_time and store it in the global variable
            $row = mysqli_fetch_assoc($result);
            $globalLogTime = $row['log_time'];
        } else {
            echo "No matching records found.";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        //echo "Error in preparing the statement: " . mysqli_error($conn);
    }
} else {
   // echo "User is not logged in."; // You may want to handle this differently
}
?>
