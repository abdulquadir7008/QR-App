<?php
session_start();
$ses=session_id();
include 'includes/dbcon.php';
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
if(isset($_REQUEST['edit'])){
	$id= $_REQUEST['edit'];
	$grcode_edit = mysqli_query( $conn, "select * from qr_delegates WHERE id=$id" );
  	$list_del = mysqli_fetch_array( $grcode_edit );	
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<?php include 'includes/head.php';?>
	<style>
		#main-wrapper[data-layout=vertical][data-sidebartype=full] .page-wrapper{
			margin-left: 0;
		}
		small.form-text.text-muted.mt-3.mb-1{ font-size: 14px; color: #333 !important;}
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
					<div align="right"><a href="data_import.php" class="btn btn-info">Re-Import Data</a></div>
                  <h4 class="card-title">Edit import Data</h4>
                  <small class="form-text text-muted mb-3">*This Form displays List of <b>Import Data</b> </small><br>
					<div class="card">
                    <div class="card-header">
                        <h4>Edit import Data</h4>
                    </div>
                    <div class="card-body">

                        <form action="data_import.php" method="POST" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">notes</small>
									<input type="text" name="notes" class="form-control" value="<?php echo $list_del['notes'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">onsite_remarks</small>
									<input type="text" name="onsite_remarks" class="form-control" value="<?php echo $list_del['onsite_remarks'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">status</small>
									<input type="text" name="status" class="form-control" value="<?php echo $list_del['status'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">polling_no</small>
									<input type="text" name="polling_no" class="form-control" value="<?php echo $list_del['polling_no'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">grouping</small>
									<input type="text" name="grouping" class="form-control" value="<?php echo $list_del['grouping'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">badge_name</small>
									<input type="text" name="badge_name" class="form-control" value="<?php echo $list_del['badge_name'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">org</small>
									<input type="text" name="org" class="form-control" value="<?php echo $list_del['org'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">qrcode</small>
									<input type="text" name="qrcode" class="form-control" value="<?php echo $list_del['qrcode'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">firstname</small>
									<input type="text" name="firstname" class="form-control" value="<?php echo $list_del['firstname'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">lastname</small>
									<input type="text" name="lastname" class="form-control" value="<?php echo $list_del['lastname'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">job_title</small>
									<input type="text" name="job_title" class="form-control" value="<?php echo $list_del['job_title'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">did</small>
									<input type="text" name="did" class="form-control" value="<?php echo $list_del['did'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">mobile</small>
									<input type="text" name="mobile" class="form-control" value="<?php echo $list_del['mobile'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">email</small>
									<input type="text" name="email" class="form-control" value="<?php echo $list_del['email'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">alt_email</small>
									<input type="text" name="alt_email" class="form-control" value="<?php echo $list_del['alt_email'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">office_address</small>
									<input type="text" name="office_address" class="form-control" value="<?php echo $list_del['office_address'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">sched</small>
									<input type="text" name="sched" class="form-control" value="<?php echo $list_del['sched'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">vaccinated</small>
									<input type="text" name="vaccinated" class="form-control" value="<?php echo $list_del['vaccinated'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">diet</small>
									<input type="text" name="diet" class="form-control" value="<?php echo $list_del['diet'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">lanyard</small>
									<input type="text" name="lanyard" class="form-control" value="<?php echo $list_del['lanyard'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">roe</small>
									<input type="text" name="roe" class="form-control" value="<?php echo $list_del['roe'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">de</small>
									<input type="text" name="de" class="form-control" value="<?php echo $list_del['de'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">reminder_call1</small>
									<input type="text" name="reminder_call1" class="form-control" value="<?php echo $list_del['reminder_call1'];?>">
								</div>
								<div class="col-md-3">
									<small id="name" class="form-text text-muted mt-3 mb-1">reminder_call2</small>
									<input type="text" name="reminder_call2" class="form-control" value="<?php echo $list_del['reminder_call2'];?>">
								</div>
							</div>
							<input type="hidden" name="id" value="<?php echo $list_del['id'];?>">
                           <button class="btn btn-info" name="update_de" style="margin-top: 30px; float: right;">Update</button>

                        </form>

                    </div>
                </div>
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