<?php session_start(); include 'includes/dbcon.php';?>
<!DOCTYPE html>
<html dir="ltr">
<?php include 'includes/head.php';?>



<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative">
            <div class="auth-box row">
                <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url(assets/images/opengov.jpg);">
                </div>
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                         <?php
if( isset($_SESSION['register_success']) && is_array($_SESSION['register_success']) && count($_SESSION['register_success']) >0 ) {
foreach($_SESSION['register_success'] as $msg) {
echo $msg;
	
}
unset($_SESSION['register_success']); }
						?>
						<?php
//						if(isset($_REQUEST['succ'])){
//						$tem_sesion=$_REQUEST['succ'];
//	$sql_user_time = mysqli_query($conn,"select * from qr_users where session_id='$tem_sesion'");
//	$list_time = mysqli_fetch_array($sql_user_time);
//	$catdate = date("d M Y h:i:s",strtotime($list_time['created_date']));
//	$now = new DateTime(date("Y-m-d h:i:s"));
//	$ref = new DateTime(date("Y-m-d h:i:s",strtotime($list_time['created_date'])));
//$diff = $now->diff($ref);
//echo date("Y-m-d h:i:s");
//printf('%d days, %d hours, %d minutes', $diff->d, $diff->h, $diff->i);
						?>
<!--
						<div class="timer">
	<span class="minutes">01</span>:<span class="seconds">00</span>
</div>
						<script>
							(function( $ ) {
$.fn.timer = function( callback ) {
	callback = callback || function() {};
	return this.each(function() {
		var $timer = $( this ),
			$minutesEl = $timer.find( '.minutes' ),
			$secondsEl = $timer.find( '.seconds' ),
			interval = 1000,
			timer = null,
			start = 60,
			minutesText = $minutesEl.text(),
			minutes = ( minutesText[0] == '0' ) ? minutesText[1] : minutesText[0],
			m = Number( minutes );
			
			timer = setInterval(function() {
				start--;
				if( start == 0 ) {
					start = 60;
					
					$secondsEl.text( '00' );
					
					m--;
					
					if( m == 0 ) {
						clearInterval( timer );
						$minutesEl.text( '00' );
						callback();
						
					}
				} else {
				
					if( start >= 10 ) {
				
						$secondsEl.text( start.toString() );
				
					} else {
				
						$secondsEl.text( '0' + start.toString() );
					
				
					}
					if( minutes.length == 2 ) {
						$minutesEl.text( m.toString() );
					} else {
						if( m == 1 ) {
							$minutesEl.text( '00' );	
						} else {
							$minutesEl.text( '0' + m.toString() );
						}
					}
				
				}
			
			}, interval);
	
	});

};

$(function() {
	$( '.timer' ).timer(function() {
		document.getElementById( 'timer-beep' ).play();
	});

});
  
})( jQuery );  
						</script>
-->
						<?php //} ?>
						
                        <h2 class="mt-3 text-center">User Register</h2>
                        <p class="text-center">Filled the Below Details.</p>
                         <form class="mt-4" action="script/register_process.php" method="post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="uname">Username</label>
                                        <input class="form-control" name="username" type="text"
                                            placeholder="enter your username" id="txt_username" required>
										<div id="uname_response" ></div>
                                    </div>
                                </div>
								<div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="uname">User Role</label>
                                        <select name="user_role" class="form-control" required>
											<option value="">Select Role</option>
										<?php 
											$priv_sql = mysqli_query($conn,"select * from ev_roles where status=1");
											while($listpriv = mysqli_fetch_array($priv_sql)){
											echo "<option value='".$listpriv['role_id']."'>".$listpriv['role_name']."</option>";	
											}
										?>
											
											
										</select>
                                    </div>
                                </div>
								<div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="uname">User Email</label>
                                        <input class="form-control" name="useremail" type="email"
                                            placeholder="Enter your User Email" required>
                                    </div>
                                </div>
								<div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="uname">Full Name</label>
                                        <input class="form-control" name="fullname" type="text"
                                            placeholder="Enter your Full Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pwd">Password</label>
                                        <input class="form-control pword" id="password" name="password" type="password"
                                            placeholder="enter your password" required>
										
										<i class="toggle-password fa fa-fw fa-eye-slash kdrsk"></i>
										
                                 	 <div class="tooltip_og">
                                    <div> 10 Characters  : <span class="passfail passfailSix"><span class="fail">Fail</span></span> </div>
                                    <div> 1 LowerCase  : <span class="passfail passfailLower"><span class="fail">Fail</span></span> </div>
                                    <div> 1 Uppercase  : <span class="passfail passfailUpper"><span class="fail">Fail</span></span> </div>
                                    <div> 1 Number  : <span class="passfail passfailNum"><span class="fail">Fail</span></span> </div>
                                    <div> 1 Special Character  : <span class="passfail passfailSpecial"><span class="fail">Fail</span></span> </div>
                                    <hr />
                                    <div class="alltogCont"> Good Password  : <span class="passfail passfailAll"><span class="fail">Fail</span></span><span class="checkmark">&#x2714;</span> </div>
                                  </div>
										
                                    </div>
                                </div>
								
								<div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pwd">Confirm Password</label>
                                        <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
<!--                                    <input type="submit" name="regsub" class="btn btn-block btn-dark regbtn" value="Register">-->
									<button type="submit" name="regsub" class="btn btn-block btn-dark regbtn" >Register</button>
                                </div>
                                <div class="col-lg-12 text-center mt-5">
                                   <?php //include 'includes/footer.php';?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
  
    <script src="../assets/libs/jquery/dist/jquery.min.js "></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js "></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js "></script>
	<script src="dist/js/passowrd.js"></script>
	<script src="dist/js/passowrd.js"></script>
    <!-- ============================================================== -->
    
    <script>
        $(".preloader ").fadeOut();
    </script>
	<script>
$(document).ready(function(){

    $("#txt_username").keyup(function(){

         var username = $(this).val();
         var usernameRegex = /^[a-zA-Z0-9]+$/;

         if(usernameRegex.test(username) && username != ''){

              $.ajax({
                   url: 'userverify.php',
                   type: 'post',
                   data: {username: username},
                   success: function(response){

                        $('#uname_response').html(response);

                   }
              });
         }else{
              $("#uname_response").html("<span style='color: red; float:right;font-size:13px;'>Enter valid username</span>");
         }

    });

 });
		
		$('.alert-dismissable').delay(10000).fadeOut('slow');
</script>
	
	
</body>

</html>