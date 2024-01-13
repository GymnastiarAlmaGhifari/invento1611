<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Barang Keluar
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangkeluar/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Barang Keluar
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Detail Barang</th>
                    <th>Keterangan</th>
                    <th>Berkas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barangkeluar) :
                    foreach ($barangkeluar as $bk) :
                ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bk['id_barang_keluar']; ?></td>
                            <td><?= $bk['tanggal_keluar']; ?></td>
                            <td>
                                <a href="<?= base_url('detailkeluar/index/') . $bk['id_barang_keluar'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-boxes"></i></a>
                            </td>
                            <td><?= $bk['keterangan']; ?></td>
                            <td><?= $bk['berkas']; ?></td>

                            <td>
                                <a target="_blank" href="<?= base_url('cetak/pdf_keluar/') . $bk['id_barang_keluar'] ?>" class="btn btn-light btn-circle btn-sm"><i class="fas fa-print"></i></a>
                                <a href="<?= base_url('barangkeluar/edit/') . $bk['id_barang_keluar'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="confirmDelete('<?= base_url('barangkeluar/delete/') . $bk['id_barang_keluar'] ?>')" class="btn btn-danger btn-circle btn-sm">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>



<!-- SweetAlert CSS dan JavaScript -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus barang Keluar ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>