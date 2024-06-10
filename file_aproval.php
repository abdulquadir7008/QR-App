<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
$ses=session_id();
include 'includes/dbcon.php';
if ( $_SESSION[ 'id' ] ) {
  $id = $_SESSION[ 'id' ];
  $login_sql = mysqli_query( $conn, "select * from qr_users WHERE id=$id and status='1'" );
  $login_access = mysqli_fetch_array( $login_sql );
	$user_fullname = $login_access['fullname'];
	
} else {
  echo '<script type="text/javascript">
           window.location = "' . $domain_url . 'index.php"
     </script>';
  unset( $_SESSION[ 'id' ] );
}
if(isset($_REQUEST['uniq'])){
	$uniq=$_REQUEST['uniq'];
}
$qr_sql_file_single=mysqli_query($conn,"SELECT * FROM qr_file_upload WHERE unique_id='$uniq'");
$file_uploaded_by_name = mysqli_fetch_array($qr_sql_file_single);
$filecode_name = $file_uploaded_by_name['upload_by'];
 if(isset($_REQUEST['data'])=='approve'){
	 
	mysqli_query($conn,"TRUNCATE TABLE qr_attendance");	
	 $delget_result12=mysqli_query($conn,"SELECT * FROM qr_delegates WHERE unique_id='$uniq'");
	 while($list_del = mysqli_fetch_array($delget_result12)){
		 $de=mysqli_real_escape_string($conn,$list_del['de']);
		 $past_new_de=mysqli_real_escape_string($conn,$list_del['past_new_de']);
		 $agency_count=mysqli_real_escape_string($conn,$list_del['agency_count']);
		 $de_to_call=mysqli_real_escape_string($conn,$list_del['de_to_call']);
		 $reminder_call1=mysqli_real_escape_string($conn,$list_del['reminder_call1']);
		 $reminder_call2=mysqli_real_escape_string($conn,$list_del['reminder_call2']);
		 $onsite_time=mysqli_real_escape_string($conn,$list_del['onsite_time']);
		 $onsite_remarks=mysqli_real_escape_string($conn,$list_del['onsite_remarks']);
		 $notes=mysqli_real_escape_string($conn,$list_del['notes']);
		 $status=mysqli_real_escape_string($conn,$list_del['status']);
		 $polling_no=mysqli_real_escape_string($conn,$list_del['polling_no']);
		 $lanyard=mysqli_real_escape_string($conn,$list_del['lanyard']);
		 $qrcode=mysqli_real_escape_string($conn,$list_del['qrcode']);
		 $badge_name=mysqli_real_escape_string($conn,$list_del['badge_name']);
		 $firstname=mysqli_real_escape_string($conn,$list_del['firstname']);
		 $lastname=mysqli_real_escape_string($conn,$list_del['lastname']);
		 $job_title=mysqli_real_escape_string($conn,$list_del['job_title']);
		 $job_category=mysqli_real_escape_string($conn,$list_del['job_category']);
		 $org=mysqli_real_escape_string($conn,$list_del['org']);
		 $did=mysqli_real_escape_string($conn,$list_del['did']);
		 $mobile=mysqli_real_escape_string($conn,$list_del['mobile']);
		 $email=mysqli_real_escape_string($conn,$list_del['email']);
		 $alt_email=mysqli_real_escape_string($conn,$list_del['alt_email']);
		 //$office_address=mysqli_real_escape_string($conn,$list_del['office_address']); *commented by heather
		 //added by heather
		 $street=mysqli_real_escape_string($conn,$list_del['street']);
		 $city=mysqli_real_escape_string($conn,$list_del['city']);
		 $postal_code=mysqli_real_escape_string($conn,$list_del['postal_code']);
		 $country=mysqli_real_escape_string($conn,$list_del['country']);
		 //end
		 $diet=mysqli_real_escape_string($conn,$list_del['diet']);
		 $parking=mysqli_real_escape_string($conn,$list_del['parking']);
		 $grouping=mysqli_real_escape_string($conn,$list_del['grouping']);
		 $sched=mysqli_real_escape_string($conn,$list_del['sched']);
		 $roe=mysqli_real_escape_string($conn,$list_del['roe']);
		 $create_date=mysqli_real_escape_string($conn,$list_del['create_date']);
		 $unique_id=mysqli_real_escape_string($conn,$list_del['unique_id']);
		 $street=mysqli_real_escape_string($conn,$list_del['street']);
		 $city=mysqli_real_escape_string($conn,$list_del['city']);
		 $postal_code=mysqli_real_escape_string($conn,$list_del['postal_code']);
		 $country=mysqli_real_escape_string($conn,$list_del['country']);
		 $past_new_de=mysqli_real_escape_string($conn,$list_del['past_new_de']);
		 $wishlist=mysqli_real_escape_string($conn,$list_del['wishlist']);
		 $event_id=mysqli_real_escape_string($conn,$list_del['event_id']);

		 $studentQuery12 ="INSERT INTO qr_attendance (de,past_new_de,agency_count,de_to_call,reminder_call1,reminder_call2, onsite_time, onsite_remarks, notes,status,polling_no,lanyard,qrcode,badge_name,firstname,lastname, job_title,job_category,org,did,mobile,email,alt_email,diet,parking,grouping,sched, vaccinated,roe,event_id,create_date,unique_id,approved_by,approved_time,created_by,street,city,postal_code,country,wishlist)VALUES ('$de','$past_new_de','$agency_count','$de_to_call','$reminder_call1','$reminder_call2','$onsite_time','$onsite_remarks','$notes','$status','$polling_no','$lanyard','$qrcode','$badge_name','$firstname','$lastname','$job_title','$job_category','$org','$did','$mobile','$email','$alt_email','$diet','$parking','$grouping','$sched','$vaccinated','$roe','$event_id','$create_date','$unique_id','$id',now(),'$filecode_name','$street','$city','$postal_code','$country','$wishlist' )";
		 
		 
//		 $studentQuery12 ="INSERT INTO qr_attendance (de,past_new_de,agency_count,de_to_call,reminder_call1,reminder_call2)VALUES ('$de','$past_new_de','$agency_count','$de_to_call','$reminder_call1','$reminder_call2')";
         $result = mysqli_query($conn, $studentQuery12);
	 }

	 
	 
//	$studentQuery12 ="INSERT INTO qr_attendance (de,past_new_de,agency_count,de_to_call,reminder_call1,reminder_call2,onsite_time,onsite_remarks,notes,status,polling_no,lanyard,qrcode,badge_name,firstname,lastname,job_title,org,did,mobile,email,alt_email,office_address,diet,parking,grouping,sched,vaccinated,roe,event_id,create_date,unique_id)SELECT de,past_new_de,agency_count,de_to_call,reminder_call1,reminder_call2,onsite_time,onsite_remarks,notes,status,polling_no,lanyard,qrcode,badge_name,firstname,lastname,job_title,org,did,mobile,email,alt_email,office_address,diet,parking,grouping,sched,vaccinated,roe,event_Id,create_date,unique_id FROM qr_delegates WHERE unique_id='$uniq'";
//	mysqli_query($conn, $studentQuery12);
	 
	
	 mysqli_query( $conn, "update qr_file_upload SET status='2',approved_date_datetime=now(),approved_by='$user_fullname' WHERE unique_id ='$uniq'" );
	$errmsg_arr = array();
    $errflag = false;
    $errmsg_arr = '<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a> <strong>Success ! </strong>Data import in Attendance Table successfully.</div>';
    $errflag = true;
    $_SESSION[ 'message' ] = $errmsg_arr;
    session_write_close();
    header( 'Location: dashboard.php' );
    ob_end_flush();
}
$delget_result=mysqli_query($conn,"SELECT * FROM qr_delegates WHERE unique_id='$uniq' ORDER BY id ASC");
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<?php include 'includes/head.php';?>
	<style>
		#main-wrapper[data-layout=vertical][data-sidebartype=full] .page-wrapper{
			margin-left: 0;
		}
	</style>
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
				
                  <h4 class="card-title">Import XLS File</h4>
                  
										
					<?php
                if(isset($_SESSION['message']))
                {
                    echo "<div class='alert alert-success alert-dismissable'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Success ! </strong><i>".mysqli_num_rows($delget_result)." Row</i> ".$_SESSION['message']."</div>";
                    unset($_SESSION['message']);
                }
                ?>
<?php if(isset($_REQUEST['uniq'])){?>
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
						<th>REMINDER CALL 1</th>
						<th>REMINDER CALL 2</th>
						
					</thead>
				<?php while($list_del = mysqli_fetch_array($delget_result)){
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
						<td><?php echo $list_del['reminder_call1'];?></td>
						<td><?php echo $list_del['reminder_call2'];?></td>
						
					</tr>
					<?php } ?>
				</table>
				  
					</div>
				<p>Total Import List : <?php echo mysqli_num_rows($delget_result);?> </p>
				<?php if($login_access['role']=='2' || $login_access['role']=='4' || $login_access['role']=='1'){?>
				<a href="file_aproval.php?data=aprove&&uniq=<?php echo $uniq;?>" onClick="return confirm('Do you want to publish the data in Attendance?')" class="btn btn-info" style="float: right; margin-top: 20px;">Approve</a>
				<?php } ?>
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