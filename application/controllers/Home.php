<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('email'))) {
            redirect('App');
        }
    }

    public function index() // index
    {
        $email = $this->session->userdata('email');

        $data = [
            'title'             => 'Home',
            'manajemen_uang'    => $this->db->query("SELECT * FROM manajemen_uang WHERE email = '$email'")->result(),
        ];

        $this->template->load('Templates/Content', 'App/Home', $data);
    }

    public function list_home($param)
    {
        $this->load->model("M_home");

        $dat      = explode("~", $param);
        if ($dat[0] == 1) {
            $bulan = date("n");
            $tahun = date("Y");
            $list  = $this->M_home->get_datatables(1, $bulan, $tahun);
        } else {
            $bulan  = date('Y-m-d', strtotime($dat[1]));
            $tahun  = date('Y-m-d', strtotime($dat[2]));
            $list   = $this->M_home->get_datatables(2, $bulan, $tahun);
        }
        $data     = [];
        $no       = 1;

        // Loop through the list to populate the data array
        foreach ($list as $rd) {
            $row = [];
            $row[] = $no++;
            $row[] = $rd->keterangan;
            $row[] = 'Rp. <span class="float-end">' . (($rd->umasuk > 0) ? number_format($rd->umasuk) : number_format(0 - $rd->ukeluar)) . '</span>';
            $row[] = '<div class="text-center">
                <button style="margin-bottom: 5px;" type="button" class="btn btn-danger" onclick="hapusData(' . "'" . $rd->id . "'" . ')">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
            </div>';
            $data[] = $row;
        }

        // Prepare the output in JSON format
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_home->count_all($dat[0], $bulan, $tahun),
            "recordsFiltered" => $this->M_home->count_filtered($dat[0], $bulan, $tahun),
            "data" => $data,
        ];

        // Send the output to the view
        echo json_encode($output);
    }

    public function proses($param)
    {
        $email = $this->session->userdata('email');

        $keterangan = $this->input->post('keterangan');
        $biaya = $this->input->post('biaya');
        $tgl = date('Y-m-d');
        $jam = date('H:i:s');

        if ($param == 1) {
            $data = [
                'email' => $email,
                'tgl' => $tgl,
                'jam' => $jam,
                'keterangan' => $keterangan,
                'umasuk' => str_replace(',', '', $biaya),
            ];
        } else {
            $data = [
                'email' => $email,
                'tgl' => $tgl,
                'jam' => $jam,
                'keterangan' => $keterangan,
                'ukeluar' => str_replace(',', '', $biaya),
            ];
        }

        $cek = $this->db->insert('manajemen_uang', $data);

        if ($cek) {
            echo json_encode(['result' => 1]);
        } else {
            echo json_encode(['result' => 0]);
        }
    }

    public function delData($id)
    {
        $cek = $this->db->delete('manajemen_uang', ['id' => $id]);

        if ($cek) {
            echo json_encode(['result' => 1]);
        } else {
            echo json_encode(['result' => 0]);
        }
    }
}
