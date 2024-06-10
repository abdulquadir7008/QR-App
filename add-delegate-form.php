<?php
session_start();
include 'includes/dbcon.php' ; 
if ( $_SESSION[ 'id' ] ) {
	$id = $_SESSION[ 'id' ];
	$login_sql = mysqli_query( $conn, "select * from qr_users WHERE id=$id and status='1'" );
	$login_access = mysqli_fetch_array( $login_sql );
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
                                <h4 class="card-title">Add Delegate Details</h4>
                                 <!-- <small class="form-text text-muted mb-3">*This table displays all scanned attendees with <b>VALID</b> QR codes</small><br>-->

                                <form method="post" id="add-delegate-form" onsubmit="return validateForm()" action="add-delegate.php">
                                                

                                                     <div class="row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="qrcode" name="qrcode" required aria-describedby="name" >
                                                            <small id="name" class="form-text text-muted mb-3">QR Code*</small>
                                                        </div>
                                                    </div>  

                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="name" required>
                                                            <small id="name" class="form-text text-muted mb-3">First Name*</small>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="lastname" name="lastname" required aria-describedby="name">
                                                            <small id="name" class="form-text text-muted mb-3">Last Name*</small>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="badge_name" name="badge_name" required aria-describedby="name">
                                                            <small id="name" class="form-text text-muted mb-3">Badge Name*</small>
                                                        </div>

                                                         <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="job_title" required name="job_title" aria-describedby="name">
                                                            <small id="name" class="form-text text-muted mb-3">Job Title*</small>
                                                        </div>

                                                        

                                                    </div> 

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <select class="form-control" id="job_category" name="job_category" required>
                                                            <option value="" disabled>[Please Select]</option>
                                                            <option value="C-level">C-level</option>
                                                            <option value="D-level & HOD">D-level & HOD</option>
                                                            <option value="Deputy D & HOD">Deputy D & HOD</option>
                                                            <option value="Managerial">Managerial</option>
                                                        </select>
                                                        <small id="name" class="form-text text-muted mb-3">Job Category</small>      
                                                    </div>

                                                    <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="org" name="org" aria-describedby="name">
                                                            <small id="name" class="form-text text-muted mb-3">Company Name</small>
                                                        </div>

                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="de" name="de" aria-describedby="name">
                                                        <small id="name" class="form-text text-muted mb-3">Assigned DE</small>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="past_new_de" name="past_new_de" aria-describedby="name">
                                                        <small id="name" class="form-text text-muted mb-3">Past/New Delegate</small>
                                                    </div>

                                                </div>

                                                <div class="row">
                                               
                                                    <div class="col-sm-3">
                                                        <select class="form-control" id="wishlist" name="wishlist" required>
                                                            <option value="" disabled >[Please Select]</option>
                                                            <option>Yes</option>
                                                            <option>No</option>
                                                        </select>
                                                        <small id="name" class="form-text text-muted mb-3">Wishlist</small>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="agency_count" name="agency_count" aria-describedby="name">
                                                        <small id="name" class="form-text text-muted mb-3">Agency count</small>
                                                    </div>

                                            <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="de_to_call" name="de_to_call" aria-describedby="name">
                                                        <small id="name" class="form-text text-muted mb-3">DE to call on</small>
                                                    </div>


                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="reminder_call1" name="reminder_call1" aria-describedby="name">
                                                    <small id="name" class="form-text text-muted mb-3">Reminder calls 1</small>
                                                </div>

                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="reminder_call2" name="reminder_call2" aria-describedby="name">
                                                    <small id="name" class="form-text text-muted mb-3">Reminder calls 2</small>
                                                </div>

                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="polling_no" name="polling_no" aria-describedby="name">
                                                    <small id="name" class="form-text text-muted mb-3">Polling No</small>
                                                </div>

                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="lanyard" name="lanyard" aria-describedby="name">
                                                    <small id="name" class="form-text text-muted mb-3">Lanyard</small>
                                                </div>

                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="did" name="did"aria-describedby="name">
                                                    <small id="name" class="form-text text-muted mb-3">Phone Number</small>
                                                </div>

                                                    
                                                </div>  

                                            <div class="row">


                                                <div class="col-sm-3">
                                                <input type="text" class="form-control" id="mobile" name="mobile" required aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Mobile Number*</small>
                                            </div>

                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="email" name="email" required aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Email*</small>
                                            </div>

                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="alt_email" name="alt_email" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Alternate Email</small>
                                            </div>

                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="street" name="street" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Street Address</small>
                                            </div>


                                        </div>
                                       

                                        <div class="row">
                                        
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="city" name="city" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">City</small>
                                            </div>

                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="postal_code" name="postal_code" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Postal Code</small>
                                            </div>


                                            <div class="col-sm-3">
                                                <select class="form-control" id="country" name="country">
                                                    <option value="" disabled selected>[Please Select]</option>
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
                                                <input type="text" class="form-control" id="diet" name="diet" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Dietary </small>
                                            </div>

                                        </div> 



                                        <div class="row">

                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="parking" name="parking" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Parking</small>
                                            </div>

                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="grouping" name="grouping" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Grouping</small>
                                            </div>

                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="sched" name="sched" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Session</small>
                                            </div>


                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="roe" name="roe" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">ROE</small>
                                            </div>

                                            <div class="col-sm-3">
                                                
                                                <select class="form-control" id="status" name="status">
                                                    <option value="" disabled>[Please Select]</option>
                                                    <option value=""></option>
                                                    <option value="YES">YES</option>
                                                    <option value="DROPPED">DROPPED</option>
                                                </select>
                                                <small class="form-text text-muted">Attendance</small>
                                            </div>

                                            <div class="col-sm-3">
                                            <select class="form-control" id="remarks1" name="remarks1">
                                                <option value="" disabled>[Please Select]</option>
                                                <option value="REPLACEMENT">REPLACEMENT</option>
                                                <option value="ATTENDED">ATTENDED</option>
                                                <option value="ARRIVED">ARRIVED</option>
                                                <option value="OTW">OTW</option>
                                                <option value="NO ANSWER">NO ANSWER</option>
                                                <option value="LATE">LATE</option>
                                                <option value="NOT ATTENDING">NOT ATTENDING</option>
                                                <option value="NEW" selected>NEW</option>
                                            </select>
                                            <small id="" class="form-text text-muted">Status</small>
                                        </div>

                                        <div class="col-sm-3">
                                            <textarea class="form-control" rows="2"  id="notes" name="notes" oninput="checkLength(this)" maxlength="100" placeholder="Text Here..."></textarea>
                                            <p class="charCount"><span id="charCount">0</span> / 100 characters</p>
                                            <small id="name" class="form-text text-muted mb-3">Onsite Remarks</small>
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
                                      const attendanceDropdown = document.getElementById("status");
                                      const remarksDropdown = document.getElementById("remarks1");

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

                                        <div class="modal-footer">
                                                <a href="dashboard.php" type="button" class="btn btn-light">Back</a>
                                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Save changes</button>
                                            </div>

                                    <div class="row" style="visibility: hidden;">
                                    <div class="col-sm-2">
                                    <label>active user</label>
                                            <input type="text" class="form-control" id="active_user" name="active_user" value="<?php echo $login_access['id'];?>" aria-describedby="name">


<?php
$sql0 = "SELECT * FROM qr_event WHERE STATUS='Active'";
$result0 = $conn->query($sql0);
if ($result0->num_rows > 0) {
    while ($row0 = $result0->fetch_array()) {
        $eventCode = $row0['EVENT_CODE'];
        $eventID = $row0['ID'];
        $eventTitle = $row0['EVENT_TITLE'];
        $eventVenue = $row0['EVENT_VENUE'];
        $eventDate = $row0['EVENT_DATE'];

        $eventCode = strlen($eventCode) > 6 ? substr($eventCode, 0, 6) : $eventCode;
        $eventTitle = strlen($eventTitle) > 50 ? substr($eventTitle, 0, 50) : $eventTitle;
        $eventVenue = strlen($eventVenue) > 50 ? substr($eventVenue, 0, 50) : $eventVenue;
        $eventDate = strlen($eventDate) > 50 ? str_replace('-', '', substr($eventDate, 0, 40)) : $eventDate;
        $eventDate = str_replace('-', '', $eventDate);

        $currentTime = date('His'); 
?>
</div>
<div class="col-sm-2">
        <label>unique id</label>
        <input type="text" id="unique" class="form-control" name="unique" value="<?php echo $eventCode .'I'. $eventDate . $currentTime; ?>" aria-describedby="name">
    </div>
    
    <div class="col-sm-2">
        <label>event id</label>
        <input type="text" id="eventID" class="form-control" name="eventID" value="<?php echo $eventID ?>" aria-describedby="name">
    </div>

<?php
    }
} else {
    echo "<center><p>No Records</p></center>";
}
?>




<?php
$id = $_SESSION[ 'id' ];
$sql02 = "SELECT * FROM qr_users WHERE id='$id'";
$result02 = $conn->query($sql02);
if ($result02->num_rows > 0) {
    while ($row02 = $result02->fetch_array()) {
        $role = $row02['role'];
        
?>
 <div class="col-sm-2">
        <label>user status</label>
        <input type="text" id="userstatus" class="form-control" name="userstatus" value="<?php echo $role ?>" aria-describedby="name">
    </div>
<?php
    }
} else {
    echo "<center><p>No Records</p></center>";
}
?>

                                           
                                        </div>

                                    </div>

                                    </div>
                                           

                                </form>





                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
           
            <?php include 'includes/footer.php';?>


            
        </div>
    </div>

     <!--  NOT TO ACCEPT SPECIAL CHARCATERS VALIDATION   -->
    <script>
    $(document).ready(function() {
      // Function to prevent special characters
      function preventSpecialCharacters(inputId) {
        $(inputId).on('input', function() {
          var inputValue = $(this).val();
          // Replace special characters with an empty string
          var sanitizedValue = inputValue.replace(/[^\w\s]/gi, '');

          // If the input value changed, show an alert
          if (inputValue !== sanitizedValue) {
            alert('Special characters are not allowed!');
          }

          // Update the input value without special characters
          $(this).val(sanitizedValue);
        });
      }

      // Apply the function to the specified input fields
      preventSpecialCharacters('#lastname');
      preventSpecialCharacters('#firstname');
      preventSpecialCharacters('#badge_name');
      preventSpecialCharacters('#de');
    });
  </script>


 <!-- REQUIRED VALIDATION  -->
    <script>
  function validateForm() {
    var form = document.getElementById("add-delegate-form");
    var inputs = form.getElementsByTagName("input");

    // Loop through each input field
    for (var i = 0; i < inputs.length; i++) {
      var input = inputs[i];

      // Check if the input field has the "required" attribute
      if (input.hasAttribute("required")) {
        // Check if the input value is empty
        if (input.value.trim() === "") {
          // Display an error message and prevent form submission
          alert("Please fill in all the required fields.");
          return false;
        }
      }
    }

    return true;
  }


  // TO UPPERCASE
var form = document.getElementById("add-delegate-form");
var inputs = form.getElementsByTagName("input");

for (var i = 0; i < inputs.length; i++) {
  var input = inputs[i];
  
  if (input.type === "text" || input.type === "password" || input.tagName === "TEXTAREA") {

    input.addEventListener("input", function() {
      var inputValue = this.value;
      if (inputValue.length > 0) {

        if (this.id === "qrcode") {
 
          this.value = inputValue.toUpperCase();
        } else {
          
          this.value = inputValue.charAt(0).toUpperCase() + inputValue.slice(1);
        }
      }
    });
  }
}

</script>


    <!-- FORM VALIDATION  -->
  <script>
    window.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('add-delegate-form');
      var textboxes = form.getElementsByTagName('input');
      
      for (var i = 0; i < textboxes.length; i++) {
        textboxes[i].addEventListener('input', function(e) {
          var inputValue = e.target.value;
          var sanitizedValue = inputValue.replace(/['";]/g, '');
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