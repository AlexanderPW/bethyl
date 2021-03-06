<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script src="<?=base_url();?>/bower_components/dropzone/dist/min/dropzone.min.js"></script>

<h3><i class="fa fa-database"></i> Data Center</h3>

	<div class="row">
		<?
		//IIS
		$data['log_title'] = 'IIS Server Log Import';
		$data['mod_class'] = 'iis_import';
        $data['format'] = '.log';
        $data['url'] = 'serverlog';
				if(null !== $recents['last_iis']) {
        $data['last_time'] = date("F jS, Y", strtotime($recents['last_iis']->timestamp));
				$data['last_qty'] = $recents['last_iis']->data;
			} else {$data['last_time'] = 'No Import History';
					$data['last_qty'] = '0';
			}
        $this->load->view('partials/file_importer', $data);
        $this->load->view('partials/file_uploader', $data);

        //KNA
		$data['log_title'] = 'KNA - Customer Import';
		$data['mod_class'] = 'kna_import';
        $data['format'] = '.xlsx';
        $data['url'] = 'customerlog';
				if(null !== $recents['last_kna']) {
        $data['last_time'] = date("F jS, Y", strtotime($recents['last_kna']->timestamp));
        $data['last_qty'] = $recents['last_kna']->data;
			} else {$data['last_time'] = 'No Import History';
					$data['last_qty'] = '0';
			}
        $this->load->view('partials/file_importer', $data);
        $this->load->view('partials/file_uploader', $data);
        ?>
        </div>
        <div class="row">
	        <?

        //MARA
        $data['log_title'] = 'MARA - Material Import';
        $data['mod_class'] = 'mara_import';
        $data['format'] = '.xlsx';
        $data['url'] = 'materiallog';
				if(null !== $recents['last_mara']) {
        $data['last_time'] = date("F jS, Y", strtotime($recents['last_mara']->timestamp));
        $data['last_qty'] = $recents['last_mara']->data;
			} else {$data['last_time'] = 'No Import History';
					$data['last_qty'] = '0';
			}
        $this->load->view('partials/file_importer', $data);
        $this->load->view('partials/file_uploader', $data);

        //S901
        $data['log_title'] = 'S901 - Sales Import';
        $data['mod_class'] = 's901_import';
        $data['format'] = '.xlsx';
        $data['url'] = 'saleslog';
				if(null !== $recents['last_901']) {
        $data['last_time'] = date("F jS, Y", strtotime($recents['last_901']->timestamp));
        $data['last_qty'] = $recents['last_901']->data;
			} else {$data['last_time'] = 'No Import History';
					$data['last_qty'] = '0';
			}
        $this->load->view('partials/file_importer', $data);
        $this->load->view('partials/file_uploader', $data);
        ?>
	</div>
	<div class="row">
    <?
    //MARA
    $data['log_title'] = 'Customer IP Import';
    $data['mod_class'] = 'ip_import';
    $data['format'] = '.xlsx';
    $data['url'] = 'iplog';
		if(null !== $recents['last_ip']) {
    $data['last_time'] = date("F jS, Y", strtotime($recents['last_ip']->timestamp));
    $data['last_qty'] = $recents['last_ip']->data;
	} else {$data['last_time'] = 'No Import History';
			$data['last_qty'] = '0';
	}
    $this->load->view('partials/file_importer', $data);
    $this->load->view('partials/file_uploader', $data);

    ?>
	</div>
