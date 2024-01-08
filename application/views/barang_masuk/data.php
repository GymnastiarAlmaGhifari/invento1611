<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Barang Masuk
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangmasuk/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Barang Masuk
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
                    <th>Tgl Masuk</th>
                    <th>Supplier</th>
					<th>Berkas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barangmasuk) :
                    foreach ($barangmasuk as $bm) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bm['id_barang_masuk']; ?></td>
                            <td><?= $bm['tanggal_masuk']; ?></td>
                            <td><?= $bm['nama_supplier']; ?></td>
							<td><?= $bm['berkas']; ?></td>

                            <td>
                            <a href="<?= base_url('barangmasuk/edit/') . $bm['id_barang_masuk'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
							<a onclick="confirmDelete('<?= base_url('barangmasuk/delete/') . $bm['id_barang_masuk'] ?>')" class="btn btn-danger btn-circle btn-sm">
<i class="fa fa-trash"></i>
</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Pastikan Bootstrap dan jQuery sudah dimuat -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert CSS dan JavaScript -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus barang masuk ini?",
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
