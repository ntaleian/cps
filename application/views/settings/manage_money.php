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

          <section id="column-selectors">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">
                      Manage <?php if($alloc == 'FT'){ echo "Field Trips"; } else if($alloc == 'TA'){ echo "Travels Abroad"; }  ?> Budget Allocation for <?php echo $committee['Title']; ?>
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      Add Budget Record
                    </p>

                    <button class="btn btn-outline-secondary mr-1 mb-1" data-toggle="modal" data-target="#inlineForm">Add Budget Record</button>
                    <br/><br/>

                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>Quarter</th>
                            <th>Amount</th>
                            <th>Date Added</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                            if(!empty($budget)){
                            $counter = 1; 
                            foreach($budget as $row){ 
                          ?>
                          <tr>
                            <td><?php echo $row['QuarterName']; ?></td>
                            <td><?php echo number_format($row['Amount']); ?></td>
                            <td><?php echo date('l jS F Y', strtotime($row['DateAdded'])); ?></td>
                            <td>
                              <a href="<?php echo base_url() ?>settings/edit_money?id=<?php echo $row['EntryID']; ?>&committee=<?php echo $committee['EntryID']; ?>&alloc=<?php echo $alloc; ?>" class="btn btn-icon rounded-circle btn-secondary mr-1 mb-1"><i class="bx bxs-edit"></i></a>
                              <a href="javascript:void(0)" class="btn btn-icon rounded-circle btn-danger mr-1 mb-1"><i class="bx bx-x"></i></a>
                            </td>
                          </tr>
                          <?php
                              }
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
              aria-labelledby="myModalLabel33" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add New Budget Record </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <i class="bx bx-x"></i>
                    </button>
                  </div>
                  <form method="post" action="<?php echo base_url(); ?>settings/add_money">

                    <input type="hidden" name="CommitteeID" value="<?php echo $committee['EntryID']; ?>">
                    <input type="hidden" name="AllocType" value="<?php echo $alloc; ?>">

                    <div class="modal-body">

                      <label>Quarter: </label>
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

                      <label>Amount: </label>
                      <div class="form-group">
                        <input type="text" name="Amount" class="form-control" id="exampleInputEmail1" placeholder="Amount" required="">
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                      </button>
                      <button type="submit" name="addamount" value="Save" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add Budget Record</span>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

        </div>
      </div>
    </div>
    <!-- END: Content-->