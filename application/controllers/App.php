<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index() // index
    {
        $data = [
            'title' => 'App',
        ];

        $this->template->load('Templates/App', 'App/Login', $data);
    }

    public function login_proses()
    {
        $email = htmlspecialchars($this->input->post('email'));
        $password = htmlspecialchars($this->input->post('password'));

        $cek_user = $this->db->query("SELECT * FROM user WHERE email = '$email'")->row();
        if ($cek_user) {
            if ($cek_user->password == md5($password)) {
                $this->session->set_userdata([
                    'email' => $cek_user->email
                ]);

                echo json_encode(['result' => 1]);
            } else {
                echo json_encode(['result' => 2]);
            }
        } else {
            echo json_encode(['result' => 3]);
        }
    }
}
