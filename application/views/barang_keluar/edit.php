<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Edit Barang Keluar
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barangkeluar') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
          <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
              <?= form_open('', [], ['id_barang_keluar' => $barangkeluar['id_barang_keluar']]); ?>
              <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="id_barang_keluar">ID Transaksi Barang Keluar</label>
                    <div class="col-md-4">
                        <input value="<?= $barangkeluar['id_barang_keluar']; ?>" type="text" readonly="readonly" class="form-control">
                        <?= form_error('id_barang_keluar', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tanggal_keluar">Tanggal Keluar</label>
                    <div class="col-md-4">
                        <input value="<?= set_value('tanggal_keluar', $barangkeluar['tanggal_keluar']); ?>" name="tanggal_keluar" id="tanggal_keluar" type="text" class="form-control date" placeholder="Tanggal Keluar...">
                        <?= form_error('tanggal_keluar', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                    <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="keterangan">Keterangan</label>
                    <div class="col-md-5">
                        <input value="<?= set_value('keterangan', $barangkeluar['keterangan']); ?>" name="keterangan" id="keterangan" type="text" class="form-control" >
                        <?= form_error('keterangan', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="berkas">Unggah Berkas (PDF/Gambar)</label>
                    <div class="col-md-5">
                        <input type="file" name="berkas" accept=".pdf, .jpg, .jpeg, .png">
                        <?= form_error('berkas', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col offset-md-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
