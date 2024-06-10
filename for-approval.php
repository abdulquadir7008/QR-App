<?php
session_start();
include 'includes/dbcon.php' ;
if ( $_SESSION[ 'id' ] ) {
  $id = $_SESSION[ 'id' ];
  $login_sql = mysqli_query( $conn, "select * from qr_users WHERE id=$id and status='1'" );
  $login_access = mysqli_fetch_array( $login_sql );
}
else{
  echo '
<script type="text/javascript">
           window.location = "'.$domain_url.'index.php"
     </script>';
    unset($_SESSION['id']);
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en"> <?php include 'includes/head.php';?> <body>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full"> <?php include('includes/header.php');?> <?php 
    include('logout-modal.php'); 
    include('includes/sidebar.php');
    ?> <div class="page-wrapper">
        <div class="container-fluid">
          <!-- multi-column ordering -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <h4 class="card-title">Delegates For Approval</h4>
                      <small class="form-text text-muted mb-3">*This table displays all <b>Delegates for System Approval</b>
                      </small>
                    </div>
                  </div>
                  <div class="table-responsive">

<!--  NEW COUNT CODE TO SHOW THE TOTAL NUMBER. ADDED BY HEATHER MAY 10 2024 //
//CHANGED "THEN 0" TO "THEN 1"//
//OLD CODE
//$sql = "SELECT 
         //   COUNT(*) AS total, 
          //  SUM(CASE WHEN state = '%Pending%' THEN 0 ELSE 0 END) AS pending_total,
          //  SUM(CASE WHEN state = '%Decline%' THEN 0 ELSE 0 END) AS decline_total,
          //  SUM(CASE WHEN state LIKE '%Approved%' THEN 0 ELSE 0 END) AS approved_total
       // FROM qr_delegates WHERE state IS NOT NULL AND state <> ''";

//END OF OLD CODE ---- NEW CODE BELOW-->

<?php
  $sql = "SELECT 
    COUNT(*) AS total, 
    COUNT(CASE WHEN state LIKE '%Pending%' THEN 1 END) AS pending_total,
    COUNT(CASE WHEN state LIKE '%Decline%' THEN 1 END) AS decline_total,
    COUNT(CASE WHEN state LIKE '%Approved%' THEN 1 END) AS approved_total
FROM qr_delegates WHERE state IS NOT NULL AND state <> ''";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo '<h6>Total: 
            <b style="color:#0B4596;"> ' . $row['total'] . ' Delegates</b>
        </h6>'; 
        
    echo '<h6>Pending: 
            <b style="color:#0B4596;"> ' . $row['pending_total'] . ' Delegates</b>
        </h6>';
    
    echo '<h6>Declined: 
            <b style="color:#0B4596;"> ' . $row['decline_total'] . ' Delegates</b>
        </h6>';
        
    echo '<h6>Approved: 
            <b style="color:#0B4596;"> ' . $row['approved_total'] . ' Delegates</b>
        </h6>';
}

