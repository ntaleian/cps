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
                      Field Trips Report
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
                            <th>Name</th>
                            <th>Amount</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Committee</th>
                            <th>Report Status</th>
                            <th>Clerk</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                            if(!empty($oversight)){
                            $counter = 1; 
                            foreach($oversight as $bill){ ?>
                              <tr>
                                
                                <td><?php echo $bill['VisitTitle']; ?></td>
                                <td><?php if(empty($bill['Amount']) || $bill['Amount'] == ''){ echo '0'; } else { echo number_format($bill['Amount']); } ?></td>
                                <td><?php echo date('l jS F Y', strtotime($bill['FromDate'])); ?></td>
                                <td><?php echo date('l jS F Y', strtotime($bill['ToDate'])); ?></td>
                                <td><?php echo $bill['Title']; ?></td>
                                <td><?php if($bill['ReportStatus'] == 'Y'){ echo "Report Concluded and Signed"; } else if($bill['ReportStatus'] == 'N'){ echo "No Report"; } else if($bill['ReportStatus'] == 'D'){ echo "Report in Draft Form"; } ?></td>
                                <td><?php echo $bill['Fullname']; ?></td>
                                <td>

                                  

                                  <div class="btn-group" role="group" aria-label="Basic example">

                                    <?php if($this->sys->check_access($bill['CommitteeID'])){ ?>

                                    <span data-toggle="modal" data-target="#edit_ovs-<?php echo $bill['EntryID']; ?>"><button type="button" class="btn btn-sm btn-outline-secondary" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="bx bxs-edit"></i></button></span>

                                    <a href="<?php echo base_url(); ?>reports/edit_field_trip?id=<?php echo $bill['EntryID']; ?>&commid=<?php echo $bill['CommitteeID']; ?>" class="btn btn-sm btn-outline-secondary" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit MPs"><i class="bx bx-group"></i></a>

                                  <?php } ?>

                                    <span data-toggle="modal" data-target="#mps-<?php echo $bill['EntryID']; ?>"><button type="button" class="btn btn-sm btn-outline-primary"aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="View MPs"><i class="bx bx-window-open"></i></button></span>

                                    <?php if($this->sys->check_access($bill['CommitteeID'])){ ?>

                                    <span data-toggle="modal" data-target="#delete_ft-<?php echo $bill['EntryID']; ?>"><button type="button" class="btn btn-sm btn-outline-danger"aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="bx bx-x"></i></button></span>

                                    <?php } ?>

                                  </div>

                                </td>
                              </tr>

                              <!-- Modal Add Category -->
                                    <div class="modal fade none-border" id="mps-<?php echo $bill['EntryID']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><strong>Field Trip Attendance</strong> MPs</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                      $ct = 1;
                                                      $get = $this->db->query("SELECT mps.* FROM oversight_members LEFT JOIN mps ON oversight_members.MpID=mps.EntryID WHERE oversight_members.OversightID='".$bill['EntryID']."'");

                                                      if($get->num_rows() > 0)
                                                      {
                                                        $res = $get->result_array();
                                                      }
                                                      else
                                                      {
                                                        //do nothing
                                                      }

                                                      if(!empty($res))
                                                      {
                                                        foreach($res as $res_row)
                                                        {
                                                          echo $ct.". ".$res_row['Name']." - (".$res_row['Constituency']." ".$res_row['District'].") <br/>";
                                                          $ct++;
                                                        }
                                                      }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END MODAL -->

                                    <!-- Modal Add Category -->
                                    <div class="modal fade none-border" id="edit_ovs-<?php echo $bill['EntryID']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><strong>Edit</strong> Field Trip</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="<?php echo base_url(); ?>reports/update_oversight">
                                                        <div class="row">

                                                          <input type="hidden" name="EntryID" value="<?php echo $bill['EntryID']; ?>">
                                                          <input type="hidden" name="Url" value="<?php echo $url; ?>">
                                                          <input type="hidden" name="CommUrl" value="<?php echo $urlComm; ?>">

                                                            <div class="col-md-12 mb-2">
                                                                <label class="control-label">Field Trip Title</label>
                                                                <input class="form-control form-white" value="<?php echo $bill['VisitTitle']; ?>" type="text" name="VisitTitle" />
                                                            </div>

                                                            <div class="col-md-12 mb-2">
                                                               <label class="mt-10 font-12">From Date</label>
                                                               <input type="text" class="form-control mrdate" value="<?php echo date('Y-m-d', strtotime($bill['FromDate'])); ?>" id="mdat" name="FromDate">
                                                            </div>

                                                            <div class="col-md-12 mb-2">
                                                               <label class="mt-10 font-12">To Date</label>
                                                               <input type="text" class="form-control mrdate" value="<?php echo date('Y-m-d', strtotime($bill['ToDate'])); ?>" id="mdat" name="ToDate">
                                                            </div>

                                                            <div class="col-md-12 mb-2">
                                                                <label class="control-label">Field Trip Amount</label>
                                                                <input class="form-control form-white" value="<?php echo $bill['Amount']; ?>" type="text" name="Amount" />
                                                            </div>

                                                            <div class="col-md-12 mb-2">
                                                              <label class="control-label">Report Status</label>
                                                              <select class="form-control form-white" name="ReportStatus" id="ReportStatus">
                                                                  <option value="Y" <?php if($bill['ReportStatus'] == 'Y'){ echo "selected"; } ?> >Report Concluded and Signed</option>
                                                                  <option value="D" <?php if($bill['ReportStatus'] == 'D'){ echo "selected"; } ?> >Report in Draft Form</option>
                                                                  <option value="N" <?php if($bill['ReportStatus'] == 'N'){ echo "selected"; } ?> >Report Not Available</option>
                                                              </select>
                                                            </div>

                                                            <div class="col-md-12">
                                                            <br/><br/>
                                                              <input type="submit" name="updateovs" value="Update Field Trip Details" class="btn btn-success mr-10 badge-pill font-14">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END MODAL -->

                                    <!-- Modal Add Category -->
                                    <div class="modal fade none-border" id="delete_ft-<?php echo $bill['EntryID']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><strong>Delete</strong> Field Trip</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                               <p>Are you sure you want to delete the record for the date <em><?php echo date('l jS F Y', strtotime($bill['FromDate'])); ?></em> to <em><?php echo date('l jS F Y', strtotime($bill['ToDate'])); ?></em>?</p>
                                                            </div>                                        
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?php echo base_url(); ?>reports/delete_ft?id=<?php echo $bill['EntryID']; ?>&url=<?php echo $url; ?>&comm=<?php echo $urlComm; ?>" class="btn btn-danger mr-10 badge-pill font-14">Delete Field Trip</a>
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