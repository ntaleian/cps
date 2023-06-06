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
                    <h4 class="card-title">Add MPs File</h4>
                  </div>
                  <div class="card-body">

                    <form class="form form-horizontal" method="post" action="<?php echo base_url(); ?>settings/add_mps" enctype="multipart/form-data">

                    <div class="row">
                      <div class="col-12 mb-2">
                        <p>Add MPs</p>
                      </div>
                      <div class="col-md-8">
                        <h6>Choose Session</h6>
                        <div class="form-group">
                          <select class="select2 form-control" name="SessionID">
                            <option value="" disabled selected>---Choose Session---</option>
                            <?php foreach($sessions as $session){ ?>
                            <option value="<?php echo $session['EntryID']; ?>"><?php echo $session['SessionName']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">&nbsp;</div>

                       <div class="col-md-8">
                        <h6>Upload CSV File with MPs</h6>
                        <div class="form-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="MPFile" />
                            <label class="custom-file-label" for="customFile">Choose MPs file</label>
                          </div>
                        </div>
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