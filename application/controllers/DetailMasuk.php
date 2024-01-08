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

    private function _validasi()
    {
        $this->form_validation->set_rules('id_barang', 'Barang', 'required');
        $this->form_validation->set_rules('id_barang_masuk', 'Id Barang Masuk', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Masuk', 'required');

        // $this->form_validation->set_rules('jeniss_id', 'Jenis Barang', 'required');
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

    public function add($id_masuk) {
        $this->_validasi();
        var_dump($_POST);

        var_dump($this->form_validation->run());
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Masuk";
            $data['barang'] = $this->admin->get('barang');
            $data['id_detail_masuk'] = $id_masuk;
            $this->template->load('templates/dashboard', 'detail_masuk/add', $data);
        } else {
            $input = $this->input->post(null, true);
            var_dump($_POST);
            $insert = $this->admin->insert('detail_masuk', $_POST);
            var_dump($insert);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('detailmasuk/index/'.$_POST["id_barang_masuk"]);
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangmasuk/add');
            }
        }
    }

    public function edit($id_detail_masuk,$id_masuk) {
        $this->_validasi();

        var_dump($this->form_validation->run());
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Masuk";
            $data['barang'] = $this->admin->get('barang');
            $data['id_detail_masuk'] = $id_masuk;
            $this->template->load('templates/dashboard', 'detail_masuk/add', $data);
        } else {
            $input = $this->input->post(null, true);
            var_dump($_POST);
            $insert = $this->admin->update('detail_masuk','id_detail_masuk',$id_detail_masuk, $_POST);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('detailmasuk/index/'.$_POST["id_barang_masuk"]);
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('detailmasuk/add');
            }
        }
    }

    public function delete($id_detail_masuk,$id_masuk)
    {
        if ($this->admin->delete('detail_masuk', 'id_detail_masuk', $id_detail_masuk)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('/detailmasuk/index/'.$id_masuk);
    }
}
