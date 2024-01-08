<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangmasuk extends CI_Controller
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
        $data['title'] = "Barang Masuk";
        $data['barangmasuk'] = $this->admin->getBarangMasuk();
        $data['barang_stok'] = $this->admin->getBarangStok(); // Menyimpan data stok barang ke dalam variabel
        $this->template->load('templates/dashboard', 'barang_masuk/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        $this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|trim|numeric|greater_than[0]');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Masuk";
            $data['supplier'] = $this->admin->get('supplier');
            $data['barang'] = $this->admin->get('barang');
            $data['jenis'] = $this->admin->get('jenis');

            /// Mendapatkan dan men-generate kode transaksi barang masuk
            $kode = 'T-BM-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_masuk', 'id_barang_masuk', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_masuk'] = $kode . $number;

            $this->template->load('templates/dashboard', 'barang_masuk/add', $data);
        } else {
            $input = $this->input->post(null, true);
            if($_FILES['berkas']['name'] != ""){
                $input['berkas'] = $this->upload_berkas('berkas')['file_name'];
            }
            $insert = $this->admin->insert('barang_masuk', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barangmasuk');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangmasuk/add');
            }
        }
    }
    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Masuk";
            $data['barang'] = $this->admin->get('barang');
            // $data['tanggal_keluar'] = $this->admin->get('tanggal_keluar');
            //$data['jenis'] = $this->admin->get('jenis');
            // $data['keterangan'] = $this->admin->get('keterangan');
            $data['barangmasuk'] = $this->admin->get('barang_masuk', ['id_barang_masuk' => $id]);
            $data['stok'] = $this->admin->cekStok($data['barangmasuk']['barang_id']);
            $data['supplier'] = $this->admin->get('supplier');
            $this->template->load('templates/dashboard', 'barang_masuk/edit', $data);
       } else {

            $input = $this->input->post(null, true);

            if($_FILES['berkas']['name'] != ""){
                $input['berkas'] = $this->upload_berkas('berkas')['file_name'];
            }
            $update = $this->admin->update('barang_masuk', 'id_barang_masuk', $id, $input);

            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('barangmasuk');
            } else {
                set_pesan('gagal menyimpan data');
                redirect('barangmasuk/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_masuk', 'id_barang_masuk', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangmasuk');
    }

    private function upload_berkas($filename){
        $config['upload_path']          = './berkas/';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['max_size']             = 4000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;
        $this->load->library('upload', $config);
        

        if (!$this->upload->do_upload($filename)) {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
            die;
        }

        return $this->upload->data();
    }
}


