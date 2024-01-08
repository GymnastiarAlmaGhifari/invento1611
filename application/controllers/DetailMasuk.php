<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DetailMasuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index($id_masuk)
    {
        $data['title'] = "Detail Barang Masuk";
        $data['id_masuk'] = $id_masuk;
        $data['barangs'] = $this->admin->getDetailMasuk($id_masuk);
        // $data['barangmasuk'] = $this->admin->getBarangMasuk();
        // $data['barang_stok'] = $this->admin->getBarangStok(); // Menyimpan data stok barang ke dalam variabel
        $this->template->load('templates/dashboard', 'detail_masuk/data', $data);
    }
}
