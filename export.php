<?php
session_start(); 
include 'includes/dbcon.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define an array to map original column names to new column names
$columnRenameMap = array(
    'status' => 'attendance',
    'notes' => 'onsite_remarks',
    'onsite_remarks' => 'status',
    'org' => 'company_name',
    'did' => 'phone_number',
    'country' => 'country_region',
    'diet' => 'dietary',
    'sched' => 'session',
    
);

$excludeColumns = array('id', 'event_id', 'unique_id', 'approved_by', 'office_address', 'state', 'vaccinated'); // columns you want to exclude in the excel file to export

// Get all column names in the table
$queryColumns = "SHOW COLUMNS FROM qr_attendance";
$resultColumns = mysqli_query($conn, $queryColumns);

$columnsToSelect = array();
$excelColumnNames = array(); // Store Excel column names
while ($row = mysqli_fetch_assoc($resultColumns)) {
    if (!in_array($row['Field'], $excludeColumns)) {
        $columnsToSelect[] = strtoupper($row['Field']); // to convert column names to uppercase in the excel file
        
        // Check if there's a mapping for the column name, if yes, use the new name
        $excelColumnName = isset($columnRenameMap[$row['Field']]) ? $columnRenameMap[$row['Field']] : $row['Field'];
        $excelColumnNames[] = strtoupper($excelColumnName); // Convert to uppercase if needed
    }
}

$selectedColumns = implode(', ', $columnsToSelect);

$query = "SELECT $selectedColumns FROM qr_attendance";
$result = mysqli_query($conn, $query);

// Create a file pointer for writing CSV data
$fp = fopen('exported_data.csv', 'w');

// Write CSV header with the new column names
$header = $excelColumnNames; // Use the new column names
fputcsv($fp, $header);

// Write data rows
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($fp, $row);
}

// Close the file pointer
fclose($fp);

// Check if the user is logged in
if (!isset($_SESSION['id'])) {

} else {
    // Get the current date and time
    $act_date = date('Y-m-d');
    $act_time = date('H:i:s');
    
    // Retrieve the eventCode from the database
    $sql0 = "SELECT * FROM qr_event WHERE STATUS='Active'";
    $result0 = $conn->query($sql0);
    if ($result0->num_rows > 0) {
        while ($row0 = $result0->fetch_array()) {
            $eventCode = $row0['EVENT_CODE'];
            $eventTitle = $row0['EVENT_TITLE'];
           // $act_event = $row0['id'];
        }
        $activity = "Exported file for $eventCode $eventTitle"; // Use $eventCode in the activity description
        // Prepare the SQL query to insert into qr_activity_logs
        $add_activitylogs = "INSERT INTO qr_activity_logs (username, activity, act_desc, act_date, act_time, act_qrcode, act_event) 
            VALUES ('" . $_SESSION['id'] . "', '$activity', '$activity', '$act_date', '$act_time', '-----', '-----')";
        // Execute the INSERT INTO query
        mysqli_query($conn, $add_activitylogs);
    }
}
// Download the CSV file with a custom filename
$filename = "$eventCode $eventTitle.csv";

header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"$filename\"");
readfile('exported_data.csv');

// Clean up - delete the temporary CSV file
unlink('exported_data.csv');

// Close the database connection
mysqli_close($conn);
?>
