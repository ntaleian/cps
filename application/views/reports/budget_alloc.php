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
                      Travels Abroad Reports
                    </h4>
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
                            <th>FT Allocation</th>
                            <th>FT Exp</th>
                            <th>FT Bal</th>
                            <th>TA Allocation</th>
                            <th>TA Exp</th>
                            <th>TA Bal</th>
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
                                ?>
                                <td><a href="javascript:void(0);"><?php echo $committee['Title']; ?></a></td>
                                <td><?php echo $committee['Category']; ?></td>
                                <td><?php echo number_format($committee['FTTotal']); ?></td>
                                <td><?php echo number_format($committee['FieldAmt']); ?></td>
                                <td><?php echo number_format($committee['FTTotal'] - $committee['FieldAmt']); ?></td>
                                <td><?php echo number_format($committee['TATotal']); ?></td>
                                <td><?php echo number_format($committee['TravelAmt']); ?></td>
                                <td><?php echo number_format($committee['TATotal'] - $committee['TravelAmt']); ?></td>
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