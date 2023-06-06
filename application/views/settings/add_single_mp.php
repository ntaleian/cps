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

            <form method="post" action="<?php echo base_url(); ?>settings/add_single_mp" class="form">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Add MPs File</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 mb-2">
                        <p>Add MPs</p>
                      </div>

                      <div class="col-md-3">
                        <h6>MP's Code</h6>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <input type="text" name="Code" class="form-control" id="exampleInputEmail1" placeholder="MP's Code Here" required="">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <h6>MP's Name</h6>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <input type="text" name="Name" class="form-control" id="exampleInputEmail1" placeholder="MP's Name Here" required="">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <h6>MP's Party</h6>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <input type="text" name="Party" class="form-control" id="exampleInputEmail1" placeholder="MP's Party Here" required="">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <h6>MP's Constituency</h6>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <input type="text" name="Constituency" class="form-control" id="exampleInputEmail1" placeholder="MP's Constituency Here" required="">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <h6>MP's District</h6>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <input type="text" name="District" class="form-control" id="exampleInputEmail1" placeholder="MP's District Here" required="">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <h6>Choose Session</h6>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <select class="select2 form-control" name="SessionID">
                            <option value="" disabled selected>---Choose Session---</option>
                            <?php foreach($sessions as $session){ ?>
                            <option value="<?php echo $session['EntryID']; ?>"><?php echo $session['SessionName']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-12 d-flex">

                        <br/><br/>

                        <button type="submit" name="submit" value="submit" class="btn btn-primary mr-1">Submit</button>
                        <button type="reset" class="btn btn-light-secondary">Reset</button>
                      </div>
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </form>

          </section>
          <!-- Basic Select2 end -->



        </div>
      </div>
    </div>
    <!-- END: Content-->