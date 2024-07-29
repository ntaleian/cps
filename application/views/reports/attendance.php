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
                      Attendance Reports
                    </h4>
                  </div>

                  <form id="oversightForm" class="form" action="<?php echo base_url() ?>reports/attendance_report" method="get">

                    <div class="row col-12">

                      <input type="hidden" name="SessionID" value="<?php echo get_current_session($this); ?> ">

                      <div class="col-3">
                        <!-- <fieldset class="form-label-group position-relative has-icon-left">
                            <input type="text" class="form-control daterange" placeholder="Select Date" id="ReqDate" name="ReqDate">
                            <div class="form-control-position">
                                <i class='bx bx-calendar-check'></i>
                            </div>
                        </fieldset> -->
                        <fieldset class="form-group position-relative has-icon-left">
                          <label for="basicInput">Start Date</label>
                            <input type="text" class="form-control single-daterange" value="" name="FromDate">
                            <div class="form-control-position">
                                <i class='bx bx-calendar-check' style="top: 20px !important"></i>
                            </div>
                        </fieldset>
                      </div>
                      <div class="col-3">
                        <fieldset class="form-group position-relative has-icon-left">
                          <label for="basicInput">End Date</label>
                            <input type="text" class="form-control single-daterange" value="" name="ToDate">
                            <div class="form-control-position">
                                <i class='bx bx-calendar-check' style="top: 20px !important"></i>
                            </div>
                        </fieldset>
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
                            <th>Latest</th>
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
                                  if(!empty($_GET['FromDate']))
                                  {
                                    $from = $_GET['FromDate'];
                                    $to = $_GET['ToDate'];
                                    $end = date('Y-m-d', strtotime($to));
                                    $start = date('Y-m-d', strtotime($from));

                                    $url_txt = "&start=".$start."&end=".$end;

                                  }
                                  else
                                  {
                                    $url_txt = "";
                                  }
                                 ?>
                                <td><a href="<?php echo base_url(); ?>reports/view_sittings?id=<?php echo $commID.$url_txt; ?>"><?php echo $committee['Title']; ?></a></td>
                                <td><?php echo $committee['Category']; ?></td>
                                <td><?php echo $committee['NoOfMembers']; ?></td>
                                <td><?php echo $committee['TimesSat']; ?></td>
                                <?php

                                  if(isset($_GET['submit']))
                                  {

                                    $daterange = $_GET['ReqDate'];
                                    $end = date('Y-m-d', strtotime(substr($daterange, 13, 10)));
                                    $start = date('Y-m-d', strtotime(substr($daterange, 0, 10)));

                                    $qstr = "DATE(SittingDate) >= '".date('Y-m-d', strtotime($start))."' AND DATE(SittingDate) <= '".date('Y-m-d', strtotime($end))."' AND ";
                                  }
                                  else
                                  {
                                    $qstr = "";
                                  }

                                  $query = $this->db->query("SELECT a.CommitteeID, a.SittingID, COUNT(a.SittingID) AS NoOfMps from attendance a LEFT JOIN sittings s ON a.SittingID=s.EntryID where a.SittingID=s.EntryID AND ".$qstr." a.AttendanceStatus='present' AND a.CommitteeID='".$committee['EntryID']."' AND a.SessionID='".get_current_session($this)."' group by a.CommitteeID, a.SittingID");
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
                                <td><?php echo $committee['LatestDate']; ?></td>
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