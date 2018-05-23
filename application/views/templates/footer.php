<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</div>
<!-- /page content -->
<!-- footer content -->
<footer>
    <div class="pull-right">
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>

<!-- jQuery -->
<script src="<?= base_url();?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= base_url();?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url();?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="<?= base_url();?>bower_components/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="<?= base_url();?>bower_components/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="<?= base_url();?>bower_components/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="<?= base_url();?>bower_components/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="<?= base_url();?>bower_components/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="<?= base_url();?>bower_components/skycons/skycons.js"></script>
<!-- Flot -->
<script src="<?= base_url();?>bower_components/flot/jquery.flot.js"></script>
<script src="<?= base_url();?>bower_components/flot/jquery.flot.pie.js"></script>
<script src="<?= base_url();?>bower_components/flot/jquery.flot.time.js"></script>
<script src="<?= base_url();?>bower_components/flot/jquery.flot.stack.js"></script>
<script src="<?= base_url();?>bower_components/flot/jquery.flot.resize.js"></script>
<script src="<?= base_url();?>assets/js/jquery.flot.time.js"></script>
<!-- Flot plugins -->
<script src="<?= base_url();?>bower_components/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="<?= base_url();?>bower_components/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="<?= base_url();?>bower_components/flot.curvedlines/curvedLines.js"></script>
<script src="<?= base_url();?>bower_components/flot.tooltip.pib/js/jquery.flot.tooltip.min.js"></script>
<!-- Switchery -->
<script src="<?= base_url();?>bower_components/switchery/dist/switchery.min.js"></script>
<!-- DateJS -->
<script src="<?= base_url();?>bower_components/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="<?= base_url();?>bower_components/jqvmap/dist/jquery.vmap.js"></script>
<script src="<?= base_url();?>bower_components/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="<?= base_url();?>bower_components/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?= base_url();?>bower_components/moment/min/moment.min.js"></script>
<script src="<?= base_url();?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Custom Theme Scripts <script src="<?= base_url();?>assets/build/js/custom.min.js"></script> -->

<script src="<?= base_url();?>assets/js/custom.js"></script>

<script src="<?= base_url();?>assets/js/charts.js"></script>
<?php if (isset($script)) {
if(count((array)$script) > 1) {
	foreach ($script as $s) {
        echo $s;
	}
} else {
    echo $script;
}


} ?>


</body>
</html>
