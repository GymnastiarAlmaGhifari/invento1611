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

    public function add($id_masuk)
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Masuk";
            $data['barang'] = $this->admin->get('barang');
            $data['id_detail_masuk'] = $id_masuk;
            $this->template->load('templates/dashboard', 'detail_masuk/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $this->db->trans_start();
            $insert = $this->admin->insert('detail_masuk', $_POST);
            $this->admin->tambahStok($input['id_barang'], $input['jumlah']);
            $this->db->trans_complete();
            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('detailmasuk/index/' . $_POST["id_barang_masuk"]);
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangmasuk/add');
            }
        }
    }

    public function edit($id_detail_masuk, $id_masuk)
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $detail = $this->admin->getDetailMasukById($id_detail_masuk)[0];
            $barang = $this->admin->getBarangById($detail['id_barang'])[0];

            $data['title'] = "Barang Masuk";
            $data['barang'] = $barang['nama_barang'];
            $data['stock'] = $barang['stok'] - $detail['jumlah'];
            $data['id_detail_masuk'] = $id_masuk;
            $this->template->load('templates/dashboard', 'detail_masuk/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $this->db->trans_start();
            $detail = $this->admin->getDetailMasukById($id_detail_masuk)[0];
            $barang = $this->admin->getBarangById($detail['id_barang'])[0];
            $stok = $barang['stok'] - $detail['jumlah'];
            $data = [
                'jumlah' => $input['jumlah'],
            ];
            $insert = $this->admin->update('detail_masuk', 'id_detail_masuk', $id_detail_masuk, $data);
            $total = $stok + $input['jumlah'];
            $this->admin->updateStok($detail['id_barang'], $total);
            $this->db->trans_complete();

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('detailmasuk/index/' . $_POST["id_barang_masuk"]);
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('detailmasuk/edit/' . $id_detail_masuk . '/' . $id_masuk);
            }
        }
    }

    public function delete($id_detail_masuk, $id_masuk)
    {
        $this->db->trans_start();
        $detail = $this->admin->getDetailMasukById($id_detail_masuk)[0];
        $this->admin->kurangiStok($detail['id_barang'], $detail['jumlah']);
        $delete = $this->admin->delete('detail_masuk', 'id_detail_masuk', $id_detail_masuk);
        $this->db->trans_complete();
        if ($delete) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('/detailmasuk/index/' . $id_masuk);
    }
}
