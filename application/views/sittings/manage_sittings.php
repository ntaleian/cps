<!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-12 mb-2 mt-1">
            <?php $this->load->view('incl/breadcrumb'); ?>
          </div>
        </div>
        <div class="content-body">

          <!-- Basic Select2 start -->
          <section class="basic-select2">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Committee Member Attendance List</h4>
                  </div>
                  <div class="card-body">
                    <h6 class="card-subtitle"><strong><?php echo $committee; ?></strong></h6>

                    <form method="post" action="<?php echo base_url(); ?>sittings/attendance" class="form">
                    
                    <div class="row">
                      <div class="col-12 mb-2">
                        <p>Please ensure that you have properly select all members' attendance statuses before submitting</p>
                      </div>

                      <div class="col-md-4">
                        <h6>Pick Date</h6>
                        <div class="form-group">
                          <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control pickadate-months-year" placeholder="Select Date" name="SittingDate">
                            <div class="form-control-position">
                              <i class='bx bx-calendar'></i>
                            </div>
                          </fieldset>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <h6>Summary Title of the Sitting</h6>
                        <div class="form-group">
                          <input type="text" id="first-name-icon" class="form-control" name="SittingTitle" placeholder="Summary Title">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <h6>Choose Sitting Category</h6>
                        <div class="form-group">
                          <select class="select2 form-control" name="SittingCat">
                            <option value="" disabled selected>---Choose category---</option>
                            <?php foreach($cats as $cat){ ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['category']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <input type="hidden" name="CommitteeID" value="<?php echo $committeeID; ?>">

                      <input type="hidden" name="CommitteeName" value="<?php echo $committee; ?>">

                      <input type="hidden" name="SessionID"  value="<?php echo $SessionID; ?>">

                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-12">
                        <h6 class="py-50">Committee Members</h6>
                      </div>


                      <?php if(!empty($members)){

                              $counter = 1;

                              $i = 0;

                              foreach($members as $member){
                      ?>

                      <input type="hidden" id="mps-<?php echo $member['EntryID']; ?>" name="mps[]" value="<?php echo $member['EntryID']; ?>">

                      <div class="col-md-4">
                        <h6><?php echo $counter.". ".$member['Name']; ?></h6>
                      </div>
                      <div class="col-md-8">
                        <div class="row">
                          <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                              <li class="d-inline-block mr-2 mb-1">
                                <fieldset>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="attendance1-<?php echo $member['EntryID']; ?>" name="attendance-<?php echo $member['EntryID']; ?>" value='present'>
                                    <label class="custom-control-label" for="attendance1-<?php echo $member['EntryID']; ?>" style="font-size: .8rem;" >Present</label>
                                  </div>
                                </fieldset>
                              </li>
                              <li class="d-inline-block mr-2 mb-1">
                                <fieldset>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="attendance2-<?php echo $member['EntryID']; ?>" name="attendance-<?php echo $member['EntryID']; ?>" value='absent' checked="checked">
                                    <label class="custom-control-label" for="attendance2-<?php echo $member['EntryID']; ?>" style="font-size: .8rem;" >Absent</label>
                                  </div>
                                </fieldset>
                              </li>
                              <li class="d-inline-block mr-2 mb-1">
                                <fieldset>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="attendance3-<?php echo $member['EntryID']; ?>" name="attendance-<?php echo $member['EntryID']; ?>" value="awo">
                                    <label class="custom-control-label" for="attendance3-<?php echo $member['EntryID']; ?>" style="font-size: .8rem;" >A.W.A</label>
                                  </div>
                                </fieldset>
                              </li>
                            </ul>
                          </div>

                          <div class="col-md-3">
                            <div class="form-label-group"  id="apology-<?php echo $member['EntryID']; ?>" style="display: none;">
                              <select class="select2 form-control" name="apology[]">
                                <option value="" disabled selected>---Choose Apology Type---</option>
                                <option>Official Duty</option>
                                <option>Health Related</option>
                                <option>Personal</option>
                                <option>Other</option>
                              </select>
                            </div>
                          </div>
                          
                          <div class="col-md-3">

                            <div class="form-label-group" id="attendancetext-<?php echo $member['EntryID']; ?>" style="display: none;">
                              <input type="text" class="form-control" id="second-name-floating-<?php echo $member['EntryID']; ?>" placeholder="Apology Description Here..." name="att_text[]">
                              <label for="second-name-floating-<?php echo $member['EntryID']; ?>">Apology Description</label>
                            </div>
                          </div>
                        </div>
                        
                      </div>

                      <script type="text/javascript">
                          $(document).ready(function(){

                            $("#attendance3-<?php echo $member['EntryID'] ?>").click(function(){
                              console.log('wano');
                              $('#attendancetext-<?php echo $member['EntryID']; ?>').css('display','block');
                                  $('#apology-<?php echo $member['EntryID']; ?>').css('display','block');
                            });
                            $("#attendance1-<?php echo $member['EntryID'] ?>").click(function(){
                              console.log('wali');
                              $('#attendancetext-<?php echo $member['EntryID']; ?>').css('display','none');
                                  $('#apology-<?php echo $member['EntryID']; ?>').css('display','none');
                            });
                            $("#attendance2-<?php echo $member['EntryID'] ?>").click(function(){
                              console.log('ne wali');
                              $('#attendancetext-<?php echo $member['EntryID']; ?>').css('display','none');
                                  $('#apology-<?php echo $member['EntryID']; ?>').css('display','none');
                            });
                          });  
                        </script>


                      <?php

                            $counter++; 

                            $i++;
                            
                          }
                        }
                       ?>

                      <div class="col-12 d-flex">
                        <br/><br/>

                        <button type="submit"  name="edit" value="Submit Attendance" class="btn btn-primary mr-1">Submit</button>
                        <button type="reset" class="btn btn-light-secondary">Reset</button>
                      </div>

                    </div>
                     
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Basic Select2 end -->



        </div>
      </div>
    </div>
    <!-- END: Content-->