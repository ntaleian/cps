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
                      Attendance Report
                    </h4>
                  </div>

                  <?php
                    if(!empty($_GET['start'])){
                  ?>
                  <div class="col-12">
                    <div class="alert bg-rgba-primary mb-0" role="alert">
                      <div class="d-flex align-items-center">
                        <i class="bx bx-line-chart"></i>
                        <span>
                          <?php echo "Attendance Report From ".$_GET['start']." To ".$_GET['end']; ?>
                        </span>
                      </div>
                    </div>
                  </div>
                  <?php
                    }
                  ?>

                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      <?php echo $page_title; ?>
                    </p>

                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>Topic Summary</th>
                            <th>Sitting Date</th>
                            <th>Category</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>A.W.A</th>
                            <th>Clerk</th>
                            <!--<th>Date Uploaded</th>-->
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $counter = 1; 
                          foreach($sittings as $sitting){ ?>
                            <tr>
                              <?php $sittID = $sitting['EntryID']; ?>
                              <td><?php echo $counter; ?></td>
                              <td>

                                <?php #if($this->sys->check_access($sitting['CommitteeID'])){ ?>

                                <div class="btn-group" role="group" aria-label="Basic example">

                                  <span data-toggle="modal" data-target="#edit_sitt-<?php echo $sitting['EntryID']; ?>"><button type="button" class="btn btn-sm btn-outline-secondary" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="bx bxs-edit"></i></button></span>

                                  <a href="<?php echo base_url(); ?>reports/view_member_attendance?id=<?php echo $sittID; ?>" class="btn btn-sm btn-outline-primary" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Record"><i class="bx bx-window-open"></i></a>

                                  <span data-toggle="modal" data-target="#delete_sitt-<?php echo $sitting['EntryID']; ?>"><button type="button" class="btn btn-sm btn-outline-danger"aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="bx bx-x"></i></button></span>

                                </div>

                                <?php #} ?>

                              </td>
                              <td><b><a href="<?php echo base_url(); ?>reports/view_member_attendance?id=<?php echo $sittID; ?>"><?php echo $sitting['SittingTitle']; ?></a></b></td>
                              <td><?php echo date('l jS F Y', strtotime($sitting['SittingDate'])); ?></td>
                              <td><?php if(empty($sitting['SittingCategory'])){ echo "<span class='text-danger'>Undefined</span>"; } else { echo $sitting['SittingCategory']; } ?></td>
                              <?php
                                $qry = $this->db->query("SELECT (SELECT COUNT(EntryID) FROM attendance WHERE SittingID='".$sitting['EntryID']."' AND AttendanceStatus='present') AS Present, (SELECT COUNT(EntryID) FROM attendance WHERE SittingID='".$sitting['EntryID']."' AND AttendanceStatus='absent') AS Absent, (SELECT COUNT(EntryID) FROM attendance WHERE SittingID='".$sitting['EntryID']."' AND AttendanceStatus='awo') AS Awo");

                                $res = $qry->row_array();
                              ?>
                              <td><?php echo $res['Present']; ?></td>
                              <td><?php echo $res['Absent']; ?></td>
                              <td><?php echo $res['Awo']; ?></td>
                              <td><?php echo $sitting['Fullname']; ?></td>
                              <!-- <td><?php #echo $sitting['TS']; ?></td> -->
                            </tr>

                              <!-- Modal Add Category -->
                                  <div class="modal fade none-border" id="edit_sitt-<?php echo $sitting['EntryID']; ?>">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h4 class="modal-title"><strong>Edit</strong> Sitting</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              </div>
                                              <div class="modal-body">
                                                  <form method="post" action="<?php echo base_url(); ?>reports/update_sitting">
                                                      <div class="row">

                                                        <input type="hidden" name="EntryID" value="<?php echo $sitting['EntryID']; ?>">
                                                        <input type="hidden" name="Url" value="<?php echo $url; ?>">

                                                          <div class="col-md-12 mb-2">
                                                              <label class="control-label">Sitting Summary Title</label>
                                                              <input class="form-control form-white" value="<?php echo $sitting['SittingTitle']; ?>" type="text" name="SittingTitle" />
                                                          </div>

                                                          <div class="col-md-12 mb-2">
                                                             <label class="mt-10 font-12">Sitting Date</label>
                                                             <input type="text" class="form-control mrdate" value="<?php echo date('Y-m-d', strtotime($sitting['SittingDate'])); ?>" id="mdat" name="SittingDate">
                                                          </div>

                                                          <div class="col-md-12">
                                                          <br/><br/>
                                                            <input type="submit" name="updatesit" value="Update Sitting" class="btn btn-success mr-10 badge-pill font-14">
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- END MODAL -->


                                  <!-- Modal Add Category -->
                                  <div class="modal fade none-border" id="delete_sitt-<?php echo $sitting['EntryID']; ?>">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h4 class="modal-title"><strong>Delete</strong> Sitting</h4>
                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              </div>
                                              <div class="modal-body">
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                             <p>Are you sure you want to delete the record for the date <em><?php echo date('l jS F Y', strtotime($sitting['SittingDate'])); ?></em>?</p>
                                                          </div>                                        
                                                      </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <a href="<?php echo base_url(); ?>reports/delete_sitting?id=<?php echo $sitting['EntryID']; ?>&url=<?php echo $url; ?>" class="btn btn-danger mr-10 badge-pill font-14">Delete Sitting</a>
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