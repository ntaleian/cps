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

          <!-- Basic Select2 start -->
          <section class="basic-select2">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Add User</h4>
                  </div>
                  <div class="card-body">

                    <form class="form form-horizontal" name="<?php echo base_url(); ?>settings/user_profile" method="post">

                      <input type="hidden" name="uid" value="<?php echo $user['EntryID']; ?>">

                      <div class="form-body">
                        <div class="row">

                          <div class="col-md-3">
                            <label>First Name</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="text" id="first-name" class="form-control" name="Firstname" value="<?php echo $user['Firstname']; ?>" placeholder="First Name">
                          </div>

                          <div class="col-md-3">
                            <label>Last Name</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="text" id="first-name" class="form-control" name="Lastname" value="<?php echo $user['Lastname']; ?>" placeholder="Last Name">
                          </div>

                          <div class="col-md-3">
                            <label>Email Address</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="email" id="first-name" class="form-control" name="Email" value="<?php echo $user['Email']; ?>" placeholder="Email Address">
                          </div>

                          <div class="col-md-3">
                            <label>Username</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="text" id="first-name" class="form-control" name="Username" value="<?php echo $user['Username']; ?>" placeholder="Username" disabled="">
                          </div>

                          <div class="col-md-3">
                            <label>Current Password</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="password" id="first-name" class="form-control" name="Password" placeholder="Password">
                          </div>

                          <div class="col-md-3">
                            <label>New Password</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="password" id="first-name" class="form-control" name="NewPassword" placeholder="New Password">
                          </div>

                          <div class="col-md-3">
                            <label>Retype New Password</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="password" id="first-name" class="form-control" name="NewPassword2" placeholder="Retype New Password">
                          </div>

                          <div class="col-sm-12 d-flex justify-content-end">
                            <button type="submit" name="update" value="update" class="btn btn-primary mr-1">Submit</button>
                            <button type="reset" class="btn btn-light-secondary">Reset</button>
                          </div>
                        </div>
                      </div>
                    </form>
                    
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Basic Select2 end -->



        </div>
      </div>
    </div>
    <!-- END: Content-->