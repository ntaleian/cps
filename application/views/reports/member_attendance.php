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
                      Committee Members List
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      <?php echo $page_title; ?>
                    </p>

                    <form id="userForm" action="<?php echo base_url() ?>settings/do_assign_user" method="post">

                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>MP</th>
                            <th>Status</th>
                            <th>Sitting Date</th>
                            <th>Apology</th>
                            <th>Apology Reason</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $counter = 1; 
                            foreach($members as $member){ ?>
                              <tr>
                                <td><?php echo $counter; ?></td>
                                <td><a href="#"><?php echo $member['Name']; ?></a></td>
                                <td><?php if($member['AttendanceStatus'] == 'present'){ echo "Present"; } else if($member['AttendanceStatus'] == 'absent'){ echo "Absent"; } else { echo "Absent With Apology"; } ?></td>
                                <td><?php echo date('l jS F Y', strtotime($member['SittingDate'])); ?></td>
                                <td><?php echo $member['ApologyCategory']; ?></td>
                                <td><?php echo $member['ApologyDetails']; ?></td>
                                <td>
                                  <?php if($this->sys->check_access($member['CommitteeID'])){ ?>
                                  <span data-toggle="modal" data-target="#edit_att-<?php echo $member['EntryID']; ?>"><a href="javascript:void(0)" class="btn btn-icon rounded-circle btn-outline-primary mr-1 mb-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Record"><i class="bx bx-edit"></i></a></span>
                                  <?php } ?>
                                </td>
                              </tr>

                               <!-- Modal Add Category -->
                                    <div class="modal fade none-border" id="edit_att-<?php echo $member['EntryID']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><strong>Edit</strong> Attendance Record</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="<?php echo base_url(); ?>reports/update_attendance">
                                                        <div class="row">

                                                          <input type="hidden" name="AttID" value="<?php echo $member['EntryID']; ?>">
                                                          <input type="hidden" name="UrlID" value="<?php echo $id; ?>">

                                                            <div class="col-md-12" style="margin-bottom: 1em;">
                                                                <label class="control-label">MP Name</label>
                                                                <input class="form-control form-white" value="<?php echo $member['Name']; ?>" type="text" name="MPName" readonly />
                                                            </div>

                                                            <div class="col-md-12">
                                                               <label class="control-label">Attendance Status</label>
                                                                <select class="form-control form-white" name="AttendanceStatus">
                                                                    <option value="present" <?php if($member['AttendanceStatus'] == 'present'){ echo "selected"; } else { echo ""; } ?> >Present</option>
                                                                    <option value="absent" <?php if($member['AttendanceStatus'] == 'absent'){ echo "selected"; } else { echo ""; } ?> >Absent</option>
                                                                    <option value="awo" <?php if($member['AttendanceStatus'] == 'awo'){ echo "selected"; } else { echo ""; } ?> >Absent With Apology</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-12">
                                                            <br/><br/>
                                                              <input type="submit" name="updatesit" value="Update Attendance Record" class="btn btn-success mr-10 badge-pill font-14">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END MODAL -->

                            <?php 
                                $counter++;
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