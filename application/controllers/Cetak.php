<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Cetak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
        $this->load->library('CustomPDF');
    }



    // public function cetak setiap transaksi keluar
    public function pdf_keluar($getid)
    {
        if (empty($getid)) {
            echo "ID is not specified.";
            return;
        }

        $data = $this->admin->getBarangKeluarById($getid);

        // Check if $data is not empty
        if (!empty($data)) {
            $pdf = new FPDF();
            $pdf->AddPage();

            // header
            $pdf->SetFont('Arial', 'B', 20);
            $pdf->Cell(0, 10, 'Laporan Barang Keluar', 0, 1, 'C');  // Centered text with line
            $pdf->Ln(10);

            // saling bersebalahan
            $pdf->SetFont('Arial', '', 12);
            // disebelah kanan
            // disebelah kiri
            $pdf->Cell(43, 10, 'Kode Barang Keluar :', 0, 0, 'L');
            $pdf->Cell(60, 10, $data[0]['id_barang_keluar'], 0, 0, 'L');

            // disebelah kanan
            $pdf->Cell(35);  // Adding a blank cell for spacing
            $pdf->Cell(20, 10, 'Tanggal Keluar :', 0, 0, 'R');
            $pdf->Cell(32, 10, $this->admin->formatTanggalIndonesia($data[0]['tanggal_keluar']), 0, 1, 'R');


            $pdf->Ln(10);
            $pdf->Cell(0, 1, '', 'T', 2, 'C', 1);  // Draw a thicker line under the text
            // keluarkan semua barang yang keluar dari nama barang, jumlah keluar, dan satuan dengan bentuk table
            $pdf->Ln(10);


            // Table header
            $pdf->SetFont('Arial', 'B', 12);

            // Calculate the X coordinate to center the table
            $tableWidth = 180; // Sum of the cell widths
            $xCoordinate = ($pdf->GetPageWidth() - $tableWidth) / 2;

            // Set X coordinate to center the table
            $pdf->SetX($xCoordinate);

            $pdf->Cell(60, 10, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(60, 10, 'Supplier', 1, 0, 'C');
            $pdf->Cell(60, 10, 'Jumlah Keluar', 1, 1, 'C');

            // Table rows
            $pdf->SetFont('Arial', '', 12);
            foreach ($data as $row) {
                // Set X coordinate to center the table
                $pdf->SetX($xCoordinate);

                $pdf->Cell(60, 10, $row['nama_barang'], 1, 0, 'C');
                $pdf->Cell(60, 10, $row['supp_id'], 1, 0, 'C');
                $pdf->Cell(60, 10, $row['jumlah'], 1, 1, 'C');
            }


            // keluarkan keterangan
            $pdf->Cell(185, 20, 'Keterangan Transaksi :  ' . $data[0]['keterangan'], 0, 0, 'R');
            $pdf->Ln(30);

            // saling bersebalahan
            $pdf->SetFont('Arial', '', 12);
            // disebelah kanan
            // disebelah kiri
            $pdf->Cell(132, 10, 'Penerima', 0, 0, 'R');

            // disebelah kanan
            $pdf->Cell(30);  // Adding a blank cell for spacing
            $pdf->Cell(20, 10, 'Pengeluar', 0, 0, 'R');

            $pdf->Ln(25);
            $pdf->Cell(140, 10, '______________', 0, 0, 'R');
            $pdf->Cell(30);  // Adding a blank cell for spacing
            $pdf->Cell(20, 10, '______________', 0, 0, 'R');



            $pdf->Output();
        } else {
            // kemablikan ke halaman barang keluar dan send pesan error
            set_pesan('barang yang keluar masih kosong', false, 'error');

            redirect('barangkeluar');
        }
    }

    // buat pdf laporan barang masuk
    public function pdf_masuk($getid)
    {
        if (empty($getid)) {
            echo "ID is not specified.";
            return;
        }

        $data = $this->admin->getBarangMasukById($getid);

        // Check if $data is not empty
        if (!empty($data)) {
            $pdf = new FPDF();
            $pdf->AddPage();

            // header
            $pdf->SetFont('Arial', 'B', 20);
            $pdf->Cell(0, 10, 'Laporan Barang Masuk', 0, 1, 'C');  // Centered text with line
            $pdf->Ln(10);

            // saling bersebalahan
            $pdf->SetFont('Arial', '', 12);
            // disebelah kanan
            // disebelah kiri
            $pdf->Cell(43, 10, 'Kode Barang Masuk :', 0, 0, 'L');
            $pdf->Cell(60, 10, $data[0]['id_barang_masuk'], 0, 0, 'L');

            // disebelah kanan
            $pdf->Cell(35);  // Adding a blank cell for spacing
            $pdf->Cell(20, 10, 'Tanggal Masuk :', 0, 0, 'R');
            $pdf->Cell(32, 10, $this->admin->formatTanggalIndonesia($data[0]['tanggal_masuk']), 0, 1, 'R');
            $pdf->Ln(10);
            $pdf->Cell(0, 1, '', 'T', 2, 'C', 1);  // Draw a thicker line under the text
            // keluarkan semua barang yang masuk dari nama barang, jumlah masuk, dan satuan dengan bentuk table
            $pdf->Ln(10);

            // Table header
            $pdf->SetFont('Arial', 'B', 12);

            // Calculate the X coordinate to center the table
            $tableWidth = 180; // Sum of the cell widths
            $xCoordinate = ($pdf->GetPageWidth() - $tableWidth) / 2;

            // Set X coordinate to center the table
            $pdf->SetX($xCoordinate);

            $pdf->Cell(60, 10, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(60, 10, 'Supplier', 1, 0, 'C');
            $pdf->Cell(60, 10, 'Jumlah Masuk', 1, 1, 'C');

            // Table rows

            $pdf->SetFont('Arial', '', 12);

            foreach ($data as $row) {
                // Set X coordinate to center the table
                $pdf->SetX($xCoordinate);

                $pdf->Cell(60, 10, $row['nama_barang'], 1, 0, 'C');
                $pdf->Cell(60, 10, $row['supp_id'], 1, 0, 'C');
                $pdf->Cell(60, 10, $row['jumlah'], 1, 1, 'C');
            }

            // keluarkan keterangan
            $pdf->Ln(30);

            // saling bersebalahan
            $pdf->SetFont('Arial', '', 12);
            // disebelah kanan
            // disebelah kiri
            $pdf->Cell(132, 10, 'Penerima', 0, 0, 'R');

            // disebelah kanan
            $pdf->Cell(30);  // Adding a blank cell for spacing

            $pdf->Cell(20, 10, 'Pemasuk', 0, 0, 'R');

            $pdf->Ln(25);
            $pdf->Cell(140, 10, '______________', 0, 0, 'R');

            $pdf->Cell(30);  // Adding a blank cell for spacing
            $pdf->Cell(20, 10, '______________', 0, 0, 'R');

            $pdf->Output();
        } else {
            set_pesan('barang yang masuk masih kosong', false, 'error');

            redirect('barangmasuk');
        }
    }
}
