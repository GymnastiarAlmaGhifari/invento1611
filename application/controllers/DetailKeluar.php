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

    private function _validasi()
    {
        $this->form_validation->set_rules('id_barang', 'Barang', 'required');
        $this->form_validation->set_rules('id_barang_keluar', 'Id Barang keluar', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        // $this->form_validation->set_rules('jeniss_id', 'Jenis Barang', 'required');
    }

    public function index($id_keluar)
    {
        $data['title'] = "Detail Barang Keluar";
        $data['id_keluar'] = $id_keluar;
        $data['barangs'] = $this->admin->getDetailKeluar($id_keluar);
        // $data['barangkeluar'] = $this->admin->getBarangkeluar();
        // $data['barang_stok'] = $this->admin->getBarangStok(); // Menyimpan data stok barang ke dalam variabel
        $this->template->load('templates/dashboard', 'detail_keluar/data', $data);
    }

    public function add($id_keluar) {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Keluar";
            $data['barang'] = $this->admin->get('barang');
            $data['id_detail_keluar'] = $id_keluar;
            $this->template->load('templates/dashboard', 'detail_keluar/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $this->db->trans_start();
            $barang = $this->admin->getBarangById($input['id_barang'])[0];
            if ($barang['stok'] < $input['jumlah']) {
                set_pesan('Stok barang kurang');
                redirect('detailkeluar/add/'.$id_keluar);
            }

            $insert = $this->admin->insert('detail_keluar', $_POST);
            $this->admin->kurangiStok($input['id_barang'], $input['jumlah']);
            $this->db->trans_complete();

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('detailkeluar/index/'.$_POST["id_barang_keluar"]);
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('detailkeluar/add/'.$id_keluar);
            }
        }
    }

    public function edit($id_detail_keluar,$id_keluar) {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $detail = $this->admin->getDetailKeluarById($id_detail_keluar)[0];
            $barang = $this->admin->getBarangById($detail['id_barang'])[0];
            
            $data['title'] = "Edit Barang Keluar";
            $data['barang'] = $barang['nama_barang'];
            $data['stock'] = $barang['stok'] +$detail['jumlah'];
            $data['id_detail_keluar'] = $id_keluar;
            $this->template->load('templates/dashboard', 'detail_keluar/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $this->db->trans_start();
            $barang = $this->admin->getBarangById($input['id_barang'])[0];
            if ($barang['stok'] < $input['jumlah']) {
                set_pesan('Stok barang kurang');
                redirect('detailkeluar/add/'.$id_keluar);
            }
            $detail = $this->admin->getDetailKeluarById($id_detail_keluar)[0];
            $barang = $this->admin->getBarangById($detail['id_barang'])[0];
            $stok = $barang['stok'] + $detail['jumlah'];
            $insert = $this->admin->update('detail_keluar', 'id_detail_keluar', $id_detail_keluar, $_POST);
            $total = $stok - $input['jumlah'];
            $this->admin->updateStok($input['id_barang'], $total);
            $this->db->trans_complete();

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('detailkeluar/index/'.$_POST["id_barang_keluar"]);
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('detailkeluar/add');
            }
        }
    }

    public function delete($id_detail_keluar,$id_keluar)
    {
        $this->db->trans_start();
        $detail = $this->admin->getDetailKeluarById($id_detail_keluar)[0];
        $this->admin->tambahStok($detail['id_barang'], $detail['jumlah']);
        $delete = $this->admin->delete('detail_keluar', 'id_detail_keluar', $id_detail_keluar);
        $this->db->trans_complete();
        if ($delete) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('/detailkeluar/index/'.$id_keluar);
    }
}
