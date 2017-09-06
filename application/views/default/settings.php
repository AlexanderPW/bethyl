<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h3><i class="fa fa-cog"></i> Configuration Settings</h3>

<div class="row">
	<div class="col-md-6 col-sm-12 col-xs-12">
	<div class="x_panel" style="">
		<div class="x_title">
			<h2>Variable Settings</h2>
			<ul class="nav navbar-right panel_toolbox panel_toolbox_min">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
				<li><a class="close-link"><i class="fa fa-close"></i></a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
				<h2>Traffic to Sales Relationship Calculation</h2>
				<div class="input-group">
					<select id="traffic-option" class="form-control">
                        <?foreach($trafficGroup as $opt) {echo $opt;};?>
					</select>
					<span class="input-group-btn">
					<button type="submit" class="btn btn-primary traffic-option">Submit</button>
						</span>
				</div>
			<div class="ln_solid"></div>
			<h2>App Location - ssconvert</h2>
			<div class="input-group">
				<input type="text" id="ssconvert" class="form-control" value="<?=$logLocations['ssconvert'];?>"placeholder="Type Full Location for ssconvert">
				<span class="input-group-btn">
					<button type="button" data-id="ssconvert" class="btn btn-primary log-location">Submit</button>
				</span>
			</div>
		</div>
	</div>
	</div>

	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="x_panel" style="">
			<div class="x_title">
				<h2>Cron File Import Locations</h2>
				<ul class="nav navbar-right panel_toolbox panel_toolbox_min">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<h2>IIS Server Log</h2>
				<div class="input-group">
					<input type="text" id="iis-location" class="form-control" value="<?=$logLocations['iis-location'];?>"placeholder="Type Full Location for *File Directory">
					<span class="input-group-btn">
					<button type="button" data-id="iis-location" class="btn btn-primary log-location">Submit</button>
				</span>
				</div>
				<div class="ln_solid"></div>
				<h2>KNA - Customer Import</h2>
				<div class="input-group">
					<input type="text" id="kna-location" class="form-control" value="<?=$logLocations['kna-location'];?>"placeholder="Type Full Location for *File Directory">
					<span class="input-group-btn">
					<button type="button" data-id="kna-location" class="btn btn-primary log-location">Submit</button>
				</span>
				</div>
				<div class="ln_solid"></div>
				<h2>MARA - Material Import</h2>
				<div class="input-group">
					<input type="text" id="mara-location" class="form-control" value="<?=$logLocations['mara-location'];?>"placeholder="Type Full Location for *File Directory">
					<span class="input-group-btn">
					<button type="button" data-id="mara-location" class="btn btn-primary log-location">Submit</button>
				</span>
				</div>
				<div class="ln_solid"></div>
				<h2>S901 - Sales Import</h2>
				<div class="input-group">
					<input type="text" id="sales-location" class="form-control" value="<?=$logLocations['sales-location'];?>"placeholder="Type Full Location for *File Directory">
					<span class="input-group-btn">
					<button type="button" data-id="sales-location" class="btn btn-primary log-location">Submit</button>
				</span>
				</div>
				<div class="ln_solid"></div>
				<h2>Customer IP Import</h2>
				<div class="input-group">
					<input type="text" id="ip-location" class="form-control" value="<?=$logLocations['ip-location'];?>"placeholder="Type Full Location for *File Directory">
					<span class="input-group-btn">
					<button type="button" data-id="ip-location" class="btn btn-primary log-location">Submit</button>
				</span>
				</div>
			</div>
		</div>

	</div>
</div>
