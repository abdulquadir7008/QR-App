<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
ob_start();
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
require 'compose_xl/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<?php include 'includes/head.php';?>
	<style type="text/css">
		#main-wrapper[data-layout=vertical][data-sidebartype=full] .page-wrapper{
			margin-left: 0;
		}
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
  
  <div class="page-wrapper" id="countcart">
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
                if(isset($_SESSION['message']))
                {
                    echo "<h4>".$_SESSION['message']."</h4>";
                    unset($_SESSION['message']);
                }
                ?>
<?php if(isset($_REQUEST['status'])==$ses){
				
	if(isset($_POST['save_excel_data']))
{	
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
	$event_id=$_REQUEST['event_id'];
	$qr_sql_event = mysqli_query( $conn, "select * from qr_event WHERE ID=$event_id" );
  	$list_qr_event = mysqli_fetch_array( $qr_sql_event );	
	$uniqcode = preg_replace("/[^a-zA-Z0-9]/","",substr($fileName, 0, 7).$list_qr_event['EVENT_DATE'].$list_qr_event['EVENT_START']);
    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();
		$_SESSION['store_data'] = $data;
        $count = "0";
		$cnt=0;
		$cnt2=1;
		?>
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
					</thead>
        <?php $errors[]=''; foreach($data as $row)
        {
			
			if (strlen($row['16']) > 200) {
    					$errors[] = "<div class='alert alert-danger' style='font-size:12px; padding: 6px; margin: 2px'>Row no: <strong>".$cnt2."</strong> 'Office Address Not more than 200 character.'  </div>";
						$_SESSION['famesage'] = $errors;
						unset($_SESSION['store_data']);
			}
			if (strlen($row['11']) > 150) {
    					$errors[] = "<div class='alert alert-danger' style='font-size:12px; padding: 6px; margin: 2px'>Row no: <strong>".$cnt2."</strong> 'Job Title Not more than 200 character.'  </div>";
						$_SESSION['famesage'] = $errors;
						unset($_SESSION['store_data']);
			}
			if (strlen($row['13']) > 25) {
    					$errors[] = "<div class='alert alert-danger' style='font-size:12px; padding: 6px; margin: 2px'>Row no: <strong>".$cnt2."</strong> 'Mobile Not more than 50 character.'  </div>";
						$_SESSION['famesage'] = $errors;
						unset($_SESSION['store_data']);
			}
			
            if($count > 0 && $row['8']!='' && empty($_SESSION['famesage']))
            {
				?>
				 <tr>
						<td></td>
						<td><?php echo $row['1'];?></td>
						<td><?php echo $row['2'];?></td>
						<td><?php echo $row['3'];?></td>
						<td><?php echo $row['4'];?></td>
						<td><?php echo $row['5'];?></td>
						<td><?php echo $row['6'];?></td>
						<td><?php echo $row['7'];?></td>
						<td><?php echo $row['8'];?></td>
						<td><?php echo $row['9'];?></td>
						<td><?php echo $row['10'];?></td>
						<td><?php echo $row['11'];?></td>
						<td><?php echo $row['12'];?></td>
						<td><?php echo $row['13'];?></td>
						<td><?php echo $row['14'];?></td>
						<td><?php echo $row['15'];?></td>
						<td><?php echo $row['16'];?></td>
						<td><?php echo $row['17'];?></td>
						<td><?php echo $row['18'];?></td>
						<td><?php echo $row['19'];?></td>
						<td><?php echo $row['20'];?></td>
						<td><?php echo $row['21'];?></td>
						<td><?php echo $row['22'];?></td>
						<td><?php echo $row['23'];?></td>
						<td><?php echo $row['24'];?></td>
            <td><?php echo $row['25'];?></td>
            <td><?php echo $row['26'];?></td>
            <td><?php echo $row['27'];?></td>
            <td><?php echo $row['28'];?></td>
            <td><?php echo $row['29'];?></td>
            <td><?php echo $row['30'];?></td>
            <td><?php echo $row['31'];?></td>
					</tr>
                <?php 
				
                $msg = true;
            ?>
				 
            <?php $cnt++;} else
            {
                $count = "1";
				 
            }
       $cnt2++; }
		if(!empty($_SESSION['famesage'])){
			$_SESSION['errmsg'] = "Not Imported";
            header('Location: data_import.php');
			ob_end_flush();
            exit(0);
		}
		?>
</table>
				 
					</div>

					<p>Total Import List : <?php echo $cnt;?> </p>
					<?php if($login_access['role']=='4' || $login_access['role']=='1'){?>
					<form method="post" action="script/delegate_save.php">
						<input type="hidden" name="event_id" value="<?php echo $_REQUEST['event_id'];?>">
						<input type="hidden" name="username" value="<?php echo $login_access['fullname'];?>">
						<input type="hidden" name="unique_id" value="<?php echo $uniqcode;?>">
						<button name="save" type="submit" class="btn btn-info" style="float: right; margin-top: 20px;">Save</button>
					</form>
					<?php } ?>
					
       <?php if(isset($msg))
        {
            $_SESSION['message'] = "<div class='alert alert-success alert-dismissable'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a> <strong>Success ! </strong>Data Successfully Imported.</div>";
//            header('Location: data_import.php?status='.$ses);
//            exit(0);
        }
        else
        {
            $_SESSION['message'] = "<div class='alert alert-danger alert-dismissable'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a> <strong>Success ! </strong>Not Imported.</div>";
            header('Location: data_import.php');
			ob_end_flush();
            exit(0);
        }
    }
    else
    {
        $_SESSION['message'] = "<div class='alert alert-danger alert-dismissable'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a> <strong>Success ! </strong>Invalid File.</div>";
        header('Location: data_import.php');
		ob_end_flush();
        exit(0);
    }
}
					?>
					
				
				
				<?php } ?>
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