<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal fade" id="trafficModal" tabindex="-1" role="dialog" aria-labelledby="trafficModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="trafficModalLabel">Related Traffic</h4>
            </div>
            <div class="modal-body" id="modal-body">
	            <div id="datatable_wrapper" class="dataTables_wrapper">
	            <table id="traffic-datatable" class="table table-striped hover" cellspacing="0" width="100%">
		            <thead>
		            <tr>
			            <th>No</th>
			            <th>Date</th>
			            <th>Relative URL</th>
			            <th>Visiting IP</th>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
