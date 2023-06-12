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
                      Bills Reports
                    </h4>
                  </div>

                  <form id="oversightForm" class="form" action="<?php echo base_url() ?>session_reports/bills_report" method="get">

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
                            <th>No of Bills</th>
                            <th>Report Concluded</th>
                            <th>Report in Draft</th>
                            <th>No Report</th>
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
                                  $commTitle = $committee['Title'];

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
                                <td><a href="<?php echo base_url(); ?>session_reports/view_committee_bills?id=<?php echo $commID; ?>&committee=<?php echo $commTitle.$url_txt; ?>"><?php echo $committee['Title']; ?></a></td>
                                <td><?php echo $committee['Category']; ?></td>
                                <td><?php echo $committee['BillsCount']; ?></td>
                                <td><?php echo $committee['ReportConcluded']; ?></td>
                                <td><?php echo $committee['ReportDraft']; ?></td>
                                <td><?php echo $committee['NoReport']; ?></td>
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