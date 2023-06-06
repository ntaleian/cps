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

                    <div class="table-responsive">
                      <table class="table table-striped dataex-html5-selectors">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Assign</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Username</th>
                            <th>Usertype</th>
                            <th>Committees</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $counter = 1; 
                            foreach($users as $user){ ?>
                              <tr>
                                <td><?php echo $user['EntryID']; ?></td>
                                <?php $userID = $user['EntryID']; ?>
                                <td>
                                  <?php if($user['Usertype'] != "super"){ ?><a href="<?php echo base_url(); ?>settings/assign_user?id=<?php echo $userID; ?>" class="btn btn-icon rounded-circle btn-outline-primary mr-1 mb-1"><i class="bx bxs-user-detail"></i></a><?php } else { ?> &nbsp; <?php } ?>
                                </td>
                                <td><?php echo $user['Firstname']; ?></td>
                                <td><?php echo $user['Lastname']; ?></td>
                                <td><?php echo $user['Email']; ?></td>
                                <td><?php echo $user['Username']; ?></td>
                                <td><?php echo ucfirst($user['Usertype']); ?></td>
                                <td>
                                  <?php  
                                    // $userid = $this->session->userdata('alluserdata')[0]['EntryID'];
                                    $get = $this->db->query("SELECT c.Title FROM committee_users u LEFT JOIN committees c ON u.CommitteeID=c.EntryID WHERE u.UserID='".$user['EntryID']."' AND u.IsActive='Y'");
                                    // echo "SELECT c.Title FROM committee_users u LEFT JOIN committees c ON u.CommitteeID=c.EntryID WHERE u.UserID='$userid'"; exit;
                                    // print_r($get);
                                    if($get->num_rows() > 0)
                                    {
                                      $result = $get->result_array();
                                      $committee_str = "";
                                      foreach($result as $row)
                                      {
                                        $committee_str .= $row['Title'].",";
                                      }
                                      echo rtrim($committee_str,',');
                                    }
                                    else
                                    {
                                      echo "No Committees Assigned";
                                    }
                                  ?>
                                
                                </td>
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