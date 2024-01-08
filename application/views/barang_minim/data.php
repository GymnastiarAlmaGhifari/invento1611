<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Data Barang Minim
                </h4>
            </div>
            <!-- <div class="col-auto">
                <a href="<?= base_url('barang/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Barang
                    </span>
                </a>
            </div> -->
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped dt-responsive nowrap" id="dataTable" style="width: 100%;">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Supplier</th>
                    <th>Jenis</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barang) :
                    foreach ($barang as $b) :
                        // Tambahkan kondisi untuk menampilkan hanya barang dengan stok <= 3
                        if ($b['stok'] <= 3) :
                ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $b['id_barang']; ?></td>
                                <td><?= $b['nama_barang']; ?></td>
                                <td><?= $b['supp_id']; ?></td>
                                <td><?= $b['nama_jenis']; ?></td>
                                <td><?= $b['stok']; ?></td>
                                <td><?= $b['nama_satuan']; ?></td>
                                <td>
                                    <a href="<?= base_url('barang/edit/') . $b['id_barang'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
									<a onclick="confirmDelete('<?= base_url('barang/delete/') . $b['id_barang'] ?>')" class="btn btn-danger btn-circle btn-sm">
    <i class="fa fa-trash"></i>
</a>                                </td>
                            </tr>
                <?php
                        endif;
                    endforeach;
                else :
                ?>
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
            text: "Apakah Anda yakin ingin menghapus barang  ini?",
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
