<!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
      <div class="navbar-wrapper">
        <div class="navbar-container content">
          <div class="navbar-collapse" id="navbar-mobile">
            <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
              <ul class="nav navbar-nav">
                <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:void(0);"><i class="ficon bx bx-menu"></i></a></li>
              </ul>
            </div>
            <ul class="nav navbar-nav float-right">
              <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="selected-language"><?php echo $this->session->userdata('alluserdata')[0]['SessionName']; ?></span></a>
              </li>
              <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
              
              <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0);" data-toggle="dropdown">
                  <div class="user-nav d-sm-flex d-none"><span class="user-name"><?php echo $this->session->userdata('alluserdata')[0]['Firstname']." ".$this->session->userdata('alluserdata')[0]['Lastname']; ?></span><span class="user-status text-muted"><?php echo $this->session->userdata('alluserdata')[0]['Email']; ?></span></div><span><img class="round" src="<?php echo base_url(); ?>assets/app-assets/images/portrait/small/user.png" alt="avatar" height="40" width="40"></span></a>
                <div class="dropdown-menu dropdown-menu-right pb-0">
                  <a class="dropdown-item" href="<?php echo base_url(); ?>settings/user_profile"><i class="bx bx-user mr-50"></i> Edit Profile</a>
                  <div class="dropdown-divider mb-0"></div>
                  <a class="dropdown-item" href="<?php echo base_url(); ?>auth/logout"><i class="bx bx-power-off mr-50"></i> Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- END: Header-->