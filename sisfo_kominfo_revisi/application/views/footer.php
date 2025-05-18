</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2024
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>

<!-- ./wrapper -->
<!-- DataTables -->
<script src="<?= base_url('vendor') ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('vendor') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('vendor') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('vendor') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('vendor') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/sweetalert/package/dist/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url(); ?>assets/toast-master/js/jquery.toast.js"></script>
<script src="<?= base_url() ?>assets/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="<?= base_url('vendor') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('vendor') ?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('vendor') ?>/dist/js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoClose: true,
        });
    });
</script>
</body>

</html>