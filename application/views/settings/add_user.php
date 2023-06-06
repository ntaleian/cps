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

                    <form class="form form-horizontal" action="<?php echo base_url() ?>settings/add_user" method="post">
                      <div class="form-body">
                        <div class="row">

                          <div class="col-md-3">
                            <label>First Name</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="text" id="first-name" class="form-control" name="Firstname" placeholder="First Name">
                          </div>

                          <div class="col-md-3">
                            <label>Last Name</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="text" id="first-name" class="form-control" name="Lastname" placeholder="Last Name">
                          </div>

                          <div class="col-md-3">
                            <label>Email Address</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="email" id="first-name" class="form-control" name="Email" placeholder="Email Address">
                          </div>

                          <div class="col-md-3">
                            <label>Username</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="text" id="first-name" class="form-control" name="Username" placeholder="Username">
                          </div>

                          <div class="col-md-3">
                            <label>User Type</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <ul class="list-unstyled mb-0">
                              <li class="d-inline-block mr-2 mb-1">
                                <fieldset>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="Usertype" value="super" id="customRadio1" checked>
                                    <label class="custom-control-label" for="customRadio1">Super User</label>
                                  </div>
                                </fieldset>
                              </li>
                              <li class="d-inline-block mr-2 mb-1">
                                <fieldset>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="Usertype" value="normal" id="customRadio2" checked="">
                                    <label class="custom-control-label" for="customRadio2">Normal User</label>
                                  </div>
                                </fieldset>
                              </li>
                              <li class="d-inline-block mr-2 mb-1">
                                <fieldset>
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="Usertype" value="overall" id="customRadio3">
                                    <label class="custom-control-label" for="customRadio3">Overall User</label>
                                  </div>
                                </fieldset>
                              </li>
                            </ul>
                          </div>

                          <div class="col-md-3">
                            <label>Password</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="password" id="first-name" class="form-control" name="Password" placeholder="Password">
                          </div>

                          <div class="col-md-3">
                            <label>Retype Password</label>
                          </div>
                          <div class="col-md-9 form-group">
                            <input type="password" id="first-name" class="form-control" name="Password2" placeholder="Retype Password">
                          </div>

                          <div class="col-sm-12 d-flex justify-content-end">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary mr-1">Submit</button>
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