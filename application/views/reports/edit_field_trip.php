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
                      Edit Field Trip Record
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      <?php echo $committee; ?>
                    </p>

                  <form id="oversightForm" class="form" action="#" method="post">

                    <div class="row">

                      <input type="hidden" name="EntryID" value="<?php echo $ft_id; ?>">
                      <input type="hidden" name="SessionID" value="<?php echo $session_id; ?>">
                      <input type="hidden" name="CommitteeID" value="<?php echo $comm_id; ?>">

                      <button class="btn btn-outline-secondary mr-1 mb-1" type="submit" name="update" value="update">Update Field Trip Attendance</button>
                      <br/><br/>
                      
                    </div>

                    <div class="table-responsive">
                      <table id="oversightTable" class="table table-striped">
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
                                <?php
                                    $key = "";
                                    $search = array_search($mp['EntryID'], array_column($attendees, 'MpID'));
                                    // if($search != '')
                                    // {
                                    //   echo "Search Result: ".$attendees[$search]['MpID'];
                                    // }
                                    
                                ?>
                                <td><input type="checkbox" class="sub_check" data-id="<?php echo $mp['EntryID']; ?>" name='mps_id[]'  data-checkbox="icheckbox_flat-red" value="<?php echo $mp['EntryID']; ?>" <?php if($attendees[$search]['MpID'] == $mp['EntryID']){ echo 'checked'; } else { echo ''; } ?> ></td>
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

              var table2 = $('#oversightTable').DataTable({
                dom:"Bfrtip",
                buttons:[
                    {extend: 'excelHtml5',text: 'Save as Excel'},
                    {extend:"copyHtml5",exportOptions:{columns:[0,":visible"]}},
                    {extend:"pdfHtml5",exportOptions:{columns:":visible"}},
                    {text:"JSON",action:function(a,o,t,r){var e=o.buttons.exportData();$.fn.dataTable.fileSave(new Blob([JSON.stringify(e)]),"Export.json")}},
                    {extend:"print",exportOptions:{columns:":visible"}}
                  ]
              });

              $('#oversightForm').on('submit', function(e){

                  var url2 = "<?php echo base_url(); ?>reports/api_update_oversight";

                  console.log('clicked' + url2);

                  e.preventDefault();

                  var formdata = table2.$('input,select,text,hidden').serializeArray();

                  formdata.push(

                  {'name' : 'SessionID', 'value' : '<?php echo $session_id; ?>'},
                  {'name' : 'CommitteeID', 'value' : '<?php echo $comm_id; ?>'},
                  {'name' : 'EntryID', 'value' : '<?php echo $ft_id; ?>'}

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
                            document.location.href = "<?php echo base_url(); ?>reports/edit_field_trip?id="+response.ft_id+"&commid="+response.comm_id;
                          }
                          else
                          {
                            $('#show_id').html("<div style='border:1px solid red;font-size: 11px;margin:0 auto !important;'> Failed to Update Field Trip Data. </div>")
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