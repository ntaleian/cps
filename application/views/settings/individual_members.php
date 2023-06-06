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
                            <th>MpID</th>
                            <th>Remove</th>
                            <th>Name</th>
                            <th>Party</th>
                            <th>Constituency</th>
                            <th>District</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $counter = 1; 
                            if(!empty($members)){
                            foreach($members as $mp){ ?>
                              <tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $mp['EntryID']; ?></td>
                                <?php 
                                  $mpID = $mp['EntryID'];
                                  $commID = $committeeid;
                                ?>
                                <td><a href="<?php echo base_url(); ?>settings/remove_individual_member?id=<?php echo $mpID; ?>&comm=<?php echo $commID; ?>" class="btn btn-icon rounded-circle btn-danger mr-1 mb-1"><i class="bx bx-x" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove from <?php echo $committee; ?>"></i></a></td>
                                <td><?php echo $mp['Name']; ?></td>
                                <td><?php echo $mp['Party']; ?></td>
                                <td><?php echo $mp['Constituency']; ?></td>
                                <td><?php echo $mp['District']; ?></td>
                              </tr>
                            <?php 
                                $counter++;
                              }
                            }
                            else
                            {
                              echo "<span style='color: red;'>There are no members in this committee yet.</span>";
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