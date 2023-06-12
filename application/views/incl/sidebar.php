 <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mr-auto"><a class="navbar-brand" href="#">
              <div class="brand-logo">
                <img style="width: 26px" src="<?php echo base_url(); ?>assets/app-assets/images/logo/logo2.png">
              </div>
              <h2 class="brand-text mb-0">CPS Admin</h2></a></li>
          <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
        </ul>
      </div>
      <div class="shadow-bottom"></div>
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
         
          <li class=" navigation-header text-truncate"><span data-i18n="Apps">CPS Core</span>
          </li>

          <?php if($this->session->userdata('alluserdata')[0]['Usertype'] == "normal" || $this->session->userdata('alluserdata')[0]['Usertype'] == "overall"){ ?>

          <li class="<?php if($active == 'dash'){ echo 'active'; } ?> nav-item"><a href="<?php echo base_url(); ?>dashboard"><i class="menu-livicon" data-icon="desktop"></i><span class="menu-title text-truncate" data-i18n="Email">Home</span></a>
          </li>
          <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="notebook"></i><span class="menu-title text-truncate" data-i18n="Invoice">Committee Business</span></a>
            <ul class="menu-content">
              <li class="<?php if($active == 'sittings'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>sittings"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Manage Sittings">Manage Sittings</span></a>
              </li>
              <li class="<?php if($active == 'sittings_file'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>sittings/sitting_file"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Invoice">Upload Sittings File</span></a>
              </li>
              <li class="<?php if($active == 'bills'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>bills"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Invoice Edit">Bills</span></a>
              </li>
              <li class="<?php if($active == 'ft'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>travel/field_trip"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Invoice Add">Add Field Trips</span></a>
              </li>
              <li class="<?php if($active == 'ta'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>travel/travel_abroad"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Invoice Add">Add Travels Abroad</span></a>
              </li>
              <li class="<?php if($active == 'alloc'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/allocation"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Invoice Add">Budget Allocation</span></a>
              </li>
            </ul>
          </li>

          <?php if($this->session->userdata('alluserdata')[0]['Usertype'] == "normal"){ ?>

            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title text-truncate" data-i18n="Icons">Committee Settings</span></a>
            <ul class="menu-content">
              
              <li class="<?php if($active == 'c_committees'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/clerk_committees_list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="BoxIcons">Committees List</span></a>
              </li>
              <li class="<?php if($active == 'c_committee_members'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/clerk_view_members"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="BoxIcons">Committee Members</span></a>
              </li>
            </ul>
          </li>

          <?php } } ?>

          <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="line-chart"></i><span class="menu-title text-truncate" data-i18n="User">Reports</span></a>
            <ul class="menu-content">
              <li class="<?php if($active == 'report_att'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>reports/attendance_report"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="List">Attendance Reports</span></a>
              </li>
              <li class="<?php if($active == 'report_att_mp'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>reports/attendance_mp"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="View">Attendance by MPs</span></a>
              </li>
              <li class="<?php if($active == 'report_bills'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>reports/bills_report"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Bills</span></a>
              </li>
              <li class="<?php if($active == 'report_ft'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>reports/field_trip_report"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Field Trips</span></a>
              </li>
              <li class="<?php if($active == 'report_ta'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>reports/travels_abroad_report"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Travels Abroad</span></a>
              </li>
              <li class="<?php if($active == 'report_mps'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>reports/mps_report"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Individual MPs</span></a>
              </li>
              <li class="<?php if($active == 'report_alloc'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>reports/budget_allocation"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Committee Budgets</span></a>
              </li>
              <li class="<?php if($active == 'mps_history'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>reports/committee_history"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Committee History</span></a>
              </li>
            </ul>
          </li>

          <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="bar-chart"></i><span class="menu-title text-truncate" data-i18n="User">Session Reports</span></a>
            <ul class="menu-content">
              <li class="<?php if($active == 'report_att_sess'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>session_reports/attendance_report"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="List">Attendance Reports</span></a>
              </li>
              <li class="<?php if($active == 'report_att_mp_sess'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>session_reports/attendance_mp"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="View">Attendance by MPs</span></a>
              </li>
              <li class="<?php if($active == 'report_bills_sess'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>session_reports/bills_report"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Bills</span></a>
              </li>
              <li class="<?php if($active == 'report_ft_sess'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>session_reports/field_trip_report"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Field Trips</span></a>
              </li>
              <li class="<?php if($active == 'report_ta_sess'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>session_reports/travels_abroad_report"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Travels Abroad</span></a>
              </li>
              <!-- <li class="<?php #if($active == 'report_mps_sess'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php #echo base_url(); ?>session_reports/mps_report"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Individual MPs</span></a>
              </li>
              <li class="<?php #if($active == 'report_alloc_sess'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php #echo base_url(); ?>session_reports/budget_allocation"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Committee Budgets</span></a>
              </li>
              <li class="<?php #if($active == 'mps_history_sess'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php #echo base_url(); ?>session_reports/committee_history"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Committee History</span></a> -->
              </li>
            </ul>
          </li>

          <?php if($this->session->userdata('alluserdata')[0]['Usertype'] == "super" || $this->session->userdata('alluserdata')[0]['Usertype'] == "overall"){ ?>

          <li class=" navigation-header text-truncate"><span data-i18n="UI Elements">Settings</span>
          </li>
          <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title text-truncate" data-i18n="Content">Committees</span></a>
            <ul class="menu-content">
              <li class="<?php if($active == 'add_committee'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/add_committee"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Add Committee</span></a>
              </li>
              <li class="<?php if($active == 'committees'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/committees_list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Committees List</span></a>
              </li>
              <li class="<?php if($active == 'committee_members'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/view_members"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Committee Members</span></a>
              </li>
              <li class="<?php if($active == 'mps'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/mps_list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">MPs List</span></a>
              </li>
              <li class="<?php if($active == 'add_mps_file'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/add_mps"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Add MPs File</span></a>
              </li>
              <li class="<?php if($active == 'add_mps_single'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/add_single_mp"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Edit">Add Single MP</span></a>
              </li>
            </ul>
          </li>

          <?php
            if($this->session->userdata('alluserdata')[0]['Usertype'] == "super"){
          ?>

          <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title text-truncate" data-i18n="Icons">Users</span></a>
            <ul class="menu-content">
              <li class="<?php if($active == 'add_user'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/add_user"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="LivIcons">Add User</span></a>
              </li>
              <li class="<?php if($active == 'users_list'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/users_list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="BoxIcons">Users List</span></a>
              </li>
              <li class="<?php if($active == 'user_logs'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/user_logs"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="BoxIcons">User Logs</span></a>
              </li>
            </ul>
          </li>

          <?php
            }
          ?>
          
          <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="dashboard"></i><span class="menu-title text-truncate" data-i18n="Icons">Sessions</span></a>
            <ul class="menu-content">
              <li class="<?php if($active == 'add_session'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/add_session"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="LivIcons">Add Session</span></a>
              </li>
              <li class="<?php if($active == 'sessions_list'){ echo 'active'; } ?>"><a class="d-flex align-items-center" href="<?php echo base_url(); ?>settings/sessions_list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="BoxIcons">Sessions List</span></a>
              </li>
            </ul>
          </li>

          <?php } ?>

        </ul>
      </div>
    </div>
    <!-- END: Main Menu-->