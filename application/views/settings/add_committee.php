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
                    <h4 class="card-title">Add Committee</h4>
                  </div>
                  <div class="card-body">

                    <form method="post" action="<?php echo base_url(); ?>settings/add_committee" class="form">
                    
                    <div class="row">
                      <div class="col-12 mb-2">
                        <p>Add a Committee to the System</p>
                      </div>

                      <div class="col-md-8">
                        <h6>Committee Name</h6>
                        <div class="form-group">
                          <input type="text" name="Title" class="form-control" id="exampleInputEmail1" placeholder="Committee Name Here" required="">
                        </div>
                      </div>
                      <div class="col-md-4">&nbsp;</div>
                      <div class="col-md-8">
                        <h6>Choose Committee Category</h6>
                        <div class="form-group">
                          <select class="select2 form-control" name="Category">
                            <option disabled="" selected=""> -- Select Committee Type -- </option>
                            <option>Standing Committee</option>
                            <option>Sectoral Committee</option>
                            <option>Select Committee</option>
                            <option>Adhoc Committee</option>
                          </select>
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