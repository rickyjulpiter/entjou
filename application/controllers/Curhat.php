<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Curhat extends CI_Controller
{
    function index()
    {
        $this->load->view('maucurhat');
    }
}
