<div class="card">
    <div class="card-body">
        <div class="row form-group">
            <label class="col-md-4 text-md-right" for="barang_id">Barang</label>
            <div class="col-md-5">
                <div class="input-group">
                    <select name="barang_id" id="barang_id" class="custom-select">
                        <option value="" selected disabled>Pilih Barang</option>
                        <?php foreach ($barang as $b) : ?>
                            <option <?= $this->uri->segment(3) == $b['id_barang'] ? 'selected' : '';  ?> <?= set_select('barang_id', $b['id_barang']) ?> value="<?= $b['id_barang'] ?>"><?= $b['id_barang'] . ' | ' . $b['nama_barang'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="input-group-append">
                        <a class="btn btn-primary" href="<?= base_url('barang/add'); ?>"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <?= form_error('barang_id', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-md-4 text-md-right" for="jeniss_id">Jenis sBarang</label>
            <div class="col-md-5">
                <div class="input-group">
                    <select name="jeniss_id" id="jeniss_id" class="custom-select">
                        <option value="" selected disabled>Pilih Jenis Barang</option>
                        <?php foreach ($jenis as $j) : ?>
                            <option <?= set_select('jeniss_id', $j['id_jenis']) ?> value="<?= $j['nama_jenis'] ?>"><?= $j['nama_jenis'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="input-group-append">
                        <a class="btn btn-primary" href="<?= base_url('jenis/add'); ?>"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <?= form_error('jenis_id', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-md-4 text-md-right" for="stok">Stok</label>
            <div class="col-md-5">
                <input readonly="readonly" id="stok" type="number" class="form-control">
            </div>
        </div>
        <div class="row form-group">
            <label class="col-md-4 text-md-right" for="jumlah_masuk">Jumlah Masuk</label>
            <div class="col-md-5">
                <div class="input-group">
                    <input value="<?= set_value('jumlah_masuk'); ?>" name="jumlah_masuk" id="jumlah_masuk" type="number" class="form-control" placeholder="Jumlah Masuk...">
                    <div class="input-group-append">
                        <span class="input-group-text" id="satuan">Satuan</span>
                    </div>
                </div>
                <?= form_error('jumlah_masuk', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-md-4 text-md-right" for="total_stok">Total Stok</label>
            <div class="col-md-5">
                <input readonly="readonly" id="total_stok" type="number" class="form-control">
            </div>
        </div>
    </div>
</div>