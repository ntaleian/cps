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
                      Add Travel Abroad Record
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      <?php echo $committee; ?>
                    </p>

                    <form id="benchmarkForm" class="form" action="#" method="post">

                    <div class="row">

                      <input type="hidden" name="SessionID" value="<?php echo $SessionID; ?>">

                      <input type="hidden" name="CommitteeID" value="<?php echo $CommitteeID; ?>">

                      <div class="col-3">
                        <div class="form-label-group">
                          <input type="text" id="VisitTitle" class="form-control" placeholder="Travel Abroad Description"
                            name="VisitTitle">
                          <label for="VisitTitle">Travel Abroad Description</label>
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="form-label-group">
                          <input type="number" id="VisitAmount" class="form-control" placeholder="Amount Used"
                             name="VisitAmount">
                          <label for="VisitAmount">Amount Used</label>
                        </div>
                      </div>

                      <div class="col-3">
                          <fieldset class="form-group position-relative has-icon-left">
                              <input type="text" class="form-control daterange" placeholder="Select Date" id="VisitDate" name="VisitDate">
                              <div class="form-control-position">
                                  <i class='bx bx-calendar-check'></i>
                              </div>
                          </fieldset>
                        </div>

                      <div class="col-3">
                        <div class="form-group">
                          <select class="select2 form-control" name="ReportStatus" id="ReportStatus">
                            <option value="" disabled selected>---Choose Report Status---</option>
                            <option value="Y">Report Concluded and Signed</option>
                            <option value="D">Report In Draft Form</option>
                            <option value="N">Report Not Available</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-1">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary mr-1">Save</button>
                      </div>

                    </div>

                    <div class="table-responsive">
                      <table id="benchmarkTable" class="table table-striped">
                        <thead>
                          <tr>
                            <th>Present</th>
                            <th>#</th>
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
                            foreach($members as $mp){
                          ?>
                              <tr>
                                <td><input type="checkbox" class="sub_check" data-id="<?php echo $mp['EntryID']; ?>" name='mps_id[]'  data-checkbox="icheckbox_flat-red" value="<?php echo $mp['EntryID']; ?>"></td>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $mp['Name']; ?></td>
                                <td><?php echo $mp['Party']; ?></td>
                                <td><?php echo $mp['Constituency']; ?></td>
                                <td><?php echo $mp['District']; ?></td>
                              </tr>
                          <?php
                                }
                              }
                          ?>
                        </tbody>
                      </table>
                    </div>

                  </form>

                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- start add oversight -->

          <script type="text/javascript">
            
            $(document).ready(function(){

              var table2 = $('#benchmarkTable').DataTable({
                dom:"Bfrtip",
                buttons:[
                    {extend: 'excelHtml5',text: 'Save as Excel'},
                    {extend:"copyHtml5",exportOptions:{columns:[0,":visible"]}},
                    {extend:"pdfHtml5",exportOptions:{columns:":visible"}},
                    {text:"JSON",action:function(a,o,t,r){var e=o.buttons.exportData();$.fn.dataTable.fileSave(new Blob([JSON.stringify(e)]),"Export.json")}},
                    {extend:"print",exportOptions:{columns:":visible"}}
                  ]
              });

              $('#benchmarkForm').on('submit', function(e){

                  var url2 = "<?php echo base_url(); ?>travel/api_add_benchmark";

                  console.log('clicked' + url2);

                  e.preventDefault();

                  var formdata = table2.$('input,select,text,hidden').serializeArray();

                  // console.log('FromDate' + $('#min-dates').val());
                  var FromDate = $('#FromDate').val();
                  var ToDate = $('#VisitDate').val();
                  var VisitTitle = $('#VisitTitle').val();
                  var ReportStatus = $('#ReportStatus').val();
                  var VisitAmount = $('#VisitAmount').val();

                  formdata.push(

                  {'name' : 'SessionID', 'value' : '<?php echo $SessionID; ?>'},
                  {'name' : 'CommitteeID', 'value' : '<?php echo $CommitteeID; ?>'},
                  {'name' : 'FromDate', 'value' : FromDate},
                  {'name' : 'ToDate', 'value' : ToDate},
                  {'name' : 'VisitTitle', 'value' : VisitTitle},
                  {'name' : 'VisitAmount', 'value' : VisitAmount},
                  {'name' : 'ReportStatus', 'value' : ReportStatus}

                  );

                  console.log(formdata);

                  $.ajax({
                      url:url2,
                      type: "POST",
                      data: formdata,
                      dataType: 'json',
                      success: function(response){

                          var len = response.length;

                          console.log(response);

                          if(response.message === "true"){
                            document.location.href = "<?php echo base_url(); ?>travel/travel_abroad";
                          }
                          else
                          {
                            $('#show_id').html("<div style='border:1px solid red;font-size: 11px;margin:0 auto !important;'> Failed to Add Travel Abroad Data. </div>")
                          }

                          
                      }
                  });
                  
              });

            });

          </script>

          <!-- end add oversight -->

        </div>
      </div>
    </div>
    <!-- END: Content-->