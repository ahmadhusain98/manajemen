<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_home extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL, 'id_ID.utf8');
        date_default_timezone_set('Asia/Jakarta');
    }

    var $table          = 'manajemen_uang';
    var $column_order   = ['id', 'email', 'tgl', 'jam', 'keterangan', 'umasuk', 'ukeluar'];
    var $column_search  = ['id', 'email', 'tgl', 'jam', 'keterangan', 'umasuk', 'ukeluar'];
    var $order          = ['id' => 'DESC'];

    private function _get_datatables_query($jns, $bulan, $tahun)
    {
        $this->db->select($this->column_order);
        $this->db->from($this->table);
        $this->db->where("email", $this->session->userdata('email'));
        if ($jns == 1) {
            $tanggal = date('Y-m-d');
            $this->db->where(['tgl' => $tanggal]);
        } else {
            $this->db->where(['tgl >=' => $bulan, 'tgl<= ' => $tahun]);
        }
        $this->db->order_by("tgl, jam", "DESC");
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($jns, $bulan, $tahun)
    {
        $this->_get_datatables_query($jns, $bulan, $tahun);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($jns, $bulan, $tahun)
    {
        $this->_get_datatables_query($jns, $bulan, $tahun);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($jns, $bulan, $tahun)
    {
        $this->db->select($this->column_order);
        $this->db->from($this->table);
        $this->db->where("email", $this->session->userdata('email'));

        if ($jns == 1) {
            $tanggal = date('Y-m-d');
            $this->db->where(['tgl' => $tanggal]);
        } else {
            $this->db->where(['tgl >=' => $bulan, 'tgl<= ' => $tahun]);
        }

        $this->db->order_by("tgl, jam", "DESC");

        return $this->db->count_all_results();
    }
}
