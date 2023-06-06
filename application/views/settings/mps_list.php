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
                      MPs List
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      View MPs List
                    </p>
                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>MP ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Party</th>
                            <th>Constituency</th>
                            <th>District</th>
                            <th>Session</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                            if(!empty($mps)){
                            $counter = 1; 
                            foreach($mps as $mp){ ?>
                              <tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $mp['EntryID']; ?></td>
                                <td><?php if(!empty($mp['Code'])){ echo $mp['Code']; } else { echo "---"; } ?></td>
                                <td><?php echo $mp['Name']; ?></td>
                                <td><?php echo $mp['Party']; ?></td>
                                <td><?php echo $mp['Constituency']; ?></td>
                                <td><?php echo $mp['District']; ?></td>
                                <td><?php echo $mp['SessionName']; ?></td>
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