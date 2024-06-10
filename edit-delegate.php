<?php
session_start();
$sess=session_id();
include 'includes/dbcon.php';
if ( $_SESSION[ 'id' ] ) {
	$id = $_SESSION[ 'id' ];
	$login_sql = mysqli_query( $conn, "select * from qr_users WHERE id=$id and status='1'" );
	$login_access = mysqli_fetch_array( $login_sql );
	$privuser=$login_access['username'];
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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$priv_id='';
if($_GET['id']){
$priv_det_sql = mysqli_query( $conn, "select * from ev_privileges_details WHERE session_id='$sess'");	
	if(mysqli_num_rows($priv_det_sql) > 0){
		$updatpriv_sql = "UPDATE ev_privileges_details SET updated_date =now() WHERE session_id='$sess'";
		mysqli_query($conn,$updatpriv_sql);
		$priv_id=mysqli_insert_id($conn);
	}
	else{
	$query000="insert into ev_privileges_details(module,field,view_update,username,status,updated_date,session_id)values('Delegates Manegment','','view','$privuser','1',now(),'$sess')"; 
	mysqli_query($conn,$query000);
	$priv_id=mysqli_insert_id($conn);
	}
}
$id = $_GET['id'];

$sql3 = "SELECT * FROM qr_attendance WHERE ID='".$id."'";
$result3 = $conn->query($sql3);
if ($result3->num_rows > 0) {
    while ($row3 = $result3->fetch_array()) {
?>



<form method="post" id="update-form" action="update-delegate.php?id=<?php echo md5($row3['id']); ?>">
<input type="hidden" name="id" id="id" value="<?php echo $row3['id']; ?>">
	<input type="hidden" name="priv_id" value="<?php echo $priv_id;?>">
     <div class="row">
        <div class="col-sm-12">
            <input type="text" class="form-control" id="qrcode" name="qrcode" value="<?php echo $row3['qrcode']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">QR Code</small>
        </div>
    </div>  

    <div class="row">
        <div class="col-sm-3">
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $row3['firstname']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">First Name</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row3['lastname']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Last Name</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="badge_name" name="badge_name" value="<?php echo $row3['badge_name']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Badge Name</small>
        </div>

         <div class="col-sm-3">
            <input type="text" class="form-control" id="job_title" name="job_title" value="<?php echo $row3['job_title']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Job Title</small>
        </div>

        

    </div> 

   

    <div class="row">

    <div class="col-sm-3">
                                                        <select class="form-control" id="job_category" name="job_category" required>
                                                            <option value="<?php echo $row3['job_category']; ?>"><?php echo $row3['job_category']; ?></option>
                                                            <option value="C-level">C-level</option>
                                                            <option value="D-level & HOD">D-level & HOD</option>
                                                            <option value="Deputy D & HOD">Deputy D & HOD</option>
                                                            <option value="Managerial">Managerial</option>
                                                        </select>
                                                        <small id="name" class="form-text text-muted mb-3">Job Category</small>      
                                                    </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="org" name="org" value="<?php echo $row3['org']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Company Name</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="de" name="de" value="<?php echo $row3['de']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Assigned DE</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="past_new_de" name="past_new_de" value="<?php echo $row3['past_new_de']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Past/New Delegate</small>
        </div>

       

    </div>  

    <div class="row">

    <div class="col-sm-3">
            <select class="form-control" id="wishlist" name="wishlist" required>
                <option value="<?php echo $row3['wishlist']; ?>"><?php echo $row3['wishlist']; ?></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <small id="name" class="form-text text-muted mb-3">Wishlist</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="agency_count" name="agency_count" value="<?php echo $row3['agency_count']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Agency count</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="de_to_call" name="de_to_call" value="<?php echo $row3['de_to_call']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">DE to call on</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="reminder_call1" name="reminder_call1" value="<?php echo $row3['reminder_call1']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Reminder calls 1</small>
        </div>

       

    </div>

    <div class="row">

    <div class="col-sm-3">
            <input type="text" class="form-control" id="reminder_call2" name="reminder_call2" value="<?php echo $row3['reminder_call2']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Reminder calls 2</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="polling_no" name="polling_no" value="<?php echo $row3['polling_no']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Polling No</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="lanyard" name="lanyard" value="<?php echo $row3['lanyard']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Lanyard</small>
        </div>

         <div class="col-sm-3">
            <input type="text" class="form-control" id="did" name="did" value="<?php echo $row3['did']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Phone Number</small>
        </div>

        

    </div>


    <div class="row">

    <div class="col-sm-3">
            <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $row3['mobile']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Mobile Number</small>
        </div>
        
        <div class="col-sm-3">
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $row3['email']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Email</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="alt_email" name="alt_email" value="<?php echo $row3['alt_email']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Alternate Email</small>
        </div>


        <div class="col-sm-3">
            <input type="text" class="form-control" id="street" name="street" value="<?php echo $row3['street']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Street Address</small>
        </div>

        

    </div> 


    <div class="row">
        
    <div class="col-sm-3">
            <input type="text" class="form-control" id="city" name="city" value="<?php echo $row3['city']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">City</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo $row3['postal_code']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Postal Code</small>
        </div>


        <div class="col-sm-3">
            <select class="form-control" id="country" name="country">
                <option value="<?php echo $row3['country']; ?>" selected><?php echo $row3['country']; ?></option>
                    <?php
                        $sql = "SELECT country_name FROM qr_country ORDER BY country_name DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                            echo '<option>' . $row['country_name'] . '</option>';
                            }
                        }
                    ?>
                </select>
                    <small id="name" class="form-text text-muted mb-3">Country/Region</small>
            </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="diet" name="diet" value="<?php echo $row3['diet']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Dietary </small>
        </div>

        

    </div> 


     <div class="row">

     <div class="col-sm-3">
            <input type="text" class="form-control" id="parking" name="parking" value="<?php echo $row3['parking']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Parking</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="grouping" name="grouping" value="<?php echo $row3['grouping']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Grouping</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="sched" name="sched" value="<?php echo $row3['sched']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Session</small>
        </div>

        <div class="col-sm-3">
            <input type="text" class="form-control" id="roe" name="roe" value="<?php echo $row3['roe']; ?>" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">ROE</small>
        </div>

        
    </div> 

        <div class="row">

       


          <div class="col-sm-3">
                <select class="form-control" id="status" name="status">
                    <option <?php if(empty($row3['status'])){echo "selected";} ?>></option>
					<?php if($login_access['role']=='2'){?>
                    <option <?php if($row3['status']=='YES'){echo "selected";} ?> >YES</option>
					<?php } else if($login_access['role']=='3'){ ?>
                    <option <?php if($row3['status']=='DROPPED'){echo "selected";} ?>>DROPPED</option>
					<?php }else if($login_access['role']=='1' || $login_access['role']=='4'){?>
					<option <?php if($row3['status']=='YES'){echo "selected";} ?> >YES</option>
					<option <?php if($row3['status']=='DROPPED'){echo "selected";} ?>>DROPPED</option>
					<?php } ?>
                </select>
                <small class="form-text text-muted">Attendance</small>
            </div>

        <div class="col-sm-3">
            <select class="form-control" id="remarks" name="remarks">
                <option value="<?php echo $row3['onsite_remarks']; ?>"><?php echo $row3['onsite_remarks']; ?></option>
                <option <?php if($row3['onsite_remarks']=='REPLACEMENT'){echo "selected";} ?> value="REPLACEMENT" >REPLACEMENT</option>
                <option <?php if($row3['onsite_remarks']=='ATTENDED'){echo "selected";} ?> value="ATTENDED">ATTENDED</option>
                <option <?php if($row3['onsite_remarks']=='ARRIVED'){echo "selected";} ?> value="ARRIVED">ARRIVED</option>
                <option <?php if($row3['onsite_remarks']=='OTW'){echo "selected";} ?> value="OTW">OTW</option>
                <option <?php if($row3['onsite_remarks']=='NO ANSWER'){echo "selected";} ?> value="NO ANSWER">NO ANSWER</option>
                <option <?php if($row3['onsite_remarks']=='LATE'){echo "selected";} ?> value="LATE">LATE</option>
                <option <?php if($row3['onsite_remarks']=='NOT ATTENDING'){echo "selected";} ?> value="NOT ATTENDING">NOT ATTENDING</option>
                <option <?php if($row3['onsite_remarks']=='NEW'){echo "selected";} ?> value="NEW">NEW</option>
                <option <?php if(empty($row3['onsite_remarks'])){echo "selected";} ?> value=""></option>
            </select>
            <small id="" class="form-text text-muted">Status</small>
        </div>


        <div class="col-sm-3">
            <textarea class="form-control" rows="2"  id="notes" name="notes" oninput="checkLength(this)" maxlength="100" placeholder="Text Here..."><?php echo $row3['notes']; ?></textarea>
            <p class="charCount"><span id="charCount">0</span> / 100 characters</p>
            <small id="name" class="form-text text-muted mb-3">Onsite Remarks</small>
        </div>

        </div>
    </div>

                                    <!-- SCRIPT TO CHECK MAXIMUM CHARACTERS BY HEATHER MAY 08 2024 -->
                                    <script>
                                        function checkLength(textarea) {
                                                var maxLength = 100;
                                                var currentLength = textarea.value.length;
                                                var charCountSpan = document.getElementById('charCount');
                                                
                                                if (currentLength >= maxLength) {
                                                    alert("Maximum length of " + maxLength + " characters reached!");
                                                }
                                                
                                                charCountSpan.textContent = currentLength;
                                            }
                                        </script>

                                        <!--- END -->


    <script>
  window.onload = function() {
    const attendanceDropdown = document.getElementById("status");
    const remarksDropdown = document.getElementById("remarks");

    // Function to set remarks based on attendance value
    function updateRemarks() {
      if (attendanceDropdown.value === "DROPPED") {
        remarksDropdown.value = "NOT ATTENDING";
      } else if (attendanceDropdown.value === "YES") {
        remarksDropdown.value = "ATTENDED";
      }
    }

    // Event listener for the change event
    attendanceDropdown.addEventListener("change", updateRemarks);

    // Call the updateRemarks function on page load
    updateRemarks();
  };
</script>





    <div class="row" style="visibility: hidden;">
    <div class="col-sm-6">
            <input type="text" class="form-control" id="active_user" name="active_user" value="<?php echo $_SESSION['id']?>" aria-describedby="name">
           
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


    <!-- FORM VALIDATION  -->
  <script>
    window.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('update-form');
      var textboxes = form.getElementsByTagName('input');
      
      for (var i = 0; i < textboxes.length; i++) {
        textboxes[i].addEventListener('input', function(e) {
          var inputValue = e.target.value;
          var sanitizedValue = inputValue.replace(/['";;]/g, '');
          e.target.value = sanitizedValue;
        });
        
        var currentValue = textboxes[i].value;
        var sanitizedCurrentValue = currentValue.replace(/['";]/g, '');
        textboxes[i].value = sanitizedCurrentValue;
      }
    });
  </script>
                     
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