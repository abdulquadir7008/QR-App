<?php
session_start();
$ses = session_id();
include 'includes/dbcon.php';
date_default_timezone_set('Asia/Singapore');
if ( $_SESSION[ 'id' ] ) {
  $id = $_SESSION[ 'id' ];
  $login_sql = mysqli_query( $conn, "select * from qr_users WHERE id=$id and status='1'" );
  $login_access = mysqli_fetch_array( $login_sql );

} else {
  echo '<script type="text/javascript">
           window.location = "' . $domain_url . 'index.php"
     </script>';
  unset( $_SESSION[ 'id' ] );
}
if ( isset( $_REQUEST[ 'del' ] ) ) {
  $del_id = $_REQUEST[ 'del' ];
  $query = "delete from qr_delegates WHERE id =$del_id";
  mysqli_query( $conn, $query );
  $errmsg_arr = array();
  $errflag = false;
  $errmsg_arr = '<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> <strong>Success ! </strong>Record Delete successfully.</div>';
  $errflag = true;
  $_SESSION[ 'message' ] = $errmsg_arr;
  session_write_close();
  header( 'Location: ' . $_SERVER[ 'HTTP_REFERER' ] );
  ob_end_flush();
} else if ( isset( $_REQUEST[ 'update_de' ] ) ) {
  $id = $_REQUEST[ 'id' ];
  $notes = $_REQUEST[ 'notes' ];
  $onsite_remarks = $_REQUEST[ 'onsite_remarks' ];
  $status = $_REQUEST[ 'status' ];
  $polling_no = $_REQUEST[ 'polling_no' ];
  $grouping = $_REQUEST[ 'grouping' ];
  $badge_name = $_REQUEST[ 'badge_name' ];
  $org = $_REQUEST[ 'org' ];
  $qrcode = $_REQUEST[ 'qrcode' ];
  $firstname = $_REQUEST[ 'firstname' ];
  $lastname = $_REQUEST[ 'lastname' ];
  $job_title = $_REQUEST[ 'job_title' ];
  $job_category = $_REQUEST[ 'job_category' ];
  $did = $_REQUEST[ 'did' ];
  $mobile = $_REQUEST[ 'mobile' ];
  $email = $_REQUEST[ 'email' ];
  $alt_email = $_REQUEST[ 'alt_email' ];
  $street = $_REQUEST[ 'street' ];
  $city = $_REQUEST[ 'city' ];
  $postal_code = $_REQUEST[ 'postal_code' ];
  $country = $_REQUEST[ 'country' ];
  $sched = $_REQUEST[ 'sched' ];
  $past_new_de = $_REQUEST[ 'past_new_de' ];
  $diet = $_REQUEST[ 'diet' ];
  $lanyard = $_REQUEST[ 'lanyard' ];
  $wishlist = $_REQUEST[ 'wishlist' ];
  $roe = $_REQUEST[ 'roe' ];
  $de = $_REQUEST[ 'de' ];
  $de_to_call = $_REQUEST[ 'de_to_call' ];
  $reminder_call1 = $_REQUEST[ 'reminder_call1' ];
  $reminder_call2 = $_REQUEST[ 'reminder_call2' ];
  mysqli_query( $conn, "update qr_delegates SET notes='$notes',onsite_remarks='$onsite_remarks',status='$status',polling_no='$polling_no',
                                                grouping='$grouping',badge_name='$badge_name',org='$org',qrcode='$qrcode',firstname='$firstname',
                                                lastname='$lastname',job_title='$job_title',did='$did',mobile='$mobile',email='$email',
                                                alt_email='$alt_email',street='$street',city='$city',postal_code='$postal_code',country='$country',sched='$sched',
                                               diet='$diet',lanyard='$lanyard',roe='$roe',de='$de',reminder_call1='$reminder_call1',
                                               reminder_call2='$reminder_call2', 
                                               street='$street', 
                                               city='$city' ,
                                               postal_code='$postal_code' ,
                                               country='$country' ,
                                               past_new_de='$past_new_de' ,
                                               wishlist='$wishlist' ,
                                               de_to_call='$de_to_call' ,
                                               job_category='$job_category' ,
                                               WHERE id =$id" );
  $errmsg_arr = array();
  $errflag = false;
  $errmsg_arr = '<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> <strong>Success ! </strong>Data Update successfully.</div>';
  $errflag = true;
  $_SESSION[ 'message' ] = $errmsg_arr;
  session_write_close();
  header( 'Location: data_import.php?status=' . $ses );
  ob_end_flush();
} else if ( isset( $_REQUEST[ 'data' ] ) == 'aprove' ) {
  mysqli_query( $conn, "TRUNCATE TABLE qr_attendance" );
  $studentQuery = "INSERT INTO `qr_attendance` (`id`, `de`, `past_new_de`, `agency_count`, `de_to_call`, `reminder_call1`, `reminder_call2`, 
                                                `onsite_time`, `onsite_remarks`, `notes`, `status`, `polling_no`, `lanyard`, `qrcode`, 
                                                 `badge_name`, `firstname`, `lastname`, `job_title`, `org`, `did`, `mobile`, `email`, 
                                                 `alt_email`, `street`, `city`, `postal_code`, `country`, `wishlist`, 
                                                  `diet`, `parking`, `grouping`, `sched`, `roe`,`job_category`)
                                      select `id`, `de`, `past_new_de`, `agency_count`, `de_to_call`, `reminder_call1`, `reminder_call2`, 
                                             `onsite_time`, `onsite_remarks`, `notes`, `status`, `polling_no`, `lanyard`, `qrcode`, 
                                             `badge_name`, `firstname`, `lastname`, `job_title`, `org`, `did`, `mobile`, `email`, 
                                             `alt_email`,`street`, `city`, `postal_code`, `country`, `wishlist`,
                                             `diet`, `parking`, `grouping`, `sched`, `roe`, `job_category`   
                                             from qr_delegates";
  mysqli_query( $conn, $studentQuery );
  $errmsg_arr = array();
  $errflag = false;
  $errmsg_arr = '<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> <strong>Success ! </strong>Data import in Attendance Table successfully.</div>';
  $errflag = true;
  $_SESSION[ 'message' ] = $errmsg_arr;
  session_write_close();
  header( 'Location: dashboard.php' );
  ob_end_flush();
}
if ( isset( $_REQUEST[ 'uniq' ] ) ) {
  $uniq = $_REQUEST[ 'uniq' ];
}
$delget_result = mysqli_query( $conn, "SELECT * FROM qr_delegates WHERE unique_id='$uniq' ORDER BY id ASC" );
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<?php include 'includes/head.php';?>

