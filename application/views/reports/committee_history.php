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
                      MP Committee History Report
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
                            <th>MP Code</th>
                            <th>MP Name</th>
                            <th>Current Committees</th>
                            <th>Movements</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $counter = 1; 
                            if(!empty($committees)){
                            foreach($committees as $committee){
                             ?>
                              <tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $committee['Code']; ?></td>
                                <td><a href="<?php echo base_url(); ?>reports/history_details?id=<?php echo $committee['MpID']; ?>">
                                  <?php echo $committee['Name']; ?>
                                </a></td>
                                <td><?php echo $committee['Comms']; ?></td>
                                <td><?php echo $committee['Movs']; ?></td>
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