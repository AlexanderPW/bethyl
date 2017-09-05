<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- top tiles -->
<!--
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Monthly Traffic</span>
            <div class="count">2500</div>
            <span class="count_bottom"><i class="green">4% </i> From last month</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
            <div class="count">123.50</div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
            <div class="count green">2,500</div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
            <div class="count">4,567</div>
            <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
            <div class="count">2,315</div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
            <div class="count">7,325</div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
        </div>
    </div>
-->
    <!-- /top tiles -->

<h3><i class="fa fa-home"></i> Dashboard</h3>
<br>

<!-- top chart -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>Monthly Sales <small>Comparing <?
		                        echo date('Y').' vs '.
		                        date('Y', strtotime('-1 year'));
		                        ?>
		                        </small></h3>
                    </div>
                    <div class="col-md-6">
                        <div id="reportrange" class="pull-right hidden" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                        </div>
                    </div>
                </div>

                <div class="col-md-10 col-sm-10 col-xs-12">
                    <div id="sales_by_year" class="demo-placeholder"></div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 bg-white">
                    <div class="x_title">
                        <h2>Legend</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-6">

	                    <table class="tile_info">
		                    <tr>
			                    <td>
				                    <p><i class="fa fa-square green"></i><?=date('Y');?></p>
			                    </td>
		                    </tr>
		                    <tr>
			                    <td>
				                    <p><i class="fa fa-square cool-blue"></i><?=date('Y', strtotime('-1 year'));?> </p>
			                    </td>
		                    </tr>
	                    </table>
                    </div>

                </div>

                <div class="clearfix"></div>
            </div>
        </div>

    </div>
<!-- top /topchart -->
    <br />

    <div class="row">

	    <!-- product chart -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h2>Best Selling Products</h2>
	                <ul class="nav navbar-right panel_toolbox panel_toolbox_min">
		                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		                </li>
		                <li><a class="close-link"><i class="fa fa-close"></i></a>
		                </li>
	                </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <h4>Top 5 <?=date('F Y');?> <small>by quantity sold</small></h4>
	                <div class="clearfix"></div>
	                <div id="product-bar-holder" style="width:100%;height:200px">

	                </div>
                </div>

            </div>
        </div>
	    <!-- /product chart -->

	    <!-- customer chart -->
	    <div class="col-md-6 col-sm-6 col-xs-12">
		    <div class="x_panel fixed_height_320">
			    <div class="x_title">
				    <h2>Highest Spending Customers</h2>
				    <ul class="nav navbar-right panel_toolbox panel_toolbox_min">
					    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					    </li>
					    <li><a class="close-link"><i class="fa fa-close"></i></a>
					    </li>
				    </ul>
				    <div class="clearfix"></div>
			    </div>
			    <div class="x_content">
				    <h4>Top 5 <?=date('F Y');?> <small>by amount spent</small></h4>
				    <div class="clearfix"></div>
				    <div id="customer-bar-holder" style="width:100%;height:200px">

				    </div>
			    </div>

		    </div>
	    </div>
	    <!-- /customer chart -->

    </div>

<div class="row">

	<!-- traffic chart -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel fixed_height_320">
			<div class="x_title">
				<h2>Campaign CTR</h2>
				<ul class="nav navbar-right panel_toolbox panel_toolbox_min">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<h4>Top 5 <?=date('F Y');?> <small>by clicks</small></h4>
				<div class="clearfix"></div>
				<div id="traffic-bar-holder" style="width:100%;height:200px">

				</div>
			</div>

		</div>
	</div>
	<!-- /traffic chart -->

</div>


