<header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                   
                    
                    <center><a href="dashboard.php"><img src="assets/images/opengov-logo.jpg" style="max-width: 100%; height: auto;margin-left: -10px;" alt="homepage" class="dark-logo" /></a></center>
                                
                                
                    
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
              
                <div class="navbar-collapse collapse float-left mr-auto" id="navbarSupportedContent">
                    <ul class="navbar-nav float-left mr-auto">

                        <?php
$sql0 = "SELECT * FROM qr_event WHERE STATUS='Active'";
$result0 = $conn->query($sql0);
if ($result0->num_rows > 0) {
    while ($row0 = $result0->fetch_array()) {
        $eventCode = $row0['EVENT_CODE'];
        $eventTitle = $row0['EVENT_TITLE'];
        $eventVenue = $row0['EVENT_VENUE'];
        $eventDate = $row0['EVENT_DATE'];

        $eventCode = strlen($eventCode) > 50 ? substr($eventCode, 0, 50) . '...' : $eventCode;
        $eventTitle = strlen($eventTitle) > 50 ? substr($eventTitle, 0, 50) . '...' : $eventTitle;
        $eventVenue = strlen($eventVenue) > 50 ? substr($eventVenue, 0, 50) . '...' : $eventVenue;
        $eventDate = strlen($eventDate) > 50 ? substr($eventDate, 0, 40) . '...' : $eventDate;
        ?>

        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 align-self-left">
                    <h5 class="page-title text-truncate text-dark font-weight-medium mb-1" title="<?php echo $row0['EVENT_TITLE']; ?>">
                        <?php echo $eventCode; ?> <?php echo $eventTitle; ?> - <small style="font-size: 14px; font-weight: 500;"><?php echo $eventVenue; ?>, <?php echo $eventDate; ?></small>
                    </h5>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item"><small>EVENT TITLE</small></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

<?php
    }
} else {
    echo "<center><p style='margin-left:35px;font-weight:600;'>No Active Event</p></center>";
}
?>

                      
                    </ul>
                    <ul class="navbar-nav float-right">
                        

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="assets/images/admin.jpg" alt="user" class="rounded-circle"
                                    width="40">
                                <span class="ml-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                        class="text-dark"><?php echo $login_access['fullname'];?></span> <i data-feather="chevron-down"
                                        class="svg-icon"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <div class="pl-4 p-3"><a class="btn btn-sm btn-info" data-toggle="modal"
                                        data-target="#logout-modal" style="color:#fff;"><i data-feather="power"
                                        class="svg-icon mr-2 ml-1"></i>
                                    Logout</a></div>


                                
                            </div>
                        </li>
                      
                    </ul>
                </div>

            </nav>
        </header>