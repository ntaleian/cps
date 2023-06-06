<!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
  <div class="row">
    <!-- Website Analytics Starts-->
    <div class="col-md-9 col-sm-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Sittings per Committee</h4>
          <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
        </div>
        <div class="card-body pb-1">
          <div class="d-flex justify-content-around align-items-center flex-wrap">
          </div>
          <div class="height-400">
            <canvas id="simple-pie-chart"></canvas>
          </div>
        </div>
      </div>

    </div>

    <div class="col-xl-3 col-md-12 col-sm-12">
      <div class="row">
        <!-- Conversion Chart Starts-->
        <div class="col-xl-12 col-md-6 col-12">
          <div class="row">
            <div class="col-12">
                <a href="<?php echo base_url(); ?>reports/attendance_report">
                  <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                          <div class="avatar-content">
                            <i class="bx bx-user text-primary font-medium-2"></i>
                          </div>
                        </div>
                        <div class="total-amount">
                          <h5 class="mb-0"><?php echo $sittings; ?></h5>
                          <small class="text-muted">Total Sittings</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
            </div>

            <?php 
            $Usertype = $this->session->userdata('alluserdata')[0]['Usertype'];

            if($Usertype == "normal"){

            // foreach($committees as $committee){ ?>

            <div class="col-12">
              <div class="card">
                  <a href="#">
                    <div class="card-body d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                          <div class="avatar-content">
                            <i class="bx bxs-report text-primary font-medium-2"></i>
                          </div>
                        </div>
                        <div class="total-amount">
                          <h5 class="mb-0"><?php echo $total_reports; ?></h5>
                          <small class="text-muted">Total Reports</small>
                        </div>
                      </div>
                    </div>
                </a>
              </div>
            </div>

            <?php
              } else {
            ?>

            <div class="col-12">
              <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                      <div class="avatar-content">
                        <i class="bx bx-group text-primary font-medium-2"></i>
                      </div>
                    </div>
                    <div class="total-amount">
                      <h5 class="mb-0"><?php echo $users; ?></h5>
                      <small class="text-muted">Clerks</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php
              }
            ?>

          </div>
        </div>
        <div class="col-xl-12 col-md-6 col-12">
          <div class="row">
            <div class="col-12">
                <a href="<?php echo base_url(); ?>reports/field_trip_report">
                  <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                          <div class="avatar-content">
                            <i class="bx bx-car text-primary font-medium-2"></i>
                          </div>
                        </div>
                        <div class="total-amount">
                          <h5 class="mb-0"><?php echo $fieldtrips; ?></h5>
                          <small class="text-muted">Field Trips</small>
                        </div>
                      </div>
                    </div>
                  </div>
                 </a>
            </div>
            <div class="col-12">
                <a href="<?php echo base_url(); ?>reports/travels_abroad_report">
                  <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                          <div class="avatar-content">
                            <i class="bx bxs-plane-take-off text-primary font-medium-2"></i>
                          </div>
                        </div>
                        <div class="total-amount">
                          <h5 class="mb-0"><?php echo $travels; ?></h5>
                          <small class="text-muted">Travels Abroad</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</section>
<!-- Dashboard Analytics end -->

        </div>
      </div>
    </div>
    <!-- END: Content-->