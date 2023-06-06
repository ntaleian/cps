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
                      Committee Bills Report
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      <?php echo $page_title; ?>
                    </p>

                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date of 1st Hearing</th>
                            <th>Committee</th>
                            <th>Report Status</th>
                            <th>Clerk in Charge</th>
                            <th>Edit</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                              if(!empty($bills)){
                              $counter = 1; 
                              foreach($bills as $bill){ ?>
                                <tr>
                                  <td><?php echo $counter; ?></td>
                                  <td><?php echo $bill['BillName']; ?></td>
                                  <td><?php echo date('l jS F Y', strtotime($bill['DateProcessed'])); ?></td>
                                  <td><?php echo $bill['Title']; ?></td>
                                  <td><?php if($bill['BillStatus'] == 'Y'){ echo "Report Concluded and Signed"; } else if($bill['BillStatus'] == 'N'){ echo "Report Not Concluded"; } else if($bill['BillStatus'] == 'D'){ echo "Report in Draft Form"; } ?></td>
                                  <td><?php echo $bill['Fullname']; ?></td>
                                  <td>

                                    <?php if($this->sys->check_access($bill['CommitteeID'])){ ?>

                                    <div class="btn-group" role="group" aria-label="Basic example">

                                      <span data-toggle="modal" data-target="#edit_bill-<?php echo $bill['EntryID']; ?>"><button type="button" class="btn btn-outline-secondary" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="bx bxs-edit"></i></button></span>

                                      <span data-toggle="modal" data-target="#delete_bill-<?php echo $bill['EntryID']; ?>"><button type="button" class="btn btn-outline-danger"aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="bx bx-x"></i></button></span>

                                    </div>

                                    <?php } ?>

                                  </td>
                                </tr>

                                 <!-- Modal Add Category -->
                                      <div class="modal fade none-border" id="edit_bill-<?php echo $bill['EntryID']; ?>">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title"><strong>Edit</strong> Bill</h4>
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <form method="post" action="<?php echo base_url(); ?>reports/update_bill">
                                                          <div class="row">

                                                            <input type="hidden" name="EntryID" value="<?php echo $bill['EntryID']; ?>">
                                                            <input type="hidden" name="Url" value="<?php echo $url; ?>">
                                                            <input type="hidden" name="CommUrl" value="<?php echo $urlComm; ?>">

                                                              <div class="col-md-12">
                                                                  <label class="control-label">Bill Name</label>
                                                                  <input class="form-control form-white" value="<?php echo $bill['BillName']; ?>" type="text" name="BillName" />
                                                              </div>

                                                              <div class="col-md-12">
                                                                 <label class="mt-10 font-12">Date of 1st Hearing</label>
                                                                 <input type="text" class="form-control mrdate" value="<?php echo date('Y-m-d', strtotime($bill['DateProcessed'])); ?>" id="mdat" name="DateProcessed">
                                                              </div>

                                                              <div class="col-md-12">
                                                                <label class="control-label">Report Status</label>
                                                                <select class="form-control form-white" name="BillStatus" id="BillStatus">
                                                                    <option value="Y" <?php if($bill['BillStatus'] == 'Y'){ echo "selected"; } ?> >Report Concluded and Signed</option>
                                                                    <option value="D" <?php if($bill['BillStatus'] == 'D'){ echo "selected"; } ?> >Report in Draft Form</option>
                                                                    <option value="N" <?php if($bill['BillStatus'] == 'N'){ echo "selected"; } ?> >Report Not Available</option>
                                                                </select>
                                                              </div>

                                                              <div class="col-md-12">
                                                              <br/><br/>
                                                                <input type="submit" name="updatetas" value="Update Bill Details" class="btn btn-success mr-10 badge-pill font-14">
                                                              </div>
                                                          </div>
                                                      </form>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <!-- END MODAL -->

                                      <!-- Modal Add Category -->
                                      <div class="modal fade none-border" id="delete_bill-<?php echo $bill['EntryID']; ?>">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title"><strong>Delete</strong> Bill</h4>
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                  </div>
                                                  <div class="modal-body">
                                                          <div class="row">
                                                              <div class="col-md-12">
                                                                 <p>Are you sure you want to delete the record for the date <em><?php echo date('l jS F Y', strtotime($bill['DateProcessed'])); ?></em>?</p>
                                                              </div>                                        
                                                          </div>
                                                  </div>
                                                  <div class="modal-footer">
                                                      <a href="<?php echo base_url(); ?>reports/delete_bill?id=<?php echo $bill['EntryID']; ?>&url=<?php echo $url; ?>&comm=<?php echo $urlComm; ?>" class="btn btn-danger mr-10 badge-pill font-14">Delete Bill</a>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <!-- END MODAL -->


                              <?php 
                                  $counter++;
                                }
                              } else
                              {
                                // echo "No bills entered into the system yet";
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

        </div>
      </div>
    </div>
    <!-- END: Content-->