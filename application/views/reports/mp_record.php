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
                      MP Report
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      <?php echo $page_title; ?>
                    </p>

                    <div class="col-12 col-md-12">
                      <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td><strong>MP's Name:</strong></td>
                            <td><?php echo $mp_record['Name']; ?></td>
                            <td><strong>Political Party:</strong></td>
                            <td><?php echo $mp_record['Party']; ?></td>
                          </tr>
                          <tr>
                            <td><strong>Constituency:</strong></td>
                            <td><?php echo $mp_record['Constituency']; ?></td>
                            <td><strong>District:</strong></td>
                            <td class="users-view-role"><?php echo $mp_record['District']; ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Committee Name</th>
                            <th>Category</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>A.W.A</th>
                            <th>T.As</th>
                            <th>F.Ts</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $counter = 1; 
                            if(!empty($committees)){
                            foreach($committees as $committee){
                                //get counts
                                $getQry = $this->db->query("SELECT u.*, (SELECT COUNT(EntryID) FROM attendance WHERE CommitteeID='".$committee['EntryID']."' AND MpID='$mpid' AND AttendanceStatus='present') Present, (SELECT COUNT(EntryID) FROM attendance WHERE CommitteeID='".$committee['EntryID']."' AND MpID='$mpid' AND AttendanceStatus='absent') Absent, (SELECT COUNT(EntryID) FROM attendance WHERE CommitteeID='".$committee['EntryID']."' AND MpID='$mpid' AND AttendanceStatus='awo') Awo, (SELECT COUNT(m.EntryID) FROM benchmarking_members m LEFT JOIN benchmarking_visits b ON m.BenchmarkID=b.EntryID WHERE m.BenchmarkID=b.EntryID AND b.CommitteeID='".$committee['EntryID']."' AND m.MpID='$mpid') Travels, (SELECT COUNT(m.EntryID) FROM oversight_members m LEFT JOIN oversight_visits o ON m.OversightID=o.EntryID WHERE m.OversightID=o.EntryID AND o.CommitteeID='".$committee['EntryID']."' AND m.MpID='$mpid') FieldTrips FROM mps u WHERE EntryID='$mpid'");
                                $getRes = $getQry->row_array();

                                // print_r($getRes); exit;
                             ?>
                              <tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $committee['Title']; ?></td>
                                <td><?php echo $committee['Category']; ?></td>
                                <td><?php echo $getRes['Present']; ?></td>
                                <td><?php echo $getRes['Absent']; ?></td>
                                <td><?php echo $getRes['Awo']; ?></td>
                                <td><?php echo $getRes['Travels']; ?></td>
                                <td><?php echo $getRes['FieldTrips']; ?></td>
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