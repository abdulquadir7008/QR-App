<?php
session_start();
include 'includes/dbcon.php';
if ( $_SESSION[ 'id' ] ) {
  $id = $_SESSION[ 'id' ];
  $login_sql = mysqli_query( $conn, "select * from qr_users WHERE id=$id and status='1'" );
  $login_access = mysqli_fetch_array( $login_sql );
  if(isset($_REQUEST['event_id'])){
    $event_edit_sql = mysqli_query( $conn, "select * from qr_event WHERE ID=".$_REQUEST['event_id']."" );
    $list_event_edit = mysqli_fetch_array( $event_edit_sql );
    $btn_sub = "event_update";
    $btn_txt = "Update";
  }
  else{
    $btn_sub = "event_submit";
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


<body>
<div id="main-wrapper" 
     data-theme="light" 
     data-layout="vertical" 
     data-navbarbg="skin6" 
     data-sidebartype="full"
     data-sidebar-position="fixed" 
     data-header-position="fixed" 
     data-boxed-layout="full">
  <?php include('includes/header.php'); ?>
  <?php include('logout-modal.php'); ?>
  <?php include('includes/sidebar.php'); ?>

  <div class="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-5">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Add Event Details</h4>

              <form method="post" action="event_manage.php">
                <div class="row">
                  <div class="col-md-12">
                    <input type="hidden" name="event_id" 
                           value="<?php if(isset($_REQUEST['event_id'])){ echo $list_event_edit['ID'];}?>">
                    
                    <small id="name" class="form-text text-muted mb-1 mt-3">Event Code</small> 
                    <input type="text" class="form-control" id="event_code" 
                           name="event_code" required aria-describedby="Role Name" 
                           oninput="this.value = this.value.toUpperCase();" 
                           value="<?php if(isset($_REQUEST['event_id'])){ echo $list_event_edit['EVENT_CODE'];} ?>">

                    <small id="name" class="form-text text-muted mb-1 mt-0"><i>(e.g OGBI, OGLF)</i></small> 

                    <small id="name" class="form-text text-muted mb-1 mt-3">Event Name</small> 
                    <input type="text" class="form-control" id="event_title" 
                           name="event_title" required aria-describedby="Role Name" 
                           value="<?php if(isset($_REQUEST['event_id'])){ echo $list_event_edit['EVENT_TITLE'];} ?>">

                    <small id="name" class="form-text text-muted mb-1 mt-3">Event Venue</small> 
                    <input type="text" class="form-control" id="event_venue" 
                           name="event_venue" required aria-describedby="Role Name" 
                           value="<?php if(isset($_REQUEST['event_id'])){ echo $list_event_edit['EVENT_VENUE'];} ?>">

                    <small id="name" class="form-text text-muted mb-1 mt-3">Event Date</small> 
                    <input type="date" class="form-control" id="event_date" 
                           name="event_date" required aria-describedby="Role Name" 
                           value="<?php if(isset($_REQUEST['event_id'])){ echo $list_event_edit['EVENT_DATE'];} ?>">

                    <div class="row">
                      <div class="col-md-6">
                        <small id="name" class="form-text text-muted mb-1 mt-3">Event Start</small> 
                        <input type="time" class="form-control" id="event_start" 
                               name="event_start" required aria-describedby="Role Name" 
                               value="<?php if(isset($_REQUEST['event_id'])){ echo $list_event_edit['EVENT_START'];} ?>">
                      </div>

                      <div class="col-md-6">
                        <small id="name" class="form-text text-muted mb-1 mt-3">Event End</small> 
                        <input type="time" class="form-control" id="event_time" 
                               name="event_time" required aria-describedby="Role Name" 
                               value="<?php if(isset($_REQUEST['event_id'])){ echo $list_event_edit['EVENT_END'];} ?>">
                      </div>
                    </div>

                    <small id="name" class="form-text text-muted mb-1 mt-3">Status</small> 
                    <select name="status" id="status" class="form-control" required>
                      <option value="">Select Status</option>
                      <option value="<?php if(isset($_REQUEST['event_id'])){ echo $list_event_edit['STATUS'];} ?>" selected>
                        <?php if(isset($_REQUEST['event_id'])){ echo $list_event_edit['STATUS'];} ?>
                      </option>
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                      <!-- <option value="Completed">Completed</option> -->
                    </select>
                    
                    <script>
                      function disableActiveOption(selectElement) {
                        if (selectElement.value === "Completed") {
                          // Disable the "Active" option
                          selectElement.querySelector('option[value="Active"]').disabled = true;
                        } else {
                          // Enable the "Active" option
                          selectElement.querySelector('option[value="Active"]').disabled = false;
                        }
                      }

                      // Initially call the function to set the initial state
                      disableActiveOption(document.querySelector('select[name="status"]'));
                    </script>
                  </div>
                </div>


                <div class="modal-footer"> 
                  <a href="dashboard.php" type="button" class="btn btn-light">Back</a>
                  <button type="submit" name="<?php echo $btn_sub; ?>" id="submit" class="btn btn-primary"><?php echo $btn_txt; ?></button>
                </div>
              </form>
            </div>
          </div>
        </div>

    
      </div>                
  
</div>

</div>
<?php include 'includes/footer.php';?>

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