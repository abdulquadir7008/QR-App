<?php

// Set error reporting level to display all errors

//error_reporting(E_ALL);

//ini_set('display_errors', 1);
 
//echo $undefined_variable; 
?>
<?php

session_start();
include 'includes/dbcon.php';

if ($_SESSION['id']) {
    $id = $_SESSION['id'];
    $login_sql = mysqli_query($conn, "SELECT * FROM qr_users WHERE id=$id AND status='1'");
    $login_access = mysqli_fetch_array($login_sql);

    
    if (isset($_REQUEST['event_submit'])) {
      $event_code = $_REQUEST['event_code'];
      $event_title = $_REQUEST['event_title'];
      $event_venue = $_REQUEST['event_venue'];
      $event_date = $_REQUEST['event_date'];
      $event_start = $_REQUEST['event_start'];
      $event_time = $_REQUEST['event_time'];
      $status = $_REQUEST['status'];

      if ($status === 'Completed') {
        // Redirect to transfer.php
        header("Location: transfer.php");
        exit();
    }

    if ($status === 'Inactive') {
      // Proceed with the INSERT INTO query
      $query = "INSERT INTO qr_event (EVENT_CODE, EVENT_TITLE, EVENT_VENUE, EVENT_DATE, EVENT_START, EVENT_END, STATUS) VALUES ('$event_code', '$event_title', '$event_venue', '$event_date', '$event_start', '$event_time', '$status')";
  
      if (mysqli_query($conn, $query)) {
          $errmsg_arr[] = '<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Success!</strong> Data added successfully.</div>';
      } else {
          die('Error inserting new event: ' . mysqli_error($conn));
      }
  }
  

    if ($status === 'Active') {
      // Check if there is an active event
      $activeEventQuery = "SELECT COUNT(*) AS activeEventCount FROM qr_event WHERE STATUS = 'Active'";
      $activeEventResult = mysqli_query($conn, $activeEventQuery);
      $activeEventData = mysqli_fetch_assoc($activeEventResult);
      $activeEventCount = $activeEventData['activeEventCount'];
  
      if ($activeEventCount > 0) {
          // There is an active event, display an alert message using JavaScript
          echo '<script>alert("Error: There is an active event.");</script>';
      } else {
          // No active event, proceed with the INSERT INTO query
          $query = "INSERT INTO qr_event (EVENT_CODE, EVENT_TITLE, EVENT_VENUE, EVENT_DATE, EVENT_START, EVENT_END, STATUS) VALUES ('$event_code', '$event_title', '$event_venue', '$event_date', '$event_start', '$event_time', '$status')";
          
          if (mysqli_query($conn, $query)) {
              $errmsg_arr[] = '<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Success!</strong> Data added successfully.</div>';
          } else {
              die('Error inserting new event: ' . mysqli_error($conn));
          }
      }
  }
  
  // No need to close the database connection here, as it's included from dbcon.php
  
  $_SESSION['register_success'] = $errmsg_arr;
  session_write_close();
  }

  else if(isset($_REQUEST['event_update'])){
    // Check if there is any row with STATUS = 'Active'
    $event_id = $_REQUEST['event_id'];
    $activeCount = 0;
    
    if ($status = 'Active')
      {
    $checkQuery = "SELECT COUNT(*) as activeCount FROM qr_event WHERE STATUS='Active' AND ID <> $event_id";
    $checkResult = mysqli_query($conn, $checkQuery);
    $checkData = mysqli_fetch_assoc($checkResult);
    $activeCount = $checkData['activeCount'];
      }
      
    if ($activeCount > 0) {
        // If there is an 'Active' row, show an alert using JavaScript
        echo '<script>alert("ERROR: There is already an active event. You may want to deactivate it before updating another event.");</script>';
    } else {
        // If no active events, proceed with the update
        $event_code = $_REQUEST['event_code'];
        $event_title = $_REQUEST['event_title'];
        $event_venue = $_REQUEST['event_venue'];
        $event_date = $_REQUEST['event_date'];
        $event_start = $_REQUEST['event_start'];
        $event_time = $_REQUEST['event_time'];
        $status = $_REQUEST['status'];
        //$event_id = $_REQUEST['event_id'];
        $query000 = "update qr_event SET EVENT_CODE='$event_code', EVENT_TITLE='$event_title',EVENT_VENUE='$event_venue',EVENT_DATE='$event_date',EVENT_START='$event_start',EVENT_END='$event_time',STATUS='$status' WHERE ID=$event_id";
        mysqli_query($conn, $query000);
        
        // Display a success message using JavaScript alert
        echo '<script>alert("Success: Event added successfully.");</script>';
    }
}


	else if(isset($_REQUEST['del']))
{
 //TO DELETE
//echo $job_id=$_REQUEST['del'];
//$query="delete from qr_event WHERE ID=$job_id";
//mysqli_query($conn,$query);		
//$errmsg_arr = array();
//$errflag = false;
//$errmsg_arr[] = '<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> <strong>Success ! </strong>Record Delete successfully.</div>';
//$errflag = true;
//$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
//session_write_close();
//header( 'Location: ' . $_SERVER[ 'HTTP_REFERER' ] );
//ob_end_flush();


echo $job_id=$_REQUEST['del'];
$query="update qr_event SET STATUS='Deactivated' WHERE  ID=$job_id";
mysqli_query($conn,$query);   
$errmsg_arr = array();
$errflag = false;
$errmsg_arr[] = '<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> <strong>Success ! </strong>Event Deactivated.</div>';
$errflag = true;
$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
session_write_close();
header( 'Location: ' . $_SERVER[ 'HTTP_REFERER' ] );
ob_end_flush();

}
}
else{
	echo '<script type="text/javascript">
           window.location = "'.$domain_url.'index.php"
     </script>';
		unset($_SESSION['id']);
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include 'includes/head.php';?>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
   
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        
        <?php include('includes/header.php');?>
      
        <?php 
		include('logout-modal.php'); 
		include('includes/sidebar.php');
		?>
        




        <div class="page-wrapper">
             
            <div class="container-fluid">
                
               


                 <!-- QR SCANNER --->   
                <!---- <div class="col-lg-5 col-md-12" style="padding: 0px;margin: 0px;">
                       <iframe src="qr-scanner.php" height="620px" width="100%" title="QR Scanner" style="border:none;padding: 0px;margin: 0px;"scrolling="no"></iframe>
                    </div>
                </div> -->


                <!-- multi-column ordering -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">Event List</h4>
                                        <small class="form-text text-muted mb-3">*This table displays all <b>Events</b> </small><br>
                                    </div>
                                        <div class="col-6">
                                           
                                            <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addModal" style="float: right;"><i class="fas fa-plus"></i> Add Delegate</button> -->

                                            <a type="button" class="btn btn-info btn-sm" href="event-form.php" style="float: right;"><i class="fas fa-plus"></i> Add Event</a>

                                           

                                        </div>
                                    </div>

                                    


                                     <div class="table-responsive">

                                  <?php
                                  include 'includes/dbcon.php';
                                  ?>

                             


                                  <input type="text" id="search-input" class="form-control" placeholder="Search" style="float: right;width: 300px;">

                               
<style type="text/css">
   .wrapper1, .wrapper2 {
  width: 300px;
  overflow-x: scroll;
  overflow-y:hidden;
}

.wrapper1 {height: 20px; }
.wrapper2 {height: 200px; }

.div1 {
  width:1000px;
  height: 20px;
}

.div2 {
  width:1000px;
  height: 200px;
  background-color: #88FF88;
  overflow: auto;
}
table{
  border: 1px solid #f5f5f5;
  border-top-left-radius: 25px;
  border-top-right-radius: 25px;
}
thead{
position: sticky;
  top: 0;
  background-color: #0B4596;
  color: #fff;
  font-size: 12px;
  margin:10px;
  width: auto;
}

th{
padding:5px;
text-align: center;
}

td{
  color: #333;
  font-size: 12px;
  text-align: center;
  padding:10px;
  border-right: 1px solid #f5f5f5;
  border-bottom: 1px solid #f5f5f5;

}
tr:not(:first-child):hover{
  background: #f5f5f5;
  transition: background-color 0.2s ease;
}
table tr {
  counter-increment: row-num;
 
}
table tr td:first-child::before {
    content: counter(row-num) " ";

}

th:first-child, td:first-child {
  position: sticky;
  left: 0;
  background-color: #0B4596;
  color: #fff;
   border-bottom: none;
}
tr{
  cursor: pointer;
}
.selected-row{
  background-color: #f5f5f5;
  font-weight: bold;
  color: #fff;
}

</style>
 <script>
            
            function selectedRow(){
                
                var index,
                    table = document.getElementById("multi_col_order");
            
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         // remove the background from the previous selected row
                        if(typeof index !== "undefined"){
                           table.rows[index].classList.toggle("selected-row");
                        }
                        console.log(typeof index);
                        // get the selected row index
                        index = this.rowIndex;
                        // add class selected to the row
                        this.classList.toggle("selected-row");
                        console.log(typeof index);
                     };
                }
                
            }
            selectedRow();
        </script>
                             <?php include 'includes/dbcon.php';?>

