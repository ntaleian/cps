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
                      Attendance Reports (Session)
                    </h4>
                  </div>

                  <form id="oversightForm" class="form" action="<?php echo base_url() ?>session_reports/attendance_report" method="get">

                    <div class="row col-12">

                      <div class="col-6">
                        <h6>Choose Session</h6>
                        <div class="form-group">
                          <select class="select2 form-control" name="session_id" required>
                            <option disabled="" selected=""> -- Select Session -- </option>
                            <?php
                              if(!empty($sessions))
                              {
                                foreach($sessions as $session){
                            ?>
                            <option value="<?php echo $session['EntryID']; ?>"><?php echo $session['SessionName'] ?></option>
                            <?php
                                }
                              }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-3">
                        <div style="top: 12px;">&nbsp;</div>
                        <button type="submit" name="submit" value="submit" class="btn btn-primary mr-1">Generate Report</button>
                      </div>

                    </div>
                  </form>

                  <div class="col-12">
                    <div class="alert bg-rgba-primary mb-0" role="alert">
                      <div class="d-flex align-items-center">
                        <i class="bx bx-line-chart"></i>
                        <span>
                          <?php echo $msg; ?>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      Committees List
                    </p>
                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Committee Name</th>
                            <th>Category</th>
                            <th>Members</th>
                            <th>Sittings</th>
                            <th>Attendance(%)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $counter = 1; 
                            foreach($committees as $committee){ ?>
                              <tr>
                                <td><?php echo $counter; ?></td>
                                <?php 
                                  $commID = $committee['EntryID'];
                                  if(!empty($_GET['session_id']))
                                  {
                                    $session = $_GET['session_id'];

                                    $url_txt = "&session=".$session;

                                  }
                                  else
                                  {
                                    $url_txt = "&session=".get_current_session($this);
                                  }
                                 ?>
                                <td><a href="<?php echo base_url(); ?>session_reports/view_sittings?id=<?php echo $commID.$url_txt; ?>"><?php echo $committee['Title']; ?></a></td>
                                <td><?php echo $committee['Category']; ?></td>
                                <td><?php echo $committee['NoOfMembers']; ?></td>
                                <td><?php echo $committee['TimesSat']; ?></td>
                                <?php

                                  if(isset($_GET['submit']))
                                  {

                                    $session = $_GET['session_id'];

                                    $qstr = "a.SessionID='".$session."' AND ";
                                  }
                                  else
                                  {
                                    $qstr = "a.SessionID='".get_current_session($this)."' AND ";
                                  }

                                  $query = $this->db->query("SELECT a.CommitteeID, a.SittingID, COUNT(a.SittingID) AS NoOfMps from attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID where a.SittingID=s.EntryID AND ".$qstr." a.AttendanceStatus='present' AND a.CommitteeID='".$committee['EntryID']."' group by a.CommitteeID, a.SittingID");
                                  if($query->num_rows() > 0){
                                    $query_res = $query->result_array();

                                    $total = 0;
                                    $sum = 0;
                                    $counter = 0;

                                    foreach($query_res as $row)
                                    {
                                      $total = $total + $row['NoOfMps'];

                                      $counter++;
                                    }

                                    $per = ($total/($counter*$committee['NoOfMembers']))*100;

                                  }
                                  else
                                  {
                                    $per = 0;
                                  }


                                ?>
                                <td><?php if($per <= 50){ echo "<span class='text-danger'>".number_format($per, 0)." %"; } else { echo number_format($per, 0)." %"; } ?></td>
                              </tr>
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