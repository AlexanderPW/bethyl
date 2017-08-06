<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cp extends CI_Controller {

    public function settings()
    {
        $this->template->load('default', 'settings');
    }

    public function imports()
    {
        $this->template->load('default', 'imports');
    }
}