<br><br>
<div onscroll='scroller("scroller", "scrollme")' style="" id=scroller>
  <!-- <img src="" height=1 width=2066 style="width:2066px;" -->
  <img src="" height="1">
</div>


<div onscroll='scroller("scrollme", "scroller")' id="scrollme">
  <table id="multi_col_order" width="100%">
     <thead>
                                        <th>#</th>
                                        <th>EVENT CODE</th>
                                        <th>EVENT TITLE</th>
                                        <th>EVENT VENUE</th>
		 								<th>EVENT DATE</th>
		 								<th>EVENT START</th>
		 								<th>EVENT END</th>
		 								<th>STATUS</th>
                                        <th>ACTION</th>
                   </thead>


   <tbody>
  <?php
  $sql2 = "SELECT * FROM qr_event ORDER BY STATUS DESC";
  $result2 = $conn->query($sql2);

  if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_array()) {
      $eventStatus = $row2['STATUS'];
      ?>
      <tr>
        <td></td>
        <td id="status"><?php echo $row2['EVENT_CODE']; ?></td>
        <td id="status"><?php echo $row2['EVENT_TITLE']; ?></td>
        <td id="status"><?php echo $row2['EVENT_VENUE']; ?></td>
        <td id="status"><?php echo date("M d Y", strtotime($row2['EVENT_DATE'])); ?></td>
        <td id="status"><?php echo date("h:i A", strtotime($row2['EVENT_START'])); ?></td>
        <td id="status"><?php echo date("h:i A", strtotime($row2['EVENT_END'])); ?> </td>
        <td id="eventstatus"><?php echo $eventStatus; ?></td>
        <td id="status">
          <a href="event-form.php?event_id=<?php echo $row2['ID']; ?>" class="btn btn-info btn-sm">Edit</a>
          
          <?php if ($eventStatus != 'Completed') { ?>
            <a href="transfer.php?event_id=<?php echo $row2['ID']; ?>" id="btn-complete" class="btn btn-dark btn-sm">Mark Complete</a>
          <?php } ?>
          
          <?php if ($eventStatus == 'Completed') { ?>
            <a href="export-selected-event.php?event_id=<?php echo $row2['ID']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to export this event?');">Export</a>
          <?php } ?>

          <a href="event_manage.php?del=<?php echo $row2['ID']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Do you really want to remove it?')">Delete</a>
        </td>

      </tr>
      <?php
    }
  } else {
    echo "<center><p> No Records</p></center>";
  }
  
  $conn->close();
  ?>
</tbody>


<style>
  #multi_col_order tbody tr:first-child {
    background-color: #d2f8d2;
  }
</style>

  </table>

</div>


  <script>
    var arescrolling = 0;
function scroller(from,to) {
  if (arescrolling) return; // avoid potential recursion/inefficiency
  arescrolling = 1;
  // set the other div's scroll position equal to ours
  document.getElementById(to).scrollLeft =
    document.getElementById(from).scrollLeft;
  arescrolling = 0;
}
  </script>




                    </div>

                                    


                            </div>
                        </div>
                    </div>
                </div>


                      
                
            </div>
            



            <?php include 'includes/footer.php';?>


            
        </div>
    </div>

           
   
    <!-- <script src="assets/libs/jquery/dist/jquery.min.js"></script> -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>


    <!--Tables -->

    <!-- <script src="assets/libs/double-scroll/double-scrollbar.js"></script> -->
 <!-- <script src="assets/libs/double-scroll/double-scroll-table.js"></script> -->



    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>

</body>
</html>