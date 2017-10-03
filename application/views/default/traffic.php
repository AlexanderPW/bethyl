<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url();?>assets/css/jquery.datatables.css" rel="stylesheet">
<link href="<?=base_url();?>bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?=base_url();?>bower_components/select2-bootstrap-theme/dist/select2-bootstrap.min.css" rel="stylesheet">

<h3><i class="fa fa-bar-chart"></i> Traffic Report</h3>
<br>

<div class="row">

	<!-- top chart -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel fixed_height_320">
			<div class="x_title">
				<h2>Traffic by click</h2>
				<ul class="nav navbar-right panel_toolbox panel_toolbox_min">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div id="product-search-status>"<h3>Total CTR Comparison</h3></div><br>
				<div class="clearfix"></div>
				<div id="sales-product-bar-holder" style="width:100%;height:200px">

				</div>
			</div>

		</div>
	</div>
	<!-- /top chart -->
</div>

<!-- form date pickers -->
<div class="x_panel" style="">
	<div class="x_title">
		<h2>Traffic Filters</h2>
		<ul class="nav navbar-right panel_toolbox panel_toolbox_min">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			</li>
			<li><a class="close-link"><i class="fa fa-close"></i></a>
			</li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">

		<div class="well" style="overflow: auto">
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div id="product_date_selector" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
					<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
					<span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<select id='traffic-sales-filter1'>
				</select>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<select id='traffic-sales-filter2'>
				</select>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<select id='traffic-sales-filter3'>
				</select>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<select id='traffic-sales-filter4'>
				</select>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12">
				<select id='traffic-sales-filter5'>
				</select>
			</div>
		</div>

	</div>
</div>
<!-- /form datepicker -->

<!-- form datatable -->
<div class="x_panel" style="">
	<div class="x_title">
		<h2>Traffic Table</h2>
		<ul class="nav navbar-right panel_toolbox panel_toolbox_min">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			</li>
			<li><a class="close-link"><i class="fa fa-close"></i></a>
			</li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
<div id="datatable_wrapper" class="dataTables_wrapper"></div>
		<table id="product-sales" class="table table-striped hover" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>No</th>
				<th>Date</th>
				<th>Url</th>
				<th>Campaign</th>
				<th>Source</th>
				<th>Medium</th>
				<th>IP</th>
				<th>Customer</th>
			</tr>
			</thead>
			<tbody>
			</tbody>

			<tfoot>

			</tfoot>
		</table>
	</div>

	</div>
</div>
<!-- /datatable -->

<!-- Traffic Modal -->
<? $this->load->view('partials/traffic_modal');?>