<style>
#main-wrapper[data-layout=vertical][data-sidebartype=full] .page-wrapper {
    margin-left: 0;
}
</style>
<style type="text/css">
.wrapper1, .wrapper2 {
    width: 300px;
    overflow-x: scroll;
    overflow-y: hidden;
}
.wrapper1 {
    height: 20px;
}
.wrapper2 {
    height: 200px;
}
.div1 {
    width: 1000px;
    height: 20px;
}
.div2 {
    width: 1000px;
    height: 200px;
    background-color: #88FF88;
    overflow: auto;
}
table {
    border: 1px solid #f5f5f5;
    border-top-left-radius: 25px;
    border-top-right-radius: 25px;
}
thead {
    position: sticky;
    top: 0;
    background-color: #0B4596;
    color: #fff;
    font-size: 12px;
    margin: 10px;
    width: auto;
}
th {
    padding: 5px;
    text-align: center;
}
td {
    color: #333;
    font-size: 12px;
    text-align: center;
    padding: 10px;
    border-right: 1px solid #f5f5f5;
    border-bottom: 1px solid #f5f5f5;
}
tr:not(:first-child):hover {
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
tr {
    cursor: pointer;
}
.selected-row {
    background-color: #f5f5f5;
    font-weight: bold;
    color: #fff;
}
</style>
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
  //		include('includes/sidebar.php');
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
                <div class="col-12">
					
                  <?php if(isset($_REQUEST['status'])==$ses){?>
                  <div align="right"><a href="data_import.php" class="btn btn-info">Re-Import Data</a></div>
                  <?php } ?>
                  <h4 class="card-title">Import XLS File</h4>
                 
                  <?php
                  if ( isset( $_SESSION[ 'succmessage' ] ) ) {
                    echo "<div class='alert alert-success alert-dismissable'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Success ! </strong><i>" . mysqli_num_rows( $delget_result ) . " Row</i> " . $_SESSION[ 'succmessage' ] . "</div>";
                    unset( $_SESSION[ 'succmessage' ] );
                  }
					if ( isset( $_SESSION[ 'errmsg' ] ) ) {
                    echo "<div class='alert alert-danger alert-dismissable'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Error ! </strong>" . $_SESSION[ 'errmsg' ] . "</div>";
                    unset( $_SESSION[ 'errmsg' ] );
                  }
                  
                  ?>
                  <?php if(isset($_REQUEST['status'])==$ses){?>
                  <div onscroll='scroller("scrollme", "scroller")' style="overflow:scroll; height:450px" id="scrollme">
                    <table class="table" style="width:2830px;" id="multi_col_order">
                      <thead>
                      <th>#</th>
						<th>NOTES</th>
						<th>ONSITE REMARKS</th>
						<th>STATUS</th>
						<th>POLLING NO</th>
						<th>GROUPING</th>
						<th>BADGE NAME</th>
						<th>COMPANY NAME</th>
						<th>QR CODE</th>
						<th>FIRST NAME</th>
						<th>LAST NAME</th>
						<th>JOB</th>
            <th>JOB CAT</th>
						<th>PHONE NO</th>
						<th>MOBILE NO</th>
						<th>EMAIL</th>
						<th>ALT EMAIL</th>
						<th>STREET</th>
						<th>CITY</th>
						<th>POSTAL</th>
						<th>COUNTRY/REGION</th>
						<th>WISHLIST</th>
						<th>SESSION</th>
            <th>PAST/NEW DEL</th>
						<th>DIETARY</th>
						<th>LANYARD</th>
						<th>ROE</th>
						<th>DE</th>
            <th>DE TO CALL ON</th>
						<th>REMINDER CALL 1</th>
						<th>REMINDER CALL 2</th>
                      <th>ACTION</th>
                        </thead>
                        <?php
                        while ( $list_del = mysqli_fetch_array( $delget_result ) ) {
                          ?>
                      <tr>
                        <td></td>
                        <td><?php echo $list_del['notes'];?></td>
                        <td><?php echo $list_del['onsite_remarks'];?></td>
                        <td><?php echo $list_del['status'];?></td>
                        <td><?php echo $list_del['polling_no'];?></td>
                        <td><?php echo $list_del['grouping'];?></td>
                        <td><?php echo $list_del['badge_name'];?></td>
                        <td><?php echo $list_del['org'];?></td>
                        <td><?php echo $list_del['qrcode'];?></td>
                        <td><?php echo $list_del['firstname'];?></td>
                        <td><?php echo $list_del['lastname'];?></td>
                        <td><?php echo $list_del['job_title'];?></td>
                        <td><?php echo $list_del['job_category'];?></td>
                        <td><?php echo $list_del['did'];?></td>
                        <td><?php echo $list_del['mobile'];?></td>
                        <td><?php echo $list_del['email'];?></td>
                        <td><?php echo $list_del['alt_email'];?></td>
                        <td><?php echo $list_del['street'];?></td>
                        <td><?php echo $list_del['city'];?></td>
                        <td><?php echo $list_del['postal_code'];?></td>
                        <td><?php echo $list_del['country'];?></td>
                        <td><?php echo $list_del['wishlist'];?></td>
                        <td><?php echo $list_del['sched'];?></td>
                        <td><?php echo $list_del['past_new_de'];?></td>
                        <td><?php echo $list_del['diet'];?></td>
                        <td><?php echo $list_del['lanyard'];?></td>
                        <td><?php echo $list_del['roe'];?></td>
                        <td><?php echo $list_del['de'];?></td>
                        <td><?php echo $list_del['de_to_call'];?></td>
                        <td><?php echo $list_del['reminder_call1'];?></td>
                        <td><?php echo $list_del['reminder_call2'];?></td>
                        <td><a href="data_import.php?del=<?php echo $list_del['id'];?>&&status=<?php echo $ses;?>" onClick="return confirm('Do you really want to remove it?')"><span class="fa fa-trash-alt"></span></a> <a href="edit_import_data.php?edit=<?php echo $list_del['id'];?>&&status=<?php echo $ses;?>"><span class="fa fa-pencil-alt"></span></a></a></td>
                      </tr>
                      <?php } ?>
                    </table>
                  </div>
                  <p>Total Import List : <?php echo mysqli_num_rows($delget_result);?> </p>
                  <?php //if($login_access['role']=='2' || $login_access['role']=='4' || $login_access['role']=='0'){?>
                  <!-- <a href="data_import.php?data=aprove" onClick="return confirm('Do you want to publish the data in Attendance?')" class="btn btn-info" style="float: right; margin-top: 20px;">Approval</a> -->
                  <?php //} ?>
                  <?php } else{ ?>

                  <div class="card">
                    <div class="card-header">
                      <h4>Import Excel Data into database</h4>
                    </div>
                    <?php
                    if ( isset( $_SESSION[ 'famesage' ] ) && is_array( $_SESSION[ 'famesage' ] ) && count( $_SESSION[ 'famesage' ] ) > 0 ) {
                      foreach ( $_SESSION[ 'famesage' ] as $errors ) {
                        echo $errors;
                      }
                      unset( $_SESSION[ 'famesage' ] );
                    }
                    ?>
                    <div class="card-body">
                    <form action="import_success.php?status=<?php echo $ses; ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateFile();">
                        <div class="row">
                          <div class="col-md-5">
                            <small id="name" class="form-text text-muted mt-3 mb-1">Event Name</small>
                            <select name="event_id" class="form-control" required>
                              <option value="">Select Event</option>
                              <?php
                              $sql_qr_event = mysqli_query($conn, "select * from qr_event WHERE STATUS='Active' order by ID DESC");
                              while ($list_qr_event = mysqli_fetch_array($sql_qr_event)) {
                                ?>
                                <option value="<?php echo $list_qr_event['ID']; ?>"><?php echo $list_qr_event['EVENT_TITLE']; ?></option>
                              <?php } ?>
                            </select>
                            <small id="name" class="form-text text-muted mt-3 mb-1">File Upload</small>
                            <input type="file" name="import_file" class="form-control" required/>
                            <button type="submit" name="save_excel_data" class="btn btn-primary mt-3">Import</button>
                          </div>
                        </div>
                      </form>

                      <script>
                        function validateFile() {
                          var fileInput = document.querySelector('input[name="import_file"]');
                          var filePath = fileInput.value;
                          var allowedExtensions = /(\.xlsx)$/i;

                          if (!allowedExtensions.exec(filePath)) {
                            alert('Please select a valid XLSX file.');
                            fileInput.value = ''; // Clear the file input field
                            return false;
                          }
                          return true;
                        }
                      </script>

                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
              <div class="col-6"> 
                
                <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addModal" style="float: right;"><i class="fas fa-plus"></i> Add Delegate</button> --> 
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'includes/footer.php';?>
</div>
</div>
<script src="assets/libs/jquery/dist/jquery.min.js"></script> 
<script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script> 
<script src="dist/js/feather.min.js"></script> 
<script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script> 

<!--Custom JavaScript --> 
<script src="dist/js/custom.min.js"></script>
</body>
</html>