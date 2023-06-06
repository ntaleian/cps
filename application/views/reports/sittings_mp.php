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
                      Attendance Report
                    </h4>
                  </div>

                  <?php
                    if(!empty($_GET['start'])){
                  ?>
                  <div class="col-12">
                    <div class="alert bg-rgba-primary mb-0" role="alert">
                      <div class="d-flex align-items-center">
                        <i class="bx bx-line-chart"></i>
                        <span>
                          <?php echo "Attendance by MPs Report From ".$_GET['start']." To ".$_GET['end']; ?>
                        </span>
                      </div>
                    </div>
                  </div>
                  <?php
                    }
                  ?>

                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      <?php echo $page_title; ?>
                    </p>

                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>MP ID</th>
                            <th>MP Name</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>A.W.A</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $counter = 1; 
                            foreach($sittings as $sitting){ ?>
                              <tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $sitting['MpID']; ?></td>
                                <td><?php echo $sitting['Name']; ?></td>
                                <td><?php echo $sitting['present']; ?></td>
                                <td><?php echo $sitting['absent']; ?></td>
                                <td><?php echo $sitting['awo']; ?></td>
                                <?php $total = $sitting['present'] + $sitting['absent'] + $sitting['awo']; ?>
                                <td><?php echo $total; ?></td>
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