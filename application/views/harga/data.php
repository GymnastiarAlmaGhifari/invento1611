<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Data Harga Barang
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('harga/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Harga Barang
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Nama Barang</th>
                    <th>Harga Modal</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($harga) :
                    foreach ($harga as $hr) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $hr['nm_barang']; ?></td>
                            <td><?= $hr['harga_modal']; ?></td>
                            <td><?= $hr['harga_barang']; ?></td>
                            <td>
                                <a href="<?= base_url('harga/edit/') . $hr['id_harga'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
								<a onclick="confirmDelete('<?= base_url('harga/delete/') . $hr['id_harga'] ?>')" class="btn btn-danger btn-circle btn-sm">
    <i class="fa fa-trash"></i>
</a>                                                </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3" class="text-center">
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
            text: "Apakah Anda yakin ingin menghapus Data Harga ini?",
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