$conn->close();
?>

          <input type="text" id="search-input" class="form-control" placeholder="Search" style="float: right;width: 300px;">
                    <style type="text/css">
                      .wrapper1,
                      .wrapper2 {
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
                      .btn-light{
                        z-index: 0;
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
                        z-index: 9999;
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

                      th:first-child,
                      td:first-child {
                        position: sticky;
                        left: 0;
                        background-color: #0B4596;
                        color: #fff;
                        border-bottom: none;
                      }

              
                      .selected-row {
                        background-color: #f5f5f5;
                        font-weight: bold;
                        color: #fff;
                      }

                     
                    </style> <?php include 'includes/dbcon.php';?> <br>
                    <br>
                    <div onscroll='scroller("scroller", "scrollme")' style="overflow:scroll; height: 10;overflow-y: hidden;" id=scroller>
                      <img src="" height=1 width=2066 style="width:2066px;">
                    </div>
                    <div onscroll='scroller("scrollme", "scroller")' style="overflow:scroll; height:650px" id="scrollme">
                      <table style="width:100%;" id="multi_col_order">
                        <thead>
                          <th>#</th>
                          <th>QR CODE</th>
                          <th>NAME</th>
                          <th>STATE</th>
                          <th>CREATED BY</th>
                          <th>TIME</th>
                          <th>ACTION BY</th>
                          <th style="z-index: 99999;">ACTION</th>
                        </thead>
                     <tbody>
    <?php
    $sql2 = "SELECT * FROM qr_delegates WHERE state IS NOT NULL AND state <> '' ORDER BY state DESC";
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_array()) {
            $approvedBy = $row2['approved_by'];
            ?>
            <tr ondblclick="//location.href='edit-delegate.php?id=<?php //echo $row2['id']; ?>'">
                <td></td>
                <td id="qrvalue"><?php echo $row2['qrcode']; ?></td>
                <td id="name"><?php echo $row2['firstname'] . ' ' . $row2['lastname']; ?></td>
                <td id="state"><?php echo $row2['state']; ?></td>
                <td id="created_by">
                    <?php echo $row2['created_by']; ?>
                </td>
                <td id="time"><?php echo $row2['approved_time']; ?></td>
                <?php
               // $sql7 = "SELECT * FROM qr_users";
                // $result7 = $conn->query($sql7);

               // if ($result7->num_rows > 0) {
                   // while ($row7 = $result7->fetch_array()) {
                   //     $id = $row7['id'];
                    //    ?>
                        <!-- <td id="approve">$approvedBy</td>
                        <td id=""></td>-->
                        <?php
                 //   }
               // } else {
                    ?>
                    <td id="approve"><?php echo $row2['approved_by']; ?></td>
                    <td id="status">
                    <?php
                      if ($login_access['fullname'] === $row2['created_by']) {
                        // CODE EDITED TO REMOVE THE OVERFLOWING OF BUTTONS TO THE TABLE. CHANGED FROM DIABLED BUTTON TO TEXT INSTEAD ; CURSOR ALSO ADDED ADDED BY HEATHER MAY 20 2024 //
                        echo '<b>Disabled</b>';
                      } elseif (strpos($row2['state'], 'Approved') !== false) {
                          echo '<a style="color:green;cursor: none;font-weight:600;">APPROVED</a>';
                      } elseif (strpos($row2['state'], 'Declined') !== false) {
                          echo '<a style="cursor: none;font-weight:600;">Declined</a>';
                      } else {
                          echo '<a href="edit-for-approval.php?id=' . $row2['id'] . '" class="btn btn-info btn-sm">Update</a>';
                      }
                      ?>
                    </td>
                    <?php
              //  }
                ?>
            </tr>
            <?php
        }

    } else {
       echo "<tr style='background:red;'>
        <td colspan='12'>
            <center>
                <p style='color:#000000;'>No Records</p>
            </center>
        </td>
    </tr>";
}
$conn->close();
?>
</tbody>


                      </table>
                    </div>
                    <script>
                      var arescrolling = 0;

                      function scroller(from, to) {
                        if (arescrolling) return; // avoid potential recursion/inefficiency
                        arescrolling = 1;
                        // set the other div's scroll position equal to ours
                        document.getElementById(to).scrollLeft = document.getElementById(from).scrollLeft;
                        arescrolling = 0;
                      }
                    </script>
                    <script>
                      function selectedRow() {
                        var index,
                          table = document.getElementById("multi_col_order");
                        for (var i = 1; i < table.rows.length; i++) {
                          table.rows[i].onclick = function() {
                            // remove the background from the previous selected row
                            if (typeof index !== "undefined") {
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
        </div> <?php include 'includes/footer.php';?>
      </div>
    </div>

    <script>
    // Get the button element
    var updateButton = document.getElementById("updateButton");

    // Check if the button text contains the word "Approved"
    if (updateButton.textContent.includes("Approved")) {
        // Hide the button
        updateButton.style.display = "none";
    }
</script>

<script type="text/javascript">
    var refreshInterval;

    $(document).ready(function(){
        $('#search-input').on('input', function(){
            var searchText = $(this).val().toLowerCase();
            $('#multi_col_order tbody tr').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });

            // If the search input is active and not empty, clear the refresh interval
            if (searchText.length > 0) {
                clearInterval(refreshInterval);
            } else {
                // If the search input is not active, set up the initial refresh interval
                refreshInterval = setInterval(function() {
                  $('#multi_col_order').load(document.URL + ' #multi_col_order');
                  $('#attended').load(document.URL + ' #attended');
                  $('#dropped').load(document.URL + ' #dropped');
                  $('#arrived').load(document.URL + ' #arrived');
                  $('#otw').load(document.URL + ' #otw');
                  $('#replacement').load(document.URL + ' #replacement');
                  $('#late').load(document.URL + ' #late');
                  $('#new1').load(document.URL + ' #new1');
                  $('#noanswer').load(document.URL + ' #noanswer'); // add this line to refresh the element with the 'attended' id
                  $('#yet').load(document.URL + ' #yet'); // add this line to refresh the element with the 'yet to register' id
                }, 2000);
            }
        });

        // Disable refresh on row click
        $('#multi_col_order tbody').on('click', 'tr', function() {
            clearInterval(refreshInterval);
        });
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