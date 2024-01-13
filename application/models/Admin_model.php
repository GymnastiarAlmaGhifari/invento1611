<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function get($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    public function update($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }

    public function insert($table, $data, $batch = false)
    {
        return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
    }

    public function delete($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }

    public function getUsers($id)
    {
        /**
         * ID disini adalah untuk data yang tidak ingin ditampilkan. 
         * Maksud saya disini adalah 
         * tidak ingin menampilkan data user yang digunakan, 
         * pada managemen data user
         */
        $this->db->where('id_user !=', $id);
        return $this->db->get('user')->result_array();
    }

    public function getBarang()
    {
        $this->db->join('jenis j', 'b.jenis_id = j.id_jenis');
        $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('id_barang');
        return $this->db->get('barang b')->result_array();
    }

    public function getBarangMasuk($limit = null, $id_barang = null, $range = null)
    {
        $this->db->select('*');
        $this->db->join('user u', 'bm.user_id = u.id_user');
        $this->db->join('supplier sp', 'bm.supplier_id = sp.id_supplier');
        // $this->db->join('barang b', 'bm.barang_id = b.id_barang');
        // $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        if ($limit != null) {
            $this->db->limit($limit);
        }

        if ($id_barang != null) {
            $this->db->where('id_barang', $id_barang);
        }

        if ($range != null) {
            $this->db->where('tanggal_masuk' . ' >=', $range['mulai']);
            $this->db->where('tanggal_masuk' . ' <=', $range['akhir']);
        }

        $this->db->order_by('id_barang_masuk', 'DESC');
        return $this->db->get('barang_masuk bm')->result_array();
    }

    public function getDetailMasuk($id_barang_masuk)
    {
        $this->db->select('*');
        $this->db->from('detail_masuk');
        $this->db->join('barang', 'detail_masuk.id_barang = barang.id_barang');
        $this->db->where('id_barang_masuk', $id_barang_masuk);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBarangKeluar($limit = null, $id_barang = null, $range = null)
    {
        $this->db->select('*');
        $this->db->join('user u', 'bk.user_id = u.id_user');
        // $this->db->join('barang b', 'bk.barang_id = b.id_barang');
        // $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
        if ($limit != null) {
            $this->db->limit($limit);
        }
        if ($id_barang != null) {
            $this->db->where('id_barang', $id_barang);
        }
        if ($range != null) {
            $this->db->where('tanggal_keluar' . ' >=', $range['mulai']);
            $this->db->where('tanggal_keluar' . ' <=', $range['akhir']);
        }
        $this->db->order_by('id_barang_keluar', 'DESC');
        return $this->db->get('barang_keluar bk')->result_array();
    }

    // fungsi yang mengambil dari database menggunakan parameter id barang keluar mengambil semua yang berlasi dengan barang dan detail keluar
    public function getBarangKeluarById($id_barang_keluar)
    {
        $this->db->select('*');
        $this->db->from('barang_keluar');
        $this->db->join('detail_keluar', 'barang_keluar.id_barang_keluar = detail_keluar.id_barang_keluar');
        $this->db->join('barang', 'detail_keluar.id_barang = barang.id_barang');
        $this->db->join('satuan', 'barang.satuan_id = satuan.id_satuan');
        $this->db->join('jenis', 'barang.jenis_id = jenis.id_jenis');
        $this->db->where('barang_keluar.id_barang_keluar', $id_barang_keluar);
        $query = $this->db->get();
        return $query->result_array();
    }

    // fungsi yang mengambil dari database menggunakan parameter id barang keluar mengambil semua yang berlasi dengan barang dan detail keluar
    public function getBarangMasukById($id_barang_masuk)
    {
        $this->db->select('*');
        $this->db->from('barang_masuk');
        $this->db->join('detail_masuk', 'barang_masuk.id_barang_masuk = detail_masuk.id_barang_masuk');
        $this->db->join('barang', 'detail_masuk.id_barang = barang.id_barang');
        $this->db->join('satuan', 'barang.satuan_id = satuan.id_satuan');
        $this->db->join('jenis', 'barang.jenis_id = jenis.id_jenis');
        $this->db->where('barang_masuk.id_barang_masuk', $id_barang_masuk);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDetailKeluar($id_barang_keluar)
    {
        $this->db->select('*');
        $this->db->from('detail_keluar');
        $this->db->join('barang', 'detail_keluar.id_barang = barang.id_barang');
        $this->db->where('detail_keluar.id_barang_keluar', $id_barang_keluar);
        $query = $this->db->get();
        return $query->result_array();
    }



    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function sum($table, $field)
    {
        $this->db->select_sum($field);
        return $this->db->get($table)->row_array()[$field];
    }

    public function min($table, $field, $min)
    {
        $field = $field . ' <=';
        $this->db->where($field, $min);
        return $this->db->get($table)->result_array();
    }

    public function chartBarangMasuk($bulan)
    {
        $like = 'T-BM-' . date('y') . $bulan;
        $this->db->like('id_barang_masuk', $like, 'after');
        return count($this->db->get('barang_masuk')->result_array());
    }

    public function chartBarangKeluar($bulan)
    {
        $like = 'T-BK-' . date('y') . $bulan;
        $this->db->like('id_barang_keluar', $like, 'after');
        return count($this->db->get('barang_keluar')->result_array());
    }

    public function laporan($table, $mulai, $akhir)
    {
        $tgl = $table == 'barang_masuk' ? 'tanggal_masuk' : 'tanggal_keluar';
        $this->db->where($tgl . ' >=', $mulai);
        $this->db->where($tgl . ' <=', $akhir);
        return $this->db->get($table)->result_array();
    }

    public function cekStok($id)
    {
        $this->db->join('satuan s', 'b.satuan_id=s.id_satuan');
        return $this->db->get_where('barang b', ['id_barang' => $id])->row_array();
    }
    public function getBarangStok()
    {
        $this->db->select('id_barang, nama_barang, stok');
        $query = $this->db->get('barang');
        return $query->result();
    }

    public function updateStok($id_barang, $jumlah)
    {
        $this->db->set('stok', $jumlah);
        $this->db->where('id_barang', $id_barang);
        $this->db->update('barang');
    }

    public function getDetailMasukById($id_detail_masuk)
    {
        $this->db->where('id_detail_masuk', $id_detail_masuk);
        $query = $this->db->get('detail_masuk');
        return $query->result_array();
    }
    public function getDetailKeluarById($id_detail_keluar)
    {
        $this->db->where('id_detail_keluar', $id_detail_keluar);
        $query = $this->db->get('detail_keluar');
        return $query->result_array();
    }

    public function getBarangById($id_barang)
    {
        $this->db->where('id_barang', $id_barang);
        $query = $this->db->get('barang');
        return $query->result_array();
    }

    public function tambahStok($id_barang, $jumlah)
    {
        $this->db->set('stok', 'stok + ' . $jumlah, FALSE);
        $this->db->where('id_barang', $id_barang);
        $this->db->update('barang');
    }

    public function kurangiStok($id_barang, $jumlah)
    {
        $this->db->set('stok', 'stok - ' . $jumlah, FALSE);
        $this->db->where('id_barang', $id_barang);
        $this->db->update('barang');
    }
    public function formatTanggalIndonesia($tanggal)
    {
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $timestamp = strtotime($tanggal);
        $formattedDate = date('d', $timestamp) . ' ' . $bulan[date('n', $timestamp) - 1] . ' ' . date('Y', $timestamp);

        return $formattedDate;
    }

    function getBarangMasukData($id_barang_masuk)
    {
        $CI = &get_instance();
        $CI->db->select('detail_masuk.jumlah, barang.nama_barang, satuan.nama_satuan');
        $CI->db->from('detail_masuk');
        $CI->db->join('barang', 'barang.id_barang = detail_masuk.id_barang');
        $CI->db->join('satuan', 'satuan.id_satuan = barang.satuan_id');
        $CI->db->where('detail_masuk.id_barang_masuk', $id_barang_masuk);
        $query = $CI->db->get();
        return $query->result();
    }

    function getBarangKeluarData($id_barang_keluar) {
        $CI =& get_instance();
        $CI->db->select('detail_keluar.jumlah, barang.nama_barang, satuan.nama_satuan');
        $CI->db->from('detail_keluar');
        $CI->db->join('barang', 'barang.id_barang = detail_keluar.id_barang');
        $CI->db->join('satuan', 'satuan.id_satuan = barang.satuan_id');
        $CI->db->where('detail_keluar.id_barang_keluar', $id_barang_keluar);
        $query = $CI->db->get();
        return $query->result();
    }
    
}
