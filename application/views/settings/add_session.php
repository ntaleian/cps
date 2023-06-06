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
                    <h4 class="card-title">Add Session</h4>
                  </div>
                  <div class="card-body">

                    <form method="post" action="<?php echo base_url() ?>settings/add_session" class="form">
                    
                    <div class="row">
                      <div class="col-12 mb-2">
                        <p>Add a Session to Capture Reports</p>
                      </div>

                      <div class="col-md-8">
                        <h6>Session Name</h6>
                        <div class="form-group">
                          <input type="text" name="SessionName" class="form-control" id="exampleInputEmail1" placeholder="Session Name Here" required="">
                        </div>
                      </div>
                      <div class="col-md-4">&nbsp;</div>

                      <div class="col-md-8">
                        <h6>Start Date</h6>
                        <div class="form-group">
                          <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control pickadate-months-year" placeholder="Select Date" name="SessionStart">
                            <div class="form-control-position">
                              <i class='bx bx-calendar'></i>
                            </div>
                          </fieldset>
                        </div>
                      </div>
                      <div class="col-md-4">&nbsp;</div>

                      <div class="col-md-8">
                        <h6>End Date</h6>
                        <div class="form-group">
                          <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control pickadate-months-year" placeholder="Select Date" name="SessionEnd">
                            <div class="form-control-position">
                              <i class='bx bx-calendar'></i>
                            </div>
                          </fieldset>
                        </div>
                      </div>
                      <div class="col-md-4">&nbsp;</div>

                      <div class="col-md-8">
                        <h6>Is Session Active?</h6>
                        <ul class="list-unstyled mb-0">
                          <li class="d-inline-block mr-2 mb-1">
                            <fieldset>
                              <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="IsActive" value="Y" id="customRadio1" checked>
                                <label class="custom-control-label" for="customRadio1">Yes</label>
                              </div>
                            </fieldset>
                          </li>
                          <li class="d-inline-block mr-2 mb-1">
                            <fieldset>
                              <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="IsActive" value="N" id="customRadio2">
                                <label class="custom-control-label" for="customRadio2">No</label>
                              </div>
                            </fieldset>
                          </li>
                        </ul>
                      </div>
                      <div class="col-md-4">&nbsp;</div>

                      <div class="col-12 d-flex">
                        <br/><br/>

                        <button type="submit" name="submit" value="submit" class="btn btn-primary mr-1">Submit</button>
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