<div class="modal fade" id="addModal" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add New Delegaate</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                               <form method="post" action="add-delegate.php">
                                                

                                                     <div class="row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="qrcode" name="qrcode" aria-describedby="name">
                                                            <small id="name" class="form-text text-muted mb-3">QR Code</small>
                                                        </div>
                                                    </div>  

                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="name">
                                                            <small id="name" class="form-text text-muted mb-3">First Name</small>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="lastname" name="lastname" aria-describedby="name">
                                                            <small id="name" class="form-text text-muted mb-3">Last Name</small>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="badge_name" name="badge_name" aria-describedby="name">
                                                            <small id="name" class="form-text text-muted mb-3">Badge Name</small>
                                                        </div>

                                                         <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="job_title" name="job_title" aria-describedby="name">
                                                            <small id="name" class="form-text text-muted mb-3">Job Title</small>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="org" name="org" aria-describedby="name">
                                                            <small id="name" class="form-text text-muted mb-3">Organisation</small>
                                                        </div>

                                                    </div> 

   

                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="de" name="de" aria-describedby="name">
                                                        <small id="name" class="form-text text-muted mb-3">Assigned DE</small>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="past_new_de" name="past_new_de" aria-describedby="name">
                                                        <small id="name" class="form-text text-muted mb-3">Past/New Delegate</small>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="agency_count" name="agency_count" aria-describedby="name">
                                                        <small id="name" class="form-text text-muted mb-3">Agency count</small>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="de_to_call" name="de_to_call" aria-describedby="name">
                                                        <small id="name" class="form-text text-muted mb-3">DE to call on</small>
                                                    </div>

                                                </div>  

                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="reminder_call1" name="reminder_call1" aria-describedby="name">
                                                    <small id="name" class="form-text text-muted mb-3">Reminder calls</small>
                                                </div>

                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="reminder_call2" name="reminder_call2" aria-describedby="name">
                                                    <small id="name" class="form-text text-muted mb-3">Reminder calls 2</small>
                                                </div>

                                               

                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="polling_no" name="polling_no" aria-describedby="name">
                                                    <small id="name" class="form-text text-muted mb-3">Polling Number2</small>
                                                </div>

                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="lanyard" name="lanyard" aria-describedby="name">
                                                    <small id="name" class="form-text text-muted mb-3">Lanyard</small>
                                                </div>

                                                 <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="did" name="did"aria-describedby="name">
                                                    <small id="name" class="form-text text-muted mb-3">DID</small>
                                                </div>



                                            </div>


                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="mobile" name="mobile" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Mobile</small>
                                            </div>

                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="email" name="email" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Email</small>
                                            </div>

                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="alt_email" name="alt_email" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Alternate Email</small>
                                            </div>

                                        </div> 



                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="office_address" name="office_address" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Office Address</small>
                                            </div>

                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="diet" name="diet" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Dietary </small>
                                            </div>

                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="parking" name="parking" aria-describedby="name">
                                                <small id="name" class="form-text text-muted mb-3">Parking</small>
                                            </div>

                                        </div> 


                                         <div class="row">
        <div class="col-sm-4">
            <input type="text" class="form-control" id="grouping" name="grouping" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Grouping</small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="sched" name="sched" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Session</small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="vaccinated" name="vaccinated" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">Vaccinated</small>
        </div>

        <div class="col-sm-4">
            <input type="text" class="form-control" id="roe" name="roe" aria-describedby="name">
            <small id="name" class="form-text text-muted mb-3">ROE</small>
        </div>

      

    </div> 



                                     <div class="form-group mb-4">
                                        <div class="row">
                                          <div class="col-sm-4">
                                                <small class="form-text text-muted">Attendance</small>
                                                <select class="form-control" id="status" name="status">
                                                    <option>[Please Select]</option>
                                                    <option> </option>
                                                    <option>YES</option>
                                                    <option>DROPPED</option>
                                                </select>
                                            </div>

                                        <div class="col-sm-4">
                                            <small id="" class="form-text text-muted">Status</small>
                                            <select class="form-control" id="remarks1" name="remarks1">
                                                <option>[Please Select]</option>
                                                <option>REPLACEMENT</option>
                                                <option>ATTENDED</option>
                                                <option>ARRIVED</option>
                                                <option>OTW</option>
                                                <option>NO ANSWER</option>
                                                <option>LATE</option>
                                                <option>NOT ATTENDING</option>
                                                <option>NEW</option>
                                            </select>
                                        </div>


                                        <div class="col-sm-4">
                                            <textarea class="form-control" rows="2"  id="additional" name="additional" placeholder="Text Here..."></textarea>
                                            <small id="name" class="form-text text-muted mb-3">Remarks </small>
                                        </div>

                                        </div>
                                    </div>

                                    <script>
                                      const attendanceDropdown = document.getElementById("status");
                                      const remarksDropdown = document.getElementById("remarks1");

                                      attendanceDropdown.addEventListener("change", function() {
                                        if (attendanceDropdown.value === "DROPPED") {
                                          remarksDropdown.value = "NOT ATTENDING";
                                          remarksDropdown.disabled = false;
                                        } else if (attendanceDropdown.value === "YES") {
                                          remarksDropdown.value = "ATTENDED";
                                          remarksDropdown.disabled = false;
                                        } else if (attendanceDropdown.value === "[Please Select]") {
                                          remarksDropdown.value = "[Please Select]";
                                          remarksDropdown.disabled = false;
                                        } else {
                                          remarksDropdown.disabled = false;
                                        }
                                      });
                                    </script>



                                    <div class="row" style="visibility: hidden;">
                                    <div class="col-sm-6">
                                            <input type="text" class="form-control" id="active_user" name="active_user" value="<?php echo $_SESSION['username']?>" aria-describedby="name">
                                           
                                        </div>
                                    </div>

                                    </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Save changes</button>
                                            </div>

                                </form>
                                            
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>

                        