<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DetailKeluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index($id_keluar)
    {
        $data['title'] = "Detail Barang Masuk";
        $data['id_keluar'] = $id_keluar;
        $data['barangs'] = $this->admin->getDetailKeluar($id_keluar);
        // $data['barangmasuk'] = $this->admin->getBarangMasuk();
        // $data['barang_stok'] = $this->admin->getBarangStok(); // Menyimpan data stok barang ke dalam variabel
        $this->template->load('templates/dashboard', 'detail_keluar/data', $data);
    }
}
