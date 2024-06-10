<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/dbcon.php';

if (isset($_GET['event_id'])) {
    $eventID = mysqli_real_escape_string($conn, $_GET['event_id']);

    // Define the number of times you want to insert
    $insertCount = 1; // Change this value based on your requirement

    // Use a prepared statement to avoid SQL injection
    $insertQuery = "INSERT INTO qr_attendance_history 
                    (de, past_new_de, agency_count, de_to_call, reminder_call1, reminder_call2, onsite_time, onsite_remarks, notes, status, polling_no, lanyard, qrcode, badge_name, firstname, lastname, job_category, job_title, org, did, mobile, email, alt_email, office_address, street, city, postal_code, country, wishlist, diet, parking, grouping, sched, vaccinated, roe, event_id, create_date, unique_id, created_by, approved_by, approved_time, state) 
                    SELECT de, past_new_de, agency_count, de_to_call, reminder_call1, reminder_call2, onsite_time, onsite_remarks, notes, status, polling_no, lanyard, qrcode, badge_name, firstname, lastname, job_category, job_title, org, did, mobile, email, alt_email, office_address, street, city, postal_code, country, wishlist, diet, parking, grouping, sched, vaccinated, roe, event_id, create_date, unique_id, created_by, approved_by, approved_time, state
                    FROM qr_attendance";
    $stmt = mysqli_prepare($conn, $insertQuery);

    for ($i = 0; $i < $insertCount; $i++) {
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_error($stmt)) {
            // If the insertion fails, provide error details
            echo "<script>
                    alert('Error transferring data to qr_attendance_history: " . mysqli_stmt_error($stmt) . "');
                    window.location.href = 'event_manage.php';
                  </script>";
            break;
        }
    }

    mysqli_stmt_close($stmt);

    // Update the status in qr_event table to 'Completed'
    $updateQuery = "UPDATE qr_event SET STATUS = 'Completed' WHERE ID = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, "i", $eventID);
    mysqli_stmt_execute($stmtUpdate);

    if (mysqli_stmt_error($stmtUpdate)) {
        // If the update query is unsuccessful, provide error details
        echo "<script>
                alert('Error updating event status: " . mysqli_stmt_error($stmtUpdate) . "');
                window.location.href = 'event_manage.php';
              </script>";
    } else {
        // If successful display an alert
        echo "<script>
                alert('Data transferred successfully to qr_attendance_history and event marked as complete.');
              </script>";
    }

    mysqli_stmt_close($stmtUpdate);

    // Truncate the qr_attendance table
    $truncateQuery = "TRUNCATE TABLE qr_attendance";
    mysqli_query($conn, $truncateQuery);

    if (mysqli_error($conn)) {
        // If truncation fails, provide error details
        echo "<script>
                alert('Error truncating qr_attendance table: " . mysqli_error($conn) . "');
                window.location.href = 'event_manage.php';
              </script>";
    } else {
        // If successful display an alert
        echo "<script>
                window.location.href = 'event_manage.php';
              </script>";
    }

} else {
    // Display an error message if the event_id parameter is not set
    echo "<script>
            alert('Error: Event ID not specified in the URL.');
            window.location.href = 'event_manage.php';
          </script>";
}

// Close your database connection if needed
mysqli_close($conn);
?>
