<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangkeluar extends CI_Controller
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
        $data['title'] = "Barang keluar";
        $data['barangkeluar'] = $this->admin->getBarangkeluar();
        $data['barang_stok'] = $this->admin->getBarangStok(); // Menyimpan data stok barang ke dalam variabel
        $this->template->load('templates/dashboard', 'barang_keluar/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required|trim');
        // $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        //$this->form_validation->set_rules('jeniss_id', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        // $input = $this->input->post('barang_id', true);
        // if ($this->admin) {
        //     $stok = $this->admin->get('barang', ['id_barang' => $input])['stok'];
        // }
        // $stok_valid = $stok + 1;

        // $this->form_validation->set_rules(
        //     'jumlah_keluar',
        //     'Jumlah Keluar',
        //     "required|trim|numeric|greater_than[0]|less_than[{$stok_valid}]",
        //     [
        //         'less_than' => "Jumlah Keluar tidak boleh lebih dari {$stok}"
        //     ]
        // );
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Keluar";
            $data['jenis'] = $this->admin->get('jenis');
            $data['barang'] = $this->admin->get('barang', null, ['stok >' => 0]);

            // Mendapatkan dan men-generate kode transaksi barang keluar
            $kode = 'T-BK-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_keluar', 'id_barang_keluar', $kode);
            if ($kode_terakhir) {
                $kode_tambah = substr($kode_terakhir, -5, 5);
            }else {
                $kode_tambah = 0;
            }
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_keluar'] = $kode . $number;

            $this->template->load('templates/dashboard', 'barang_keluar/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('barang_keluar', $input);


            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('detailkeluar/index/' . $input["id_barang_keluar"]);
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangkeluar/add');
            }
        }
    }
    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Keluar";
            $data['barang'] = $this->admin->get('barang');
            // $data['tanggal_keluar'] = $this->admin->get('tanggal_keluar');
            // $data['jenis'] = $this->admin->get('jenis');
            // $data['keterangan'] = $this->admin->get('keterangan');
            $data['barangkeluar'] = $this->admin->get('barang_keluar', ['id_barang_keluar' => $id]);
            // $data['stok'] = $this->admin->cekStok($data['barangkeluar']['barang_id']);
            $this->template->load('templates/dashboard', 'barang_keluar/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('barang_keluar', 'id_barang_keluar', $id, $input);

            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('barangkeluar');
            } else {
                set_pesan('gagal menyimpan data');
                redirect('barangkeluar/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_keluar', 'id_barang_keluar', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangkeluar');
    }
}
