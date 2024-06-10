<!DOCTYPE html>
<html dir="ltr" lang="en">


<?php
include 'includes/dbcon.php' ;
//$username = $_SESSION['username'];
//$userid = $_SESSION['id'];
?>


<?php include 'includes/head.php';?>

<script type="text/javascript">
    window.onload = function() {
  var statusField = document.getElementById("status");
  var remarksField = document.getElementById("remarks");

  if (statusField.value === "YES") {
    remarksField.value = "ATTENDED";
    remarksField.disabled = true;
  } else if (statusField.value === "DROPPED") {
    remarksField.value = "NOT ATTENDING";
    remarksField.disabled = true;
  }
};

</script>


<body>
   
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
                                <h4 class="card-title">Update Delegates Details</h4>
                                 <!-- <small class="form-text text-muted mb-3">*This table displays all scanned attendees with <b>VALID</b> QR codes</small><br>-->
                                
                               

                                
        <?php include 'includes/dbcon.php';?>                        
<?php
$id = $_GET['id'];

$sql3 = "SELECT * FROM qr_attendance WHERE ID='".$id."'";
$result3 = $conn->query($sql3);
if ($result3->num_rows > 0) {
    while ($row3 = $result3->fetch_array()) {
?>



<form method="post" action="update-delegate.php?id=<?php echo md5($row3['id']); ?>">
    <input type="hidden" name="id" id="id" value="<?php echo $row3['id']; ?>">

     <div class="row">
        <div class="col-sm-12">
            <input type="text" class="form-control" id="firstname" value="<?php echo $row3['qrcode']; ?>" aria-describedby="name" disabled>
            <small id="name" class="form-text text-muted mb-3">QR Code</small>
        </div>
    </div>  

    <div class="row">
        <div class="col-sm-2">
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $row3['firstname']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">First Name</small>
        </div>

        <div class="col-sm-2">
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row3['lastname']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Last Name</small>
        </div>

        <div class="col-sm-2">
            <input type="text" class="form-control" id="badge_name" name="badge_name" value="<?php echo $row3['badge_name']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Badge Name</small>
        </div>

         <div class="col-sm-2">
            <input type="text" class="form-control" id="job_title" name="job_title" value="<?php echo $row3['job_title']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Job Title</small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="org" name="org" value="<?php echo $row3['org']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Organisation</small>
        </div>

    </div> 

   

    <div class="row">
        <div class="col-sm-3">
            <input type="text" class="form-control" id="de" name="de" value="<?php echo $row3['de']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Assigned DE</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="past_new_de" name="past_new_de" value="<?php echo $row3['past_new_de']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Past/New Delegate</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="agency_count" name="agency_count" value="<?php echo $row3['agency_count']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Agency count</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="de_to_call" name="de_to_call" value="<?php echo $row3['de_to_call']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">DE to call on</small>
        </div>

    </div>  

    <div class="row">

        <div class="col-sm-3">
            <input type="text" class="form-control" id="reminder_call1" name="reminder_call1" value="<?php echo $row3['reminder_call1']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Reminder calls (1)</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="reminder_call2" name="reminder_call2" value="<?php echo $row3['reminder_call2']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Reminder calls (2)</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="polling_no" name="polling_no" value="<?php echo $row3['polling_no']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Polling Number2</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="lanyard" name="lanyard" value="<?php echo $row3['lanyard']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Lanyard</small>
        </div>

         <div class="col-sm-3">
            <input type="text" class="form-control" id="did" name="did" value="<?php echo $row3['did']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">DID</small>
        </div>


        



    </div>


    <div class="row">
        <div class="col-sm-4">
            <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $row3['mobile']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Mobile</small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $row3['email']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Email</small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="alt_email" name="alt_email" value="<?php echo $row3['alt_email']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Alternate Email</small>
        </div>

    </div> 



    <div class="row">
        <div class="col-sm-4">
            <input type="text" class="form-control" id="office_address" name="office_address" value="<?php echo $row3['office_address']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Office Address</small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="diet" name="diet" value="<?php echo $row3['diet']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Dietary </small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="parking" name="parking" value="<?php echo $row3['parking']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Parking</small>
        </div>

    </div> 


     <div class="row">
        <div class="col-sm-4">
            <input type="text" class="form-control" id="grouping" name="grouping" value="<?php echo $row3['grouping']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Grouping</small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="sched" name="sched" value="<?php echo $row3['sched']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Session</small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="vaccinated" name="vaccinated" value="<?php echo $row3['vaccinated']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Vaccinated</small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="roe" name="roe" value="<?php echo $row3['roe']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">ROE</small>
        </div>
      

    </div> 



     <div class="form-group mb-4">
        <div class="row">
          <div class="col-sm-4">
                <small class="form-text text-muted">Attendance</small>
                <select class="form-control" id="status" name="status">
                <option><?php echo $row3['status']; ?></option>
                    <option value="" disabled selected>[Please Select]</option>
                    <option></option>
                    <option>YES</option>
                    <option>DROPPED</option>
                </select>
            </div>

        <div class="col-sm-4">
            <small id="" class="form-text text-muted">Status</small>
            <select class="form-control" id="remarks" name="remarks">
            <option><?php echo $row3['onsite_remarks']; ?></option>
                <option value="" disabled selected>[Please Select]</option>
                <option>REPLACEMENT</option>
                <option>ATTENDED</option>
                <option>ARRIVED</option>
                <option>OTW</option>
                <option>NO ANSWER</option>
                <option>LATE</option>
                <option>NOT ATTENDING</option>
                <option>NEW</option>
            </select>
        </div>


        <div class="col-sm-4">
            <textarea class="form-control" rows="2"  id="notes" name="notes" placeholder="Text Here..."><?php echo $row3['notes']; ?></textarea>
            <small id="name" class="form-text text-muted mb-3">Additional Remarks </small>
        </div>

        </div>
    </div>

  
                                   <script>
                                      const attendanceDropdown = document.getElementById("status");
                                      const remarksDropdown = document.getElementById("remarks");

                                      attendanceDropdown.addEventListener("change", function() {
                                        if (attendanceDropdown.value === "DROPPED") {
                                          remarksDropdown.value = "NOT ATTENDING";
                                          remarksDropdown.disabled = false;
                                        } else if (attendanceDropdown.value === "YES") {
                                          remarksDropdown.value = "ATTENDED";
                                          remarksDropdown.disabled = false;
                                        } else {
                                          remarksDropdown.disabled = false;
                                        }
                                      });
                                    </script>













    <div class="row" style="visibility: hidden;">
    <div class="col-sm-6">
            <input type="text" class="form-control" id="active_user" name="active_user" value="<?php echo $_SESSION['username']?>" aria-describedby="name">
           
        </div>
    </div>



    <div class="modal-footer">
        <a href="dashboard.php" class="btn btn-light">Go Back</a>
        <button type="submit" name="submit" id="submit" class="btn btn-primary">Save changes</button>

    </div>
</form>

<?php
    }
} else {
    echo "<center><p>No Records</p></center>";
}
?>




                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
           
            <?php include 'includes/footer.php';?>


            
        </div>
    </div>



                     
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>

    <!--Tables -->
    <script src="assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/pages/datatable/datatable-basic.init.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
 

</body>
</html>