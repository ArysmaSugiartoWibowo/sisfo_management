<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Data Bidang Yang Dibutuhkan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
        <form action="<?php echo site_url('bidang/store'); ?>" method="POST">
            <div class="form-group">
                <label for="nama_bidang">Nama Bidang</label>
                <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Non Aktif">Non Aktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        </div>
                </div>
            </div>
        </div>
    </div>
