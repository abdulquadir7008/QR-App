<?php
session_start();
include 'includes/dbcon.php';

//echo 'A5';

if ( $_SESSION[ 'id' ] ) {
  $id = $_SESSION[ 'id' ];
  $login_sql = mysqli_query( $conn, "select * from qr_users WHERE id=$id and status='1'" );
  $login_access = mysqli_fetch_array( $login_sql );
} else {
  echo '<script type="text/javascript">
           window.location = "' . $domain_url . 'dashboard.php"
     </script>';
  unset( $_SESSION[ 'id' ] );
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
  include( 'logout-modal.php' );
  include( 'includes/sidebar.php' );
  ?>
  <div class="page-wrapper"> 
    
    <!-- <?php //include 'breadcrumb.php';?> -->
    
    <div class="container-fluid">
      <?php include 'summary.php';?>
      
      <!-- QR SCANNER ---> 
      <!---- <div class="col-lg-5 col-md-12" style="padding: 0px;margin: 0px;">
                       <iframe src="qr-scanner.php" height="620px" width="100%" title="QR Scanner" style="border:none;padding: 0px;margin: 0px;"scrolling="no"></iframe>
                    </div>
                </div> --> 
      
      <!-- multi-column ordering -->
      <div class="row" id="tblattendance">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <h4 class="card-title">Event Attendance List</h4>
                  <small class="form-text text-muted">*This table displays all scanned attendees with <b>VALID</b> QR codes</small><br>
                  <div id="dropped12" style="color: red; font-size: 25px;"></div>
                  <div id="demo123"></div>
                  <div class="d-flex justify-content-end align-items-end mb-3"> <a href="add-delegate-form.php" type="button" class="btn btn-info btn-sm mr-2">Add Delegate</a>
                    <input type="button" id="exportButton" name="exportButton" class="btn btn-info btn-sm" value="Export Data to CSV">
                  </div>
                  <script>
                                            document.getElementById('exportButton').addEventListener('click', function() {
                                                var confirmed = confirm("Are you sure you want to export the data to CSV?");
                                                if (confirmed) {
                                                    window.location.href = 'export.php';
                                                }
                                            });
                                        </script>
                  <div class="search-container">
                    <label class="switch">
                      <input type="checkbox" id="search-toggle">
                      <span class="slider"></span> </label>
                    <input type="text" id="search-input" placeholder="Search Here" disabled>
                  </div>
                </div>
              </div>
              <?php
              if ( isset( $_SESSION[ 'message' ] ) ) {
                echo "<h4>" . $_SESSION[ 'message' ] . "</h4>";
                unset( $_SESSION[ 'message' ] );
              }
              ?>
              <div class="table-responsive">
                <?php
                include 'includes/dbcon.php';
                ?>
                <?php

                $sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE state IS NULL OR state LIKE '%Approved%'";
                $result = $conn->query( $sql );

                if ( $result->num_rows > 0 ) {
                  $row = $result->fetch_assoc();
                  echo ' <h6 style="float: left;">Total: <b style="color:#0B4596;"> ' . $row[ 'total' ] . ' Delegates</b></h6>';
                } else {
                  echo '<h6 style="float: left;">Total: <b style="color:#0B4596;"> ' . $row[ 'total' ] . ' Delegates</b></h6>';
                }

                // $conn->close();
                ?>
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



.search-container {
            display: flex;
            align-items: center;
            float:right;
        }

        #search-input {
            padding: 4px;
            font-size: 13px;
            margin-left: 10px;
            width:250px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 35px; /* Adjust the width */
            height: 18px; /* Adjust the height */
            margin-top:5px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-border-radius: 10px; /* Adjust the border-radius */
            border-radius: 10px; /* Adjust the border-radius */
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 17px; /* Adjust the height */
            width: 17px; /* Adjust the width */
            left: 2px;
            bottom: 2px;
            background-color: white;
            -webkit-border-radius: 50%;
            border-radius: 50%;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(16px); /* Adjust the translation */
            -ms-transform: translateX(16px); /* Adjust the translation */
            transform: translateX(16px); /* Adjust the translation */
        }
