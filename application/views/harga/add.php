<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Tambah Harga
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('harga') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <?= form_open(); ?>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="nm_barang">Nama Barang</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="nm_barang" id="nm_barang" class="custom-select">
                                <option value="" selected disabled>Pilih Barang</option>
                                <?php foreach ($barang as $b) : ?>
                                    <option <?= $this->uri->segment(3) == $b['nama_barang'] ? 'selected' : '';  ?> <?= set_select('nm_barang', $b['id_barang']) ?> value="<?= $b['nama_barang'] ?>"><?= $b['id_barang'] . ' | ' . $b['nama_barang'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?= form_error('nm_barang', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="harga_modal">Harga Modal</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('harga_modal'); ?>" name="harga_modal" id="harga_modal" type="text" class="form-control" placeholder="Harga Modal...">
                        <?= form_error('harga_modal', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="harga_barang">Harga Jual</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('harga_barang'); ?>" name="harga_barang" id="harga_barang" type="text" class="form-control" placeholder="Harga Jual...">
                        <?= form_error('harga_barang', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>