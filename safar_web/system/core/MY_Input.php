<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Input extends CI_Input {

    public function __construct()
    {
        parent::__construct();
    }

    public function is_ajax_request()
    {
        return ($this->server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest');
    }
}
