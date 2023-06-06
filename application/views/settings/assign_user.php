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

                    <form id="userForm" action="<?php echo base_url() ?>settings/do_assign_user" method="post">

                    <input type="hidden" name="CommitteeID" value="<?php echo $id; ?>">

                    <button class="btn btn-outline-secondary mr-1 mb-1" type="submit" name="assign" value="Assign Selected Committees">Assign Selected Committees</button>
                    <br/><br/>

                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>Assign</th>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $counter = 1; 
                            foreach($committees as $committee){ ?>
                              <tr>
                                        <?php 
                                          $result = "";
                                          $PerQry = $this->db->query("SELECT * FROM committee_users WHERE CommitteeID='".$committee['EntryID']."' AND UserID='$id' AND IsActive='Y'");
                                          if($PerQry->num_rows() > 0)
                                          {
                                            $result = $PerQry->row_array();
                                          }
                                          else
                                          {
                                            
                                          }
                                        ?>
                                <td><input type="checkbox" class="check" id="committees_<?php echo $committee['EntryID']; ?>" name='committees_id[]'  data-checkbox="icheckbox_flat-red" value="<?php echo $committee['EntryID']; ?>" <?php if(!empty($result)){ echo "checked"; } else { echo ""; } ?> ></td>

                              </form>

                                <td><?php echo $counter; ?></td>
                                <td><?php echo $committee['Title']; ?></td>
                                <td><?php echo $committee['Category']; ?></td>
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