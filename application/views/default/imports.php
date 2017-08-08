<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h3>Data Center</h3>

	<div class="row">
		<div class="col-md-6 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>IIS Server Logs</h2>
					<ul class="nav navbar-right panel_toolbox panel_toolbox_min">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div id="actions" class="row">
						<div class="col-lg-12"><p><small>File must be a .log format</small></p></div>
						<div class="col-lg-12">
							<!-- The fileinput-button span is used to style the file input field as button -->
							<span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Add files...</span>
        </span>
							<button type="submit" class="btn btn-primary start">
								<i class="glyphicon glyphicon-upload"></i>
								<span>Start Import</span>
							</button>
							<button type="reset" class="btn btn-warning cancel">
								<i class="glyphicon glyphicon-ban-circle"></i>
								<span>Clear Import</span>
							</button>
						</div>

						<div class="col-lg-12">
							<!-- The global file processing state -->
							<span class="fileupload-process">
          <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
          </div>
        </span>
						</div>

					</div>
					<div class="table table-striped files" id="previews">
						<div id="template" class="file-row">
							<!-- This is used as the file preview template -->
							<div>
								<span class="preview"><img data-dz-thumbnail /></span>
							</div>
							<div>
								<p class="name" data-dz-name></p>
								<strong class="error text-danger" data-dz-errormessage></strong>
							</div>
							<div>
								<p class="size" data-dz-size></p>
								<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
									<div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
								</div>
							</div>
							<div>
								<button class="btn btn-primary start">
									<i class="glyphicon glyphicon-upload"></i>
									<span>Start</span>
								</button>
								<button data-dz-remove class="btn btn-warning cancel">
									<i class="glyphicon glyphicon-ban-circle"></i>
									<span>Cancel</span>
								</button>
								<button data-dz-remove class="btn btn-danger delete">
									<i class="glyphicon glyphicon-trash"></i>
									<span>Remove</span>
								</button>
							</div>
						</div>

					</div>
					<div class="ln_solid"></div>
					<small>Last updated on:</small>
				</div>
			</div>
		</div>
	</div>

		<script src="<?=base_url();?>/bower_components/dropzone/dist/min/dropzone.min.js"></script>
		<script src="<?=base_url();?>/assets/js/parsers.js"></script>




