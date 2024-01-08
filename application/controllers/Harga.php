<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Harga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Harga";
        $data['harga'] = $this->admin->get('harga');
        $data['barang_stok'] = $this->admin->getBarangStok(); // Menyimpan data stok barang ke dalam variabel
        $this->template->load('templates/dashboard', 'harga/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nm_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('harga_barang', 'Harga Barang', 'required');
        $this->form_validation->set_rules('harga_modal', 'Harga Modal', 'required');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Harga";
            $data['barang'] = $this->admin->get('barang');
            $this->template->load('templates/dashboard', 'harga/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('harga', $input);
            if ($insert) {
                set_pesan('data berhasil disimpan');
                redirect('harga');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('harga/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Harga";
            $data['harga'] = $this->admin->get('harga', ['id_harga' => $id]);
            $this->template->load('templates/dashboard', 'harga/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('harga', 'id_harga', $id, $input);
            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('harga');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('harga/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('harga', 'id_harga', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('harga');
    }

}
