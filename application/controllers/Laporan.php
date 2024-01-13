<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barang_masuk,barang_keluar]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');
        $data['barang_stok'] = $this->admin->getBarangStok(); // Menyimpan data stok barang ke dalam variabel
        if ($this->form_validation->run() == false) {
            $data['title'] = "Laporan Transaksi";
            $this->template->load('templates/dashboard', 'laporan/form', $data);
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            if (strtotime($akhir) < strtotime($mulai)) {
                set_pesan('tanggal akhir harus setalah tanggal mulai');
                redirect('laporan');
            }

            $query = '';
            if ($table == 'barang_masuk') {
                $query = $this->admin->getBarangMasuk(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else {
                $query = $this->admin->getBarangKeluar(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            }

            $this->_cetak($query, $table, $tanggal);
        }
    }

    private function _cetak($data, $table_, $tanggal)
    {
        $this->load->library('CustomPDF');
        $table = $table_ == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar';

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(190, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        if ($table_ == 'barang_masuk') :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Tgl Masuk', 1, 0, 'C');
            $pdf->Cell(35, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(60, 7, 'Supplier', 1, 0, 'C');
            $pdf->Cell(50, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $barangs = $this->admin->getBarangMasukData($d['id_barang_masuk']);
                
                $namaBarangLines = count($barangs);
                $namaBarangHeight = 7 * $namaBarangLines;
                $remainingHeight = max($namaBarangHeight, 7);
                $namaBarangs = "";
                foreach ($barangs as $key => $value) {
                    $namaBarangs .= $value->nama_barang .' '. $value->jumlah.' '.$value->nama_satuan;
                    if ($key-1 != $namaBarangLines) {
                        $namaBarangs .= "\n";
                    }
                }
                

                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, $remainingHeight, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(25, $remainingHeight, $d['tanggal_masuk'], 1, 0, 'C');
                $pdf->Cell(35, $remainingHeight, $d['id_barang_masuk'], 1, 0, 'C');
                $pdf->Cell(60, $remainingHeight, $d['nama_supplier'], 1, 0, 'L');
                $pdf->MultiCell(50, 7, $namaBarangs, 1, 'L');
            }
        else :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Tgl Keluar', 1, 0, 'C');
            $pdf->Cell(35, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(70, 7, 'Keterangan', 1, 0, 'C');
            $pdf->Cell(50, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $barangs = $this->admin->getBarangKeluarData($d['id_barang_keluar']);
                $namaBarangLines = count($barangs);
                $namaBarangHeight = 7 * $namaBarangLines;
                $remainingHeight = max($namaBarangHeight, 7);
                $namaBarangs = "";
                foreach ($barangs as $key => $value) {
                    $namaBarangs .= $value->nama_barang .' '. $value->jumlah.' '.$value->nama_satuan;
                    if ($key-1 != $namaBarangLines) {
                        $namaBarangs .= "\n";
                    }
                }

                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, $remainingHeight, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(25, $remainingHeight, $d['tanggal_keluar'], 1, 0, 'C');
                $pdf->Cell(35, $remainingHeight, $d['id_barang_keluar'], 1, 0, 'C');
                $pdf->Cell(70, $remainingHeight, $d['keterangan'], 1, 0, 'L');
                $pdf->MultiCell(50, 7, $namaBarangs, 1, 'L');
            }
        endif;

        $file_name = $table . ' ' . $tanggal;
        $pdf->Output('I', $file_name);
    }
}
