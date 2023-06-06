<!-- Hide Scroll To Top Starts-->
  <div class="hide-scroll-to-top d-flex justify-content-between align-items-center py-25">
    <div class="hide-scroll-title">
      <h5 class="pt-25">Hide Scroll To Top</h5>
    </div>
    <div class="hide-scroll-top-switch">
      <!--<div class="custom-control custom-switch">-->
      <!--  <input type="checkbox" class="custom-control-input" id="hide-scroll-top-switch">-->
      <!--  <label class="custom-control-label" for="hide-scroll-top-switch"></label>-->
      <!--</div>-->
    </div>
  </div>
  <!-- Hide Scroll To Top Ends-->

  <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
      <p class="clearfix mb-0"><span class="float-left d-inline-block">2021 &copy; CPS PARLIAMENT</span><span class="float-right d-sm-inline-block d-none">Crafted with<i class="bx bxs-heart pink mx-50 font-small-3"></i>by<a class="text-uppercase" href="https://1.envato.market/pixinvent_portfolio" target="_blank">CPS</a></span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
      </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <!-- <script src="<?php #echo base_url(); ?>assets/app-assets/vendors/js/vendors.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/extensions/dragula.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/extensions/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/vendors/js/charts/chart.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/configs/vertical-menu-light.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/core/app-menu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/core/app.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/components.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/footer.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/customizer.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/pages/dashboard-analytics.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/forms/select/form-select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/pickers/dateTime/pick-a-datetime.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/app-assets/js/scripts/datatables/datatable.min.js"></script>
    <!-- END: Page JS-->

    <script type="text/javascript">

    $(document).ready(function(){

        var supercommittees = [];
        var supersittings = [];
        var supercoloR = [];

        var dynamicColors = function() {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                return "rgb(" + r + "," + g + "," + b + ")";
        };

        <?php  
          if(!empty($super_reports)){
          foreach($super_reports as $report){
        ?>

        supercommittees.push("<?php echo substr($report['Title'], 13); ?>");
        supersittings.push("<?php echo $report['NoOfSittings']; ?>");
        supercoloR.push(dynamicColors());

        <?php 
          }
        }
        ?>

        var chart_data = {
                    labels: supercommittees,
                    datasets:[{
                        label: "My First dataset",
                        data: supersittings,
                        backgroundColor: supercoloR
                    }]
                };

        var group_chart1 = $('#simple-pie-chart');

        var graph1 = new Chart(group_chart1, {
            type:"pie",
            data:chart_data,
            options: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        'fontSize':9
                    }
                }
            }
        });
    });
    </script>

    <!-- NORMAL PIE -->

    <script type="text/javascript">

    $(document).ready(function(){

        var supercommittees = [];
        var supersittings = [];
        var coloR = [];

        var dynamicColors = function() {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                return "rgb(" + r + "," + g + "," + b + ")";
        };

        <?php  
          if(!empty($reports)){
          foreach($reports as $report){
        ?>

        supercommittees.push("<?php echo substr($report['Title'], 13); ?>");
        supersittings.push("<?php echo $report['NoOfSittings']; ?>");
        coloR.push(dynamicColors());

        <?php 
          }
        }
        ?>

        var chart_data = {
                    labels: supercommittees,
                    datasets:[{
                        label: "My First dataset",
                        data: supersittings,
                        backgroundColor: coloR
                    }]
                };

        var group_chart1 = $('#simple-pie-chart');

        var graph1 = new Chart(group_chart1, {
            type:"pie",
            data:chart_data,
            options: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        'fontSize':9
                    }
                }
            }
        });
    });
    </script>

    <script type="text/javascript">
    // Default Configuration
        $(document).ready(function() {
            toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': false,
                'progressBar': false,
                'positionClass': 'toast-top-right',
                'preventDuplicates': false,
                'showDuration': '1000',
                'hideDuration': '1000',
                'timeOut': '5000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            }
        });

        var success_msg = "<?php echo $this->session->flashdata('succ_msg'); ?>";

            var error_msg = "<?php echo $this->session->flashdata('err_msg'); ?>";

            if(success_msg.length > 0)
            {
                toastr.success(success_msg);
            }
            else if(error_msg.length > 0)
            {
                toastr.error(error_msg);
            }

        // Toast Type
        // toastr.error('You clicked Success toast');
        
    </script>


  </body>
  <!-- END: Body-->

</html>