</style>
                <?php include 'includes/dbcon.php';?>
                <br>
                <br>
                <div onscroll='scroller("scroller", "scrollme")' style="overflow:scroll; height: 10;overflow-y: hidden;" id=scroller> 
                  <!-- <img src="" height=1 width=2066 style="width:2066px;" --> 
                  <img src="" height=1 width=2300 style="width:2860px;"> </div>
                <div onscroll='scroller("scrollme", "scroller")' style="overflow:scroll; height:650px" id="scrollme">
                  <table style="width:2830px;" id="multi_col_order">
                    <thead>
                    <th>#</th>
                      <th>ATTENDANCE</th>
                      <th>REMARKS</th>
                      <th>STATUS</th>
                      <th>POL NO</th>
                      <th>GROUPING</th>
                      <th>DE(REMINDER CALLS)</th>
                      <th>BADGE</th>
                      <th>ORG</th>
                      <th>QR CODE</th>
                      <th>NAME</th>
                      <th>JOB</th>
                      <th>JOB CAT</th>
                      <th>DID</th>
                      <th>MOBILE</th>
                      <th>EMAIL</th>
                      <th>ALT EMAIL</th>
                      <!-- <th>OFFICE</th> -->
                      <th>STREET ADDRESS</th>
                      <th>CITY</th>
                      <th>POSTAL</th>
                      <th>COUNTRY</th>
                      <th>WISHLIST</th>
                      <th>SESSION</th>
                      <th>VACCINATED</th>
                      <th>DIET</th>
                      <th>LANYARD</th>
                      <th>ROE</th>
                      <th>DE</th>
                      <th>REMINDER CALL (1)</th>
                      <th>UNIQ CODE</th>
                      <th> </th>
                      </thead>
                    <tbody>
                      <?php
                      $sql2 = "SELECT * FROM qr_attendance WHERE state IS NULL OR state LIKE '%Approved%' ORDER BY id desc";


                      $result2 = $conn->query( $sql2 );
                      if ( $result2->num_rows > 0 ) {
                        while ( $row2 = $result2->fetch_array() ) {
                          ?>
                      <tr ondblclick="location.href='edit-delegate.php?id=<?php echo $row2['id']; ?>'"
                    title="Double click to edit" onmouseover="this.title='Double click to edit'">
                        <td></td>
                        <td id="status"><?php echo $row2['status'] ;?></td>
                        <td id="status"><?php echo $row2['notes'] ;?></td>
                        <td id="status"><?php echo $row2['onsite_remarks'] ;?></td>
                        <td id="qrvalue"><?php echo $row2['polling_no'] ;?></td>
                        <td id="qrvalue"><?php echo $row2['grouping'] ;?></td>
                        <td id="status"><?php echo $row2['reminder_call2'];?></td>
                        <td id="qrvalue"><?php echo $row2['badge_name'] ;?></td>
                        <td id="qrvalue"><?php echo $row2['org'] ;?></td>
                        <td id="qrvalue"><?php echo $row2['qrcode'] ;?></td>
                        <td id="name"><?php echo $row2['firstname'] ;?> <?php echo $row2['lastname'] ;?></td>
                        <td id="name"><?php echo $row2['job_title'] ;?></td>
                        <td id="name"><?php echo $row2['job_category'] ;?></td>
                        <td id="qrvalue"><?php echo $row2['did'] ;?></td>
                        <td id="status"><?php echo $row2['mobile'] ;?></td>
                        <td id="status"><?php echo $row2['email'] ;?></td>
                        <td id="status"><?php echo $row2['alt_email'] ;?></td>
                        <!-- <td id="status"><//?php echo $row2['office_address'] ;?></td> -->
                        <td id="status"><?php echo $row2['street'] ;?></td>
                        <td id="status"><?php echo $row2['city'] ;?></td>
                        <td id="status"><?php echo $row2['postal_code'] ;?></td>
                        <td id="status"><?php echo $row2['country'] ;?></td>
                        <td id="status"><?php echo $row2['wishlist'] ;?></td>
                        <td id="status"><?php echo $row2['sched'] ;?></td>
                        <td id="status"><?php echo $row2['vaccinated'] ;?></td>
                        <td id="status"><?php echo $row2['diet'] ;?></td>
                        <td id="status"><?php echo $row2['lanyard'] ;?></td>
                        <td id="status"><?php echo $row2['roe'] ;?></td>
                        <td id="status"><?php echo $row2['de'] ;?></td>
                        <td id="status"><?php echo $row2['reminder_call1'] ;?></td>
                        <td id="status"><?php echo $row2['unique_id'] ;?></td>
                        <td id="status"><a href="edit-delegate.php?id=<?php echo $row2['id']; ?>" class="btn btn-info btn-sm">View</a></td>
                      </tr>
                      <?php
                      }
                      } else {
                        echo "<center><p> No Records</p></center>";
                      }

                      // $conn->close();
                      ?>
                    </tbody>
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

<!--script src="assets/libs/jquery/dist/jquery.min.js"></script--> 
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

<!-- SCRIPT FROM NIGAM ADDED BY HEATHER MAY062024  --> 

<script>
	
	// Input search func
    $(document).ready(function() {
        var refreshInterval;
        var requestInProgress = false;
        setupRefreshInterval();
        $('#search-toggle').on('change', function() {
            var searchInput = $('#search-input');
            searchInput.prop('disabled', !this.checked);

            if (this.checked) {
                clearInterval(refreshInterval);
            } else {
                setupRefreshInterval();
            }
        });

        // Filter table rows on search input keyup
        $('#search-input').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            $('#multi_col_order tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
            if (searchText.length > 0) {
                clearInterval(refreshInterval);
            }
        });

        // Disable refresh on row click
        $('#multi_col_order tbody').on('click', 'tr', function() {
            clearInterval(refreshInterval);
        });
		
		
		//Auto load ID in dashboard
        function setupRefreshInterval() {
            refreshInterval = setInterval(function() {
                if (!requestInProgress) {
                    requestInProgress = true;
                    $.ajax({
                        url: document.URL,
                        type: 'GET',
                        success: function(response) {
                            $('#multi_col_order').html($(response).find('#multi_col_order').html());
                            $('#attended').html($(response).find('#attended').html());
                            $('#dropped').html($(response).find('#dropped').html());
                            $('#arrived').html($(response).find('#arrived').html());
                            $('#otw').html($(response).find('#otw').html());
                            $('#replacement').html($(response).find('#replacement').html());
                            $('#late').html($(response).find('#late').html());
                            $('#new1').html($(response).find('#new1').html());
                            $('#noanswer').html($(response).find('#noanswer').html());
                            $('#yet').html($(response).find('#yet').html());
                        },
                        complete: function() {
                            requestInProgress = false;
                        }
                    });
                }
            }, 2000);
        }
		
		
//Auto Refresh dashboard		
  function reloadPage() {
    location.reload();
  }
  setInterval(reloadPage, 300000); 
});

</script>
</body>
</html>