<?php
session_start();
include 'includes/dbcon.php';
if ( $_SESSION[ 'id' ] ) {
  echo $id = $_SESSION[ 'id' ];
  $login_sql = mysqli_query( $conn, "select * from qr_users WHERE id=$id and status='1'" );
  $login_access = mysqli_fetch_array( $login_sql );
	if(isset($_REQUEST['role_id'])){
		$roleid= $_REQUEST['role_id'];
		$evrole_sql = mysqli_query( $conn, "select * from ev_roles WHERE role_id=$roleid and status='1'" );
		$listrole_sql = mysqli_fetch_array( $evrole_sql );
		$btn_sub = "roleupdate";
		$btn_txt = "Update";
	}
	else{
		$btn_sub = "rolesubmit";
		$btn_txt = "Save";
	}
	
} else {
  echo '<script type="text/javascript">
           window.location = "' . $domain_url . 'index.php"
     </script>';
  unset( $_SESSION[ 'id' ] );
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
        <div class="col-4">
          <div class="card">
            <div class="card-body">
            <h4 class="card-title">Add Role Details</h4>
            <!-- <small class="form-text text-muted mb-3">*This table displays all scanned attendees with <b>VALID</b> QR codes</small><br>-->
            
            <form method="post" action="user_role.php">
              <div class="row">
                <div class="col-md-12">
                  <small id="name" class="form-text text-muted mb-3">Role Name</small> 
					<input type="text" class="form-control" id="role_name" name="role_name" aria-describedby="Role Name" value="<?php if(isset($_REQUEST['role_id'])){ echo $listrole_sql['role_name'];} ?>">
					<input type="hidden" name="role_id" value="<?php if(isset($_REQUEST['role_id'])){ echo $listrole_sql['role_id'];}?>">
					<h4 style="margin-top: 30px;">Choose Role Privileges</h4>
					<?php
//					if($listrole_sql['permission']){
//						$perm = explode(",",$listrole_sql['permission']);
//							foreach ($perm as $value) {
//								echo $value;
//							}
//					}
					$priv_qry=mysqli_query($conn,"SELECT * FROM ev_privileges where status='1'");
						while($priv_list=mysqli_fetch_array($priv_qry)){
							$keys_Select='';
							if(isset($_REQUEST['role_id'])){
							$rol_permission_id = array_filter( explode( ",", $listrole_sql[ 'permission' ] ) );
							$key = array_search( $priv_list['privilage_id'], $rol_permission_id );
							$keys_Select='';
							if ( is_numeric( $key ) ) {
                                $keys_Select = "checked";
                              }
							}
						echo "<div class='permcheck'><input type='checkbox' name='permission[]' value='".$priv_list['privilage_id']."' ".$keys_Select."> ".$priv_list['privileges_name']."</div>";
					}
					?>
					
					
                  </div>
              </div>
              </div>
              <div class="modal-footer"> <a href="dashboard.php" type="button" class="btn btn-light">Back</a>
                <button type="submit" name="<?php echo $btn_sub;?>" id="submit" class="btn btn-primary"><?php echo $btn_txt;?></button>
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