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
                      Manage Sessions List
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      Sessions
                    </p>

                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Is Active</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(!empty($sessions)){
                            $counter = 1; 
                            foreach($sessions as $row){ ?>
                              <tr>
                                <td><?php echo $counter; ?></td>

                                <td><a href="<?php echo base_url(); ?>settings/edit_session?id=<?php echo $row['EntryID']; ?>"><?php echo $row['SessionName']; ?></a></td>
                                <td><?php echo $row['StartDate']; ?></td>
                                <td><?php echo $row['EndDate']; ?></td>
                                <td><?php if($row['IsActive'] == 'Y'){ echo "Yes"; } else if($row['IsActive'] == 'N'){ echo "No"; } ?></td>
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