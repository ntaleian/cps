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
                      Manage Bills
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      Manage Bills processed
                    </p>

                    <button class="btn btn-outline-secondary mr-1 mb-1" data-toggle="modal" data-target="#inlineForm">Add New Processed Bill</button>
                    <br/><br/>

                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Date of 1st Hearing</th>
                            <th>Committee</th>
                            <th>Bill Type</th>
                            <th>Comments</th>
                            <th>Report Status</th>
                            <th>Person in Charge</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                            if(!empty($bills)){
                            $counter = 1; 
                            foreach($bills as $bill){ 
                          ?>
                          <tr>
                            <td><?php echo $bill['BillName']; ?></td>
                            <td><?php echo date('l jS F Y', strtotime($bill['DateProcessed'])); ?></td>
                            <td><?php echo $bill['Title']; ?></td>
                            <td><?php if($bill['BillType'] == '1'){ echo "Private Members Bill"; } else if($bill['BillType'] == '2'){ echo "Government Bill"; } else { echo "---"; } ?></td>
                            <td><?php if(!empty($bill['Comments'])){ echo $bill['Comments']; } else { echo "---"; } ?></td>
                            <td><?php if($bill['BillStatus'] == 'Y'){ echo "Report Concluded and Signed"; } else if($bill['BillStatus'] == 'N'){ echo "Report Not Concluded"; } else if($bill['BillStatus'] == 'D'){ echo "Report in Draft Form"; } ?></td>
                            <td><?php echo $bill['Fullname']; ?></td>
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
                    <h4 class="modal-title" id="myModalLabel33">Add New Processed Bill </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <i class="bx bx-x"></i>
                    </button>
                  </div>
                  <form method="post" action="<?php echo base_url(); ?>bills/add_bill">
                    <div class="modal-body">

                      <label>Date of 1st Hearing: </label>
                      <div class="form-group mb-0">
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control pickadate-months-year" placeholder="Select Date" name="DateProcessed">
                            <div class="form-control-position">
                              <i class='bx bx-calendar'></i>
                            </div>
                          </fieldset>
                      </div>

                      <label>Session: </label>
                      <div class="form-group">
                       <select class="select2 form-control" name="SessionID">
                          <option value="" disabled="" selected="">--Select Session--</option>
                          <?php foreach($sessions as $session){ ?>
                            <option value="<?php echo $session['EntryID']; ?>"><?php echo $session['SessionName']; ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <label>Committee: </label>
                      <div class="form-group">
                        <select class="select2 form-control" name="CommitteeID">
                          <option value="" disabled="" selected="">--Select Committee--</option>
                          <?php foreach($committees as $committee){ ?>
                            <option value="<?php echo $committee['EntryID']; ?>"><?php echo $committee['Title']; ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <label>Bill Name: </label>
                      <div class="form-group mb-0">
                        <input type="text" placeholder="Bill Name" class="form-control" name="BillName">
                      </div>

                      <label>Bill Type: </label>
                      <div class="form-group">
                        <select class="select2 form-control" name="BillType">
                          <option value="1">Private Members Bill</option>
                          <option value="2">Government Bill</option>
                        </select>
                      </div>

                      <label>Report Status: </label>
                      <div class="form-group">
                        <select class="select2 form-control" name="BillStatus">
                          <option value="Y">Report Concluded and Signed</option>
                          <option value="D">Report In Draft Form</option>
                          <option value="N">Report Not Available</option>
                        </select>
                      </div>

                      <label>Comments: </label>
                      <div class="form-group mb-0">
                        <textarea class="form-control" rows="1" name="Comments" placeholder="Enter Comments"></textarea>
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                      </button>
                      <button type="submit" name="savebill" value="Save" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add Bill</span>
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