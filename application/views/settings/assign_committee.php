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
                      Users List
                    </h4>
                  </div>
                  <div class="card-body card-dashboard">
                    <p class="card-text">
                      System Users List
                    </p>

                    <form id="assignForm" class="form font-14" action="#" method="post">

                    <input type="hidden" name="CommitteeID" value="<?php echo $id; ?>">

                    <input type="hidden" name="redirectUrl" value="<?php echo $redirectUrl; ?>">

                    <button class="btn btn-outline-secondary mr-1 mb-1" type="submit" name="assign" value="Assign Selected Committees">Assign Selected MPs</button>
                    <br/><br/>

                    <div class="table-responsive">
                      <table id="assignTable" class="table table-striped assTable">
                        <thead>
                          <tr>
                            <th>Assign</th>
                            <th>#</th>
                            <th>MP Code</th>
                            <th>Name</th>
                            <th>Party</th>
                            <th>Constituency</th>
                            <th>District</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $counter = 1; 
                            foreach($mps as $mp){ ?>
                              <tr>
                                <td><input type="checkbox" class="sub_check" data-id="<?php echo $mp['EntryID']; ?>" name='mps_id[]'  data-checkbox="icheckbox_flat-red" value="<?php echo $mp['EntryID']; ?>"></td>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $mp['Code']; ?></td>
                                <td><?php echo $mp['Name']; ?></td>
                                <td><?php echo $mp['Party']; ?></td>
                                <td><?php echo $mp['Constituency']; ?></td>
                                <td><?php echo $mp['District']; ?></td>
                              </tr>
                            <?php 
                                $counter++;
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

          <script>
           $(document).ready(function(){

            var table = $(".assTable").DataTable(
                {dom:"Bfrtip",buttons:[{extend: 'excelHtml5',text: 'Save as Excel'},{extend:"copyHtml5",exportOptions:{columns:[0,":visible"]}},{extend:"pdfHtml5",exportOptions:{columns:":visible"}},{text:"JSON",action:function(a,o,t,r){var e=o.buttons.exportData();$.fn.dataTable.fileSave(new Blob([JSON.stringify(e)]),"Export.json")}},{extend:"print",exportOptions:{columns:":visible"}}]}
                );

            //form submission
            $('#assignForm').on('submit', function(e){

              e.preventDefault();

              var url = "<?php echo base_url(); ?>settings/api_assign";

              //prevent actual form submission
              e.preventDefault();

              //serialize form data
              var formdata = table.$('input[type="checkbox"]').serializeArray();

              formdata.push(

                {'name' : 'CommitteeID', 'value' : '<?php echo $id; ?>'}

                );

              console.log(formdata);

              $.ajax({
                    url:url,
                    type: "POST",
                    data: formdata,
                    dataType: 'json',
                    success: function(response){

                        var len = response.length;

                        console.log("response: " + response);

                        if(response.message === "true"){
                          document.location.href = "<?php echo base_url(); ?>settings/" + response.redirectUrl;
                        }
                        else
                        {
                          $('#show_id').html("<div style='border:1px solid red;font-size: 11px;margin:0 auto !important;'> Failed to Add Committee Members. </div>")
                        }
                    }
                });

            }); 

           });

        </script>

        </div>
      </div>
    </div>
    <!-- END: Content-->