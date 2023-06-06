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
                      Budget Allocation
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      Committees Budget Allocation
                    </p>
                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Field Trips</th>
                            <th>Travels Abroad</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $counter = 1; 
                            foreach($committees as $committee){ ?>
                              <tr>
                                <td><?php echo $counter; ?></td>
                                <?php $commID = $committee['EntryID']; $committeeid = $committee['EntryID']; ?>
                                <td><a href="#"><?php echo $committee['Title']; ?></a></td>
                                <td><?php echo $committee['Category']; ?></td>
                                <td><?php if(!empty($committee['FT'])) { echo "<a href='".base_url()."settings/edit_money?id=".$committeeid."&alloc=FT' data-toggle='tooltip' data-placement='top' title='' data-original-title='Click to Edit'>".number_format($committee['FT'])."</a>"; } else { echo "<a href='".base_url()."settings/add_money?id=".$committeeid."&alloc=FT' class='btn btn-outline-info btn-sm round mr-1 mb-1'>Add Allocation</a>"; } ?> </td>
                                <td><?php if(!empty($committee['TA']) ) { echo "<a href='".base_url()."settings/edit_money?id=".$committeeid."&alloc=TA' data-toggle='tooltip' data-placement='top' title='' data-original-title='Click to Edit'>".number_format($committee['TA'])."</a>"; } else { echo "<a href='".base_url()."settings/add_money?id=".$committeeid."&alloc=TA' class='btn btn-outline-info btn-sm round mr-1 mb-1'>Add Allocation</a>"; } ?> </td>
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