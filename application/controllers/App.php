<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'title' => 'Home',
        ];

        $this->template->load('Templates/App', 'App/Home', $data);
    }
}
