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
                    <form action="<?php echo base_url() ?>settings/add_money" method="post">

                      <input type="hidden" name="CommitteeID" value="<?php echo $_GET['id']; ?>">
                      <input type="hidden" name="AllocType" value="<?php echo $_GET['alloc']; ?>">

                      <div class="row">
                        <div class="col-12 mb-2">
                          <p>Committee</p>
                        </div>
                        <div class="col-md-8">
                          <h6>Committee Name</h6>
                          <div class="form-group">
                            <input type="text" name="" class="form-control" id="exampleInputEmail1" placeholder="Committee Name" required="" readonly="" value="<?php echo $committee['Title']; ?>">
                          </div>
                        </div>
                        <div class="col-md-4">&nbsp;</div>
                        <div class="col-md-8">
                          <h6>Type</h6>
                          <div class="form-group">
                            <input type="text" name="" class="form-control" id="exampleInputEmail1" placeholder="Type" required="" readonly="" value="<?php if($alloc == 'FT'){ echo "Field Trips"; } else if($alloc == 'TA'){ echo "Travels Abroad"; }  ?>">
                          </div>
                        </div>
                        <div class="col-md-4">&nbsp;</div>

                        <div class="col-md-8">
                          <h6>Quarter</h6>
                          <div class="form-group">
                            <select class="select2 form-control" name="QuarterID">
                            <?php 
                              foreach($quarters as $quarter){
                                $qs = date('F', mktime(0,0,0,$quarter['start'],10));
                                $qe = date('F', mktime(0,0,0,$quarter['end'],10));
                             ?>
                            <option value="<?php echo $quarter['id']; ?>" ><?php echo $quarter['title']." (".$qs." to ".$qe.")"; ?></option>
                            <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">&nbsp;</div>

                         <div class="col-md-8">
                          <h6>Amount</h6>
                          <div class="form-group">
                            <input type="text" name="Amount" class="form-control" id="exampleInputEmail1" placeholder="Amount" required="">
                          </div>
                        </div>
                        <div class="col-md-4">&nbsp;</div>



                        <div class="col-12 d-flex">

                          <br/><br/>

                          <button type="submit" name="addamount" value="addamount" class="btn btn-primary mr-1">Submit</button>
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