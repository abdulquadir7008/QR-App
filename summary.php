<div class="card-group" id="stats">

                <div class="card border-right" style="background: #49494A;">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center" id="attended">
                                       <?php
                                            
                                            /*$sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE onsite_remarks = 'ATTENDED'";*/
                                            $sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE UPPER(status) = 'YES'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#fff;">' . $row['total'] . '</h2>';
                                            } else {
                                                echo '<h2 class="text-dark mb-1 font-weight-medium">0</h2>';
                                            }

                                            $conn->close();
                                            ?>

                                        
                                    </div>
                                    <h6 class="font-weight-normal mb-0 w-100" style="color:#fff;">Attended</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i data-feather="check" style="color:#fff; font-size: 28px;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>




                     <div class="card border-right" style="background: #49494A;">
                        <div class="card-body" >
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center" id="dropped">
                                       <?php
                                            include 'includes/dbcon.php';
                                            /*$sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE onsite_remarks = 'NOT ATTENDING'";*/
                                            $sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE UPPER(status) = 'DROPPED'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#fff;">' . $row['total'] . '</h2>';
                                            } else {
                                                echo '<h2 class="mb-1 font-weight-medium">0</h2>';
                                            }

                                            $conn->close();
                                            ?>

                                        
                                    </div>
                                    <h6 class="font-weight-normal mb-0 w-100 text-truncate" style="color:#fff;">Dropped</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class="far fa-times-circle" style="color:#fff;font-size: 28px;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card border-right" style="background: #49494A;">
                        <div class="card-body" >
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center" id="yet">
                                       <?php
                                            include 'includes/dbcon.php';
                                            /*$sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE onsite_remarks = ''";*/
                                            /*$sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE status is null";*/
                                            $sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE status is null or UPPER(status) not in ('YES','DROPPED')";

                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#fff;">' . $row['total'] . '</h2>';
                                            } else {
                                                echo '<h2 class="mb-1 font-weight-medium">0</h2>';
                                            }

                                            $conn->close();
                                            ?>

                                        
                                    </div>
                                    <h6 class="font-weight-normal mb-0 w-100 text-truncate" style="color:#fff;">Yet to register</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class="far fa-times-circle" style="color:#fff;font-size: 28px;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>


           
                    </div>
                   


<!--------------------------- 2ND ROW --------------------------------------------------------------->

                <div class="card-group" id="stats">

        
                    <div class="card border-right">
                        <div class="card-body" >
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center" id="arrived">
                                       <?php
                                            include 'includes/dbcon.php';
                                            $sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE onsite_remarks = 'ARRIVED'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;">' . $row['total'] . '</h2>';
                                            } else {
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;;">0</h2>';
                                            }

                                            $conn->close();
                                            ?>


                                        
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Arrived</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class="fas fa-calendar-check" style="color:#0B4596;font-size: 28px;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="card border-right">
                        <div class="card-body" >
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center" id="otw">
                                       <?php
                                            include 'includes/dbcon.php';
                                            $sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE onsite_remarks = 'OTW'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;">' . $row['total'] . '</h2>';
                                            } else {
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;">0</h2>';
                                            }

                                            $conn->close();
                                            ?>


                                        
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">OTW</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class="fas fa-car" style="color:#0B4596;font-size: 28px;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center" id="late">
                                       <?php
                                            include 'includes/dbcon.php';
                                            $sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE onsite_remarks = 'LATE'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;">' . $row['total'] . '</h2>';
                                            } else {
                                                echo '<h2 class="text-dark mb-1 font-weight-medium">0</h2>';
                                            }

                                            $conn->close();
                                            ?>

                                        
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Late </h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class="fas fa-clock" style="color:#0B4596;font-size: 28px;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                   

                   <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center" id="noanswer">
                                       <?php
                                            include 'includes/dbcon.php';
                                            $sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE onsite_remarks = 'NO ANSWER'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;">' . $row['total'] . '</h2>';
                                            } else {
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;">0</h2>';
                                            }

                                            $conn->close();
                                            ?>

                                        
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">No Answer</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class=" far fa-window-close" style="color:#0B4596;font-size: 28px;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center" id="replacement">
                                       <?php
                                            include 'includes/dbcon.php';
                                            $sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE onsite_remarks = 'REPLACEMENT'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;">' . $row['total'] . '</h2>';
                                            } else {
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;">0</h2>';
                                            }

                                            $conn->close();
                                            ?>

                                        
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Replacement</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class="fas fa-users" style="color:#0B4596;font-size: 28px;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center" id="new1">
                                       <?php
                                            include 'includes/dbcon.php';
                                            $sql = "SELECT COUNT(*) AS total FROM qr_attendance WHERE onsite_remarks = 'NEW'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;">' . $row['total'] . '</h2>';
                                            } else {
                                                echo '<h2 class="mb-1 font-weight-medium" style="color:#0B4596;">0</h2>';
                                            }

                                            $conn->close();
                                            ?>
                                    </div>
                                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">New</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class="fas fa-users" style="color:#0B4596;font-size: 28px;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
</div>
