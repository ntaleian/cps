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
                    <h4 class="card-title">Add Budget Allocation</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 mb-2">
                        <p>Committee</p>
                      </div>
                      <div class="col-md-8">
                        <h6>Committee Name</h6>
                        <div class="form-group">
                          <input type="text" name="Username" class="form-control" id="exampleInputEmail1" placeholder="Committee Name" required="" readonly="" value="<?php echo $committee['Title']; ?>">
                        </div>
                      </div>
                      <div class="col-md-4">&nbsp;</div>
                      <div class="col-md-8">
                        <h6>Type</h6>
                        <div class="form-group">
                          <input type="text" name="Username" class="form-control" id="exampleInputEmail1" placeholder="Type" required="" readonly="" value="<?php if($alloc == 'FT'){ echo "Field Trips"; } else if($alloc == 'TA'){ echo "Travels Abroad"; }  ?>">
                        </div>
                      </div>
                      <div class="col-md-4">&nbsp;</div>

                       <div class="col-md-8">
                        <h6>Amount</h6>
                        <div class="form-group">
                          <input type="text" name="Username" class="form-control" id="exampleInputEmail1" placeholder="Amount" required="">
                        </div>
                      </div>
                      <div class="col-md-4">&nbsp;</div>



                      <div class="col-12 d-flex">

                        <br/><br/>

                        <button type="submit" class="btn btn-primary mr-1">Submit</button>
                        <button type="reset" class="btn btn-light-secondary">Reset</button>
                      </div>
                     
                    </div>
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