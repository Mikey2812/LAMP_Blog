</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo LibsURI; ?>Admin_LTE/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo LibsURI; ?>Admin_LTE/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo LibsURI; ?>Admin_LTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo LibsURI; ?>Admin_LTE/plugins/chart.js/Chart.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo LibsURI; ?>Admin_LTE/plugins/moment/moment.min.js"></script>
<script src="<?php echo LibsURI; ?>Admin_LTE/plugins/daterangepicker/daterangepicker.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo LibsURI; ?>Admin_LTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>
<!-- AdminLTE App -->
<script src="<?php echo LibsURI; ?>Admin_LTE/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo LibsURI; ?>Admin_LTE/dist/js/pages/dashboard.js"></script>
<!-- Toastr-->
<script src="<?php echo LibsURI; ?>Admin_LTE/plugins/toastr/toastr.min.js"></script>
<script src="<?php echo MediaURI; ?>admin/js/form.js"></script>
<?php echo vendor_html_helper::_jsFooter(); ?>
</body>

</html>