<aside class="left-sidebar" data-sidebarbg="skin6">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <span class="hide-menu">Navigation Menu</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link sidebar-link active" href="dashboard.php" aria-expanded="false">
            <i data-feather="home" class="feather-icon"></i>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li> <?php
                                        $sqlstate0 = "SELECT * FROM qr_event WHERE STATUS = 'Active' AND EVENT_CODE = 'OGEX'";
                                        $resultstate0 = $conn->query($sqlstate0);

                                        if ($resultstate0->num_rows > 0) {
                                            $rowstate0 = $resultstate0->fetch_assoc();
                                            $badgeColor0 = ($rowstate0['total_file'] > 0) ? 'success' : 'secondary';
                                            echo '
                                            
				<li class="sidebar-item">
					<a class="sidebar-link sidebar-link" href="room_dashboard.php"
                                                    aria-expanded="false">
						<i data-feather="home" class="feather-icon"></i>
						<span
                                                        class="hide-menu">Room Dashboard</span>
					</a>
				</li>';
                                        } 
                                        ?> <?php if($login_access['role']=='1' || $login_access['role']=='4'){?>
        <!-- ADDED BY HEATHER TO PREVENT ACCES BY OTHER USER ROLES -- MAY 21 2024 -->
        <li class="list-divider"></li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="for-approval.php" aria-expanded="false">
            <i class=" fas fa-mouse-pointer"></i>
            <span class="hide-menu">DEL Approval <?php
                                    $sqlstate = "SELECT COUNT(*) AS total FROM qr_delegates WHERE state = 'Pending'";
                                    $resultstate = $conn->query($sqlstate);

                                    if ($resultstate->num_rows > 0) {
                                        $rowstate = $resultstate->fetch_assoc();
                                        $badgeColor = ($rowstate['total'] > 0) ? 'success' : 'secondary';
                                        echo '
							<span id="counter" class="badge badge-pill badge-' . $badgeColor . '">' . $rowstate['total'] . '</span>';
                                    } else {
                                        echo '
							<span id="counter" class="badge badge-pill badge-secondary">0</span>';
                                    }
                                ?> <script type="text/javascript">
                var refreshInterval;
                var requestInProgress = false;
                refreshInterval = setInterval(function() {
                  if (!requestInProgress) {
                    requestInProgress = true;
                    $.ajax({
                      url: document.URL,
                      type: 'GET',
                      success: function(response) {
                        $('#counter').html($(response).find('#counter').html());
                      },
                      complete: function() {
                        requestInProgress = false;
                      }
                    });
                  }
                }, 2000);
              </script>
              <!-- FORMER CODE FOR DEL APPROVAL COUNTER
                                <script type="text/javascript">
                                  var refreshInterval;
                                    refreshInterval = setInterval(function() {
                                      $('#counter').load(document.URL + ' #counter');
                            
                                    }, 2000);
                                
                                </script>
                            -->
            </span>
          </a>
        </li> <?php } ?> <?php if($login_access['role']=='1' || $login_access['role']=='4'){?>
        <!-- ADDED BY HEATHER TO PREVENT ACCES BY OTHER USER ROLES -- MAY 21 2024 -->
        <li class="list-divider"></li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="event_manage.php" aria-expanded="false">
            <i class="fas fa-qrcode"></i>
            <span class="hide-menu">&nbsp;Manage Event </span>
          </a>
        </li> <?php } ?> <?php if($login_access['role']=='1' || $login_access['role']=='4'){?> <li class="sidebar-item">
          <a class="sidebar-link" href="data_import.php" aria-expanded="false">
            <i class="fas fa-qrcode"></i>
            <span class="hide-menu">&nbsp;Import Excel File </span>
          </a>
        </li> <?php } ?> <?php if($login_access['role']=='1' || $login_access['role']=='2' || $login_access['role']=='4'){?> <li class="sidebar-item">
          <a class="sidebar-link" href="aproval_deligate_list.php" aria-expanded="false">
            <i class="fas fa-file-excel"></i>
            <span class="hide-menu">Approve File <?php
                                    $sqlstate2 = "SELECT COUNT(*) AS total_file FROM qr_file_upload WHERE status = '1'";
                                    $resultstate2 = $conn->query($sqlstate2);

                                    if ($resultstate2->num_rows > 0) {
                                        $rowstate2 = $resultstate2->fetch_assoc();
                                        $badgeColor2 = ($rowstate2['total_file'] > 0) ? 'success' : 'secondary';
                                        echo '
							<span id="counter2" class="badge badge-pill badge-' . $badgeColor2 . '">' . $rowstate2['total_file'] . '</span>';
                                    } else {
                                        echo '
							<span id="counter2" class="badge badge-pill badge-secondary">0</span>';
                                    }
                                ?> <script type="text/javascript">
                var refreshInterval;
                var requestInProgress = false;
                refreshInterval = setInterval(function() {
                  if (!requestInProgress) {
                    requestInProgress = true;
                    $.ajax({
                      url: document.URL,
                      type: 'GET',
                      success: function(response) {
                        $('#counter2').html($(response).find('#counter2').html());
                      },
                      complete: function() {
                        requestInProgress = false;
                      }
                    });
                  }
                }, 2000);
              </script>
              <!-- FORMER CODE FOR IMPORT FILE COUNTER
                                <script type="text/javascript">
                                  var refreshInterval2;
                                    refreshInterval2 = setInterval(function() {
                                      $('#counter2').load(document.URL + ' #counter2');
                            
                                    }, 2000);
                                
                                </script> -->
            </span>
          </a>
        </li> <?php } ?> <?php if($login_access['role']=='1'){?> <li class="sidebar-item">
          <a class="sidebar-link" href="users.php" aria-expanded="false">
            <i class="fas fa-users"></i>
            <span class="hide-menu">Registered user </span>
          </a>
        </li> <?php } ?> <?php if($login_access['role']=='1' || $login_access['role']=='4'){?>
        <!-- ADDED BY HEATHER TO PREVENT ACCES BY OTHER USER ROLES -- MAY 21 2024 -->
        <li class="sidebar-item">
          <a class="sidebar-link" href="user_role.php" aria-expanded="false">
            <i class="fas fa-users"></i>
            <span class="hide-menu">Add User Role </span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="user_privileges.php" aria-expanded="false">
            <i class="fas fa-users"></i>
            <span class="hide-menu">Add Privileges </span>
          </a>
        </li> <?php } ?> <?php if($login_access['role']=='1'){?> <li class="list-divider"></li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="activity-logs.php" aria-expanded="false">
            <i class="fas fa-clock"></i>
            <span class="hide-menu">Activity Logs </span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="user-logs.php" aria-expanded="false">
            <i class="fas fa-users"></i>
            <span class="hide-menu">User Logs </span>
          </a>
        </li> <?php } ?>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>