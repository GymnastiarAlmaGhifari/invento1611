<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Input Barang Keluar
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('detailmasuk/index/' . $id_detail_masuk) ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <?= form_open('', [], ['id_barang_masuk' => $id_detail_masuk,]); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row form-group">
                            <label class="col-md-4 text-md-right" for="id_barang">Id Barang</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input readonly="readonly"  name="id_barang" id="id_barang" value="<?= $barang?>"class="form-control">
                                </div>
                                <?= form_error('id_barang', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label class="col-md-4 text-md-right" for="stok">Stok</label>
                            <div class="col-md-5">
                                <input readonly="readonly" value="<?= $stock?>" id="stok" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 text-md-right" for="jumlah">Jumlah Masuk</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input value="<?= set_value('jumlah'); ?>" name="jumlah" id="jumlah" type="number" class="form-control" placeholder="Jumlah Masuk...">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="satuan">Satuan</span>
                                    </div>
                                </div>
                                <?= form_error('jumlah', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 text-md-right" for="total_stok">Total Stok</label>
                            <div class="col-md-5">
                                <input readonly="readonly" value="<?= $stock?>" id="total_stok" type="number" class="form-control">
                            </div>
                        </div>
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