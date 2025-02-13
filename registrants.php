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
               
                <!-- multi-column ordering -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">Unregistered QR Codes List</h4>
                                        <small class="form-text text-muted mb-3">*This table displays all <b>UNREGISTERED QR CODES</b> scanned</small>
                                    </div>
                                        
                                    </div>



                                     <div class="table-responsive">

                                  <?php
                                            
                                            $sql = "SELECT COUNT(*) AS total FROM qr_invalid";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo ' <h6 style="float: left;">Total: <b style="color:#0B4596;"> ' . $row['total'] . ' Delegates</b></h6>';
                                            } else {
                                                echo '<h6 style="float: left;">Total: <b style="color:#0B4596;"> ' . $row['total'] . ' Delegates</b></h6>';
                                            }

                                            $conn->close();
                                            ?>


                                  <input type="text" id="search-input" class="form-control" placeholder="Search" style="float: right;width: 300px;">

                               
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

                             <?php include 'includes/dbcon.php';?>

<br><br>
<div onscroll='scroller("scroller", "scrollme")' style="overflow:scroll; height: 10;overflow-y: hidden;" id=scroller>
  <img src="" height=1 width=2066 style="width:2066px;">
</div>


<div onscroll='scroller("scrollme", "scroller")' style="overflow:scroll; height:650px" id="scrollme">
  <table style="width:100%;" id="multi_col_order">
     <thead>
                                        <th>#</th>
                                        <th>STATUS</th>
                                        <th>QR CODE</th>
                                        <th>      </th>
                   </thead>


     <tbody>

                     <?php $sql2 = "SELECT * FROM qr_invalid WHERE status = 'INVALID QR'";
                                                $result2 = $conn->query($sql2);
                                                if($result2->num_rows > 0){
                                                while($row2 = $result2->fetch_array()){?>

                  
                   <tr ondblclick="location.href='edit-delegate.php?id=<?php echo $row2['id']; ?>'">

                                        <td></td>
                                        <td id="status"><?php echo $row2['status'] ;?></td>
                                        <td id="qrvalue"><?php echo $row2['qrcode'] ;?></td>
                                        <td id="status"><a href="edit-delegate.php?id=<?php echo $row2['id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                    </tr>

                                    
                    
                     <?php
                                                    }   
                                                }else{
                                                    echo "<center><p> No Records</p></center>";
                                                }
                                        
                                        $conn->close();
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



 <script>
            
            function selectedRow(){
                
                var index,
                    table = document.getElementById("multi_col_order");
            
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         // remove the background from the previous selected row
                        if(typeof index !== "undefined"){
                           table.rows[index].classList.toggle("selected-row");
                        }
                        console.log(typeof index);
                        // get the selected row index
                        index = this.rowIndex;
                        // add class selected to the row
                        this.classList.toggle("selected-row");
                        console.log(typeof index);
                     };
                }
                
            }
            selectedRow();
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



    

<script type="text/javascript">
    var refreshInterval;

    $(document).ready(function(){
        $('#search-input').on('keyup', function(){
            var searchText = $(this).val().toLowerCase();
            $('#multi_col_order tbody tr').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
            
            // If the search input is active, clear the refresh interval
            clearInterval(refreshInterval);
        });

        // Disable refresh on row click
        $('#multi_col_order tbody').on('click', 'tr', function() {
            clearInterval(refreshInterval);
        });
        
        // Set up the initial refresh interval
        refreshInterval = setInterval(function() {
            $('#multi_col_order').load(document.URL + ' #multi_col_order');
            $('#attended').load(document.URL + ' #attended');
            $('#dropped').load(document.URL + ' #dropped');
            $('#arrived').load(document.URL + ' #arrived');
            $('#otw').load(document.URL + ' #otw');
            $('#replacement').load(document.URL + ' #replacement');
            $('#late').load(document.URL + ' #late');
            $('#noanswer').load(document.URL + ' #noanswer'); // add this line to refresh the element with the 'attended' id
        }, 2000);
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

    <!-- <script src="assets/libs/double-scroll/double-scrollbar.js"></script> -->
 <!-- <script src="assets/libs/double-scroll/double-scroll-table.js"></script> -->



    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>

</body>
</html>