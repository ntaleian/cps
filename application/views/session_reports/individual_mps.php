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
                      Individual MPs Reports
                    </h4>
                  </div>

                  <form id="oversightForm" class="form" action="<?php echo base_url() ?>session_reports/mps_report" method="get">

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
                            <th>Name</th>
                            <th>Party</th>
                            <th>Constituency</th>
                            <th>District</th>
                            <th>Committees</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>A.W.A</th>
                            <th>F.Ts</th>
                            <th>T.As</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(!empty($mps)){
                            $counter = 1; 
                            foreach($mps as $mp){ ?>
                              <tr>
                                <td><?php echo $counter; ?></td>
                                <?php 

                                  $mpID = $mp['EntryID'];
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
                                <td><a href="<?php echo base_url(); ?>session_reports/view_mp_record?id=<?php echo $mpID.$url_txt; ?>"><?php echo $mp['Name']; ?></a></td>
                                <td><?php echo $mp['Party']; ?></td>
                                <td><?php echo $mp['Constituency']; ?></td>
                                <td><?php echo $mp['District']; ?></td>
                                <td><?php echo $mp['NoOfCommittees']; ?></td>
                                <td><?php echo $mp['Present']; ?></td>
                                <td><?php echo $mp['Absent']; ?></td>
                                <td><?php echo $mp['Awo']; ?></td>
                                <td><?php echo $mp['FieldTrips']; ?></td>
                                <td><?php echo $mp['TravelsAbroad']; ?></td>
                              </tr>
                            <?php 
                                $counter++;
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



        </div>
      </div>
    </div>
    <!-- END: Content-